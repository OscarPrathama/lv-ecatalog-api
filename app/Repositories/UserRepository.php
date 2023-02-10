<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class UserRepository implements CrudInterface
{
    
    public function getAll(array $data): Paginator{
        $filter = dataFiltering($data);

        $query = User::orderBy($filter['orderBy'], $filter['order']);

        if (!empty($filter['search'])) {
            $query->where(function($query) use ($filter){
                $searched = '%' . $filter['search'] . '%';
                $query-> where('name', 'like', $searched)
                      -> orwhere('email', 'like', $searched);
            });
        }

        return $query->paginate($filter['perPage']);
    }


    public function create(array $data): ?User {
        return User::create($data);
    }

    public function prepareForDB(array $data, ?User $user = null): array
    {
        return [];
    }

}

?>