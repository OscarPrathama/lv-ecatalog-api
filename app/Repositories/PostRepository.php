<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Post;
use App\Models\PostMeta;
use Illuminate\Contracts\Pagination\Paginator;

class PostRepository implements CrudInterface
{

    public function __construct(private PostMeta $postMeta)
    {
        $this->postMeta = $postMeta;
    }
    
    public function getAll(array $data): Paginator{
        $filter = dataFiltering($data);

        $query = Post::orderBy($filter['orderBy'], $filter['order']);

        if (!empty($filter['search'])) {
            $query->where(function($query) use ($filter){
                $searched = '%' . $filter['search'] . '%';
                $query-> where('post_title', 'like', $searched);
                    //   -> orwhere('post_content', 'like', $searched);
            });
        }

        return $query->paginate($filter['perPage']);
    }

    public function create(array $data): ?Post {
        return Post::create($data);
    }

    public function getById(int $id): ?Post {
        return Post::findOrFail($id);
    }

    public function update(int $id, array $data): ?Post {

        // get post id
        $post = $this->getById($id);
        $updated_post = $post->update($data);

        if (!empty($data['post_image'])) {

            // belum, buatin fungsi image processing
            $file = $data['post_image'];
            $file_original_name = $file->getClientOriginalName();
            $raw_file_name = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_name = strtolower(str_replace(' ', '-', $raw_file_name));
            $file_type = $file->getClientMimeType();
            $file_ext = $file->getClientOriginalExtension();
            $file_size = $file->getSize();
            $folder = 'public/images';
            $final_file_name = $file_name.'.'.$file_ext;

            $post_image = $file->storeAs($folder, $final_file_name);

            $this->postMeta->updateOrCreate([
                'post_id' => $id,
                'meta_key' => 'post_image',
                'meta_value' => json_encode($post_image),
            ]);
        }

        if($updated_post){
            $post = $this->getById($id);
        }

        return $post;
    }

    public function delete(int $id): ?Post{
        $post = $this->getById($id);
        $post->delete();

        return $post;
    }

}

?>