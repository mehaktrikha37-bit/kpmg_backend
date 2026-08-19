<?php

namespace App\Repositories\Lead\Interfaces;

use App\Models\LeadCustomerTimeline;
use Illuminate\Support\Collection;

interface LeadCustomerTimelineRepositoryInterface
{
    public function getByCustomerId(int $customerId): Collection;
    public function create(array $data): LeadCustomerTimeline;
}
