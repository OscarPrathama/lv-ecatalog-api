<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response;

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

    public function getById(int $id): ?User {
        return User::findOrFail($id);
    }

    public function update(int $id, array $data): ?User {
        $user = $this->getById($id);

        $updated = $user->update($data);
        
        if($updated){
            $user = $this->getById($id);
        }

        return $user;
    }

    public function delete(int $id): ?User{
        $user = $this->getById($id);
        $user->delete();

        return $user;
    }

}

?>