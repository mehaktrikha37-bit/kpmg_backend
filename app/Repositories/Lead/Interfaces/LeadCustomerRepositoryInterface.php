<?php

namespace App\Repositories\Lead\Interfaces;

use App\Models\LeadCustomer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LeadCustomerRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): ?LeadCustomer;
    public function findByMobile(string $mobile): ?LeadCustomer;
    public function findByMobileAndBranch(string $mobile, string $branch): ?LeadCustomer;
    public function create(array $data): LeadCustomer;
    public function update(int $id, array $data): ?LeadCustomer;
    public function delete(int $id): bool;
    public function getCounts(array $conditions = []): int;
}
