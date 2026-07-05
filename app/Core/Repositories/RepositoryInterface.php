<?php

namespace App\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    public function all(array $columns = ['*']): Collection;
    
    public function find(int|string $id, array $columns = ['*']): ?Model;
    
    public function findOrFail(int|string $id, array $columns = ['*']): Model;
    
    public function create(array $data): Model;
    
    public function update(int|string $id, array $data): bool;
    
    public function delete(int|string $id): bool;
}
