<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\PostRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{

    use ResponseTrait;

    public function __construct(private PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $posts = $this->postRepository->getAll(request()->all());
            return $this->responseSuccess('', $posts);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        try {

            $data = [
                'post_author'   => Auth::user()->id,
                'post_title'    => $request->post_title,
                'post_slug'     => $request->post_slug,
                'post_type'     => $request->post_type,
                'excerpt'       => $request->excerpt,
                'post_content'  => $request->post_content,
                'post_status'   => $request->post_status,
                'comment_count' => $request->comment_count
            ];

            $post = $this->postRepository->create($data);
            return $this->responseSuccess('', $post, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess('', $this->postRepository->getById($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), 'Post doesn\'t exist.',Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display full post detail include (comment, users, others)
     * belum
     * 
     * @return JsonResponse
     */
    public function showFullDetailPost(): JsonResponse
    {
        try {
            return $this->responseSuccess('Get authenticated user success', Auth::guard()->user());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), 'User doesn\'t exist.',Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     * belum, .git error
     * belum, cek jga klo ganti pass, cek login kembali
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {

        try {

            $data = [
                'post_title'    => $request->post_title,
                'post_slug'     => $request->post_slug,
                'post_type'     => $request->post_type,
                'excerpt'       => $request->excerpt,
                'post_content'  => $request->post_content,
                'post_status'   => $request->post_status,
                'post_image'    => $request->file('post_image')
            ];

            return $this->responseSuccess('', $this->postRepository->update($id, $data));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return $this->responseSuccess('Post deleted successfully', $this->postRepository->delete($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), null,Response::HTTP_NOT_FOUND);
        }
    }
}
