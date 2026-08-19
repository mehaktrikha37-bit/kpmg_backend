<?php

namespace App\Repositories\Lead;

use App\Models\LeadUser;
use App\Repositories\Lead\Interfaces\LeadUserRepositoryInterface;
use Illuminate\Support\Collection;

class LeadUserRepository implements LeadUserRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = LeadUser::query()->where('role', 'sales_executive');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name', 'asc')->get();
    }

    public function find(int $id): ?LeadUser
    {
        return LeadUser::find($id);
    }

    public function findByMobile(string $mobile): ?LeadUser
    {
        return LeadUser::where('mobile', $mobile)->first();
    }

    public function create(array $data): LeadUser
    {
        return LeadUser::create($data);
    }

    public function update(int $id, array $data): ?LeadUser
    {
        $user = LeadUser::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $user = LeadUser::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function getLatestEmployeeId(): ?string
    {
        $latestUser = LeadUser::where('employee_id', 'like', 'EMP%')
            ->orderBy('employee_id', 'desc')
            ->first();

        return $latestUser ? $latestUser->employee_id : null;
    }
}
