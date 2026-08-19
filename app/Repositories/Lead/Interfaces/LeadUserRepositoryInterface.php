<?php

namespace App\Repositories\Lead\Interfaces;

use App\Models\LeadUser;
use Illuminate\Support\Collection;

interface LeadUserRepositoryInterface
{
    public function all(array $filters = []): Collection;
    public function find(int $id): ?LeadUser;
    public function findByMobile(string $mobile): ?LeadUser;
    public function create(array $data): LeadUser;
    public function update(int $id, array $data): ?LeadUser;
    public function delete(int $id): bool;
    public function getLatestEmployeeId(): ?string;
}
