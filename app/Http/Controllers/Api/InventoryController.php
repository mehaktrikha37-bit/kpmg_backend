<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockItemRequest;
use App\Http\Requests\StoreStockUsageRequest;
use App\Models\StockItem;
use App\Models\StockUsage;
use App\Models\Device;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Services\StockCodeService;
use App\Services\AuditService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = StockItem::query();
        
        $user = $request->user();
        if ($user->role !== 'super_admin') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhere('part_number', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('compatible_devices', 'like', "%{$search}%");
            });
        }

        $page = $request->page ?? 1;
        $limit = $request->limit ?? 20;
        
        $total = clone $query;
        $totalCount = $total->count();
        
        $items = $query->orderBy('name', 'asc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $items,
            'total' => $totalCount,
            'page' => (int) $page,
            'limit' => (int) $limit,
            'hasMore' => ($page * $limit) < $totalCount,
            'message' => 'Inventory retrieved',
        ]);
    }

    public function store(StoreStockItemRequest $request)
    {
        $data = $request->validated();
        
        $data['item_code'] = StockCodeService::generate();
        $user = $request->user();
        $branch = Branch::findOrFail($data['branch_id']);
        
        $data['branch_name'] = $branch->name;
        $data['added_by'] = $user->id;

        if (isset($data['slip_photo_base64'])) {
            $data['slip_photo_path'] = $this->saveBase64Image($data['slip_photo_base64']);
            unset($data['slip_photo_base64']);
        }

        $item = StockItem::create($data);
        
        AuditService::log('create', 'inventory', $item->id, StockItem::class, $item->name);

        return response()->json([
            'success' => true,
            'data' => $item,
            'message' => 'Stock item added successfully',
        ], 201);
    }

    public function update(StoreStockItemRequest $request, $id)
    {
        $item = StockItem::findOrFail($id);
        $data = $request->validated();
        
        if ($data['branch_id'] != $item->branch_id) {
            $branch = Branch::findOrFail($data['branch_id']);
            $data['branch_name'] = $branch->name;
        }
        
        if (isset($data['slip_photo_base64'])) {
            if ($item->slip_photo_path) {
                Storage::disk('public')->delete($item->slip_photo_path);
            }
            $data['slip_photo_path'] = $this->saveBase64Image($data['slip_photo_base64']);
            unset($data['slip_photo_base64']);
        }
        
        $item->update($data);
        
        AuditService::log('update', 'inventory', $item->id, StockItem::class);

        return response()->json([
            'success' => true,
            'data' => $item,
            'message' => 'Stock item updated successfully',
        ]);
    }

    public function usage(StoreStockUsageRequest $request)
    {
        $data = $request->validated();
        
        $item = StockItem::findOrFail($data['stock_item_id']);
        if ($item->quantity < $data['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock quantity',
            ], 400);
        }

        $device = Device::findOrFail($data['device_id']);
        $user = $request->user();

        $item->quantity -= $data['quantity'];
        $item->save();

        $usage = StockUsage::create([
            'device_id' => $device->id,
            'job_number' => $device->job_number,
            'stock_item_id' => $item->id,
            'item_name' => $item->name,
            'quantity' => $data['quantity'],
            'selling_price' => $data['selling_price'],
            'added_by' => $user->id,
            'branch_id' => $user->branch_id,
            'used_at' => now(),
        ]);
        
        AuditService::log('usage', 'inventory', $usage->id, StockUsage::class, "Added to {$device->job_number}");

        return response()->json([
            'success' => true,
            'data' => [
                'usage' => $usage,
                'updatedItem' => $item
            ],
            'message' => 'Part added to job',
        ]);
    }

    public function usageByDevice($deviceId)
    {
        // Join with employees to get adder name
        $usages = StockUsage::where('device_id', $deviceId)
            ->join('employees', 'stock_usages.added_by', '=', 'employees.id')
            ->select('stock_usages.*', 'employees.name as addedBy')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $usages,
            'message' => 'Usage retrieved',
        ]);
    }

    public function history(Request $request)
    {
        $query = StockUsage::query()
            ->join('employees', 'stock_usages.added_by', '=', 'employees.id')
            ->select('stock_usages.*', 'employees.name as addedBy');

        $user = $request->user();
        if ($user->role !== 'super_admin') {
            $query->where('stock_usages.branch_id', $user->branch_id);
        }

        $history = $query->orderBy('used_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $history,
            'message' => 'Usage history retrieved',
        ]);
    }

    private function saveBase64Image($base64String)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $data = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
            
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            
            $data = base64_decode($data);
            
            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $fileName = Str::uuid() . '.' . $type;
        $filePath = 'inventory_slips/' . $fileName;
        
        Storage::disk('public')->put($filePath, $data);
        
        return $filePath;
    }
}
