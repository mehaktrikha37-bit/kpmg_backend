<?php

namespace App\Repositories\Lead;

use App\Models\LeadCustomerTimeline;
use App\Repositories\Lead\Interfaces\LeadCustomerTimelineRepositoryInterface;
use Illuminate\Support\Collection;

class LeadCustomerTimelineRepository implements LeadCustomerTimelineRepositoryInterface
{
    public function getByCustomerId(int $customerId): Collection
    {
        return LeadCustomerTimeline::where('customer_id', $customerId)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data): LeadCustomerTimeline
    {
        $timeline = LeadCustomerTimeline::create($data);
        return LeadCustomerTimeline::with('creator')->find($timeline->id);
    }
}
