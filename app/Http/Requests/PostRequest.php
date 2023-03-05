<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch (Request::method()) {
            case 'POST':
                return $this->store();
                break;
            case 'PUT':
                return $this->update();
                break;
            default:
                return Response::HTTP_BAD_REQUEST;
                break;
        }
    }

    public function store(){

        return [
            'post_title'    => 'required|string',
            'post_slug'     => 'required|string|max:100|unique:posts',
            'post_type'     => 'required|string',
            'excerpt'       => 'required|string|max:100',
            'post_content'  => 'required|string',
            'post_status'   => 'required|string',
            'comment_count' => 'required|integer',
        ];

    }

    public function update(){
        return [
            'post_title'    => 'required|string',
            'post_slug'     => 'required|string|max:100|unique:posts,post_slug,'.$this->post,
            'post_type'     => 'required|string',
            'excerpt'       => 'required|string|max:100',
            'post_content'  => 'required|string',
            'post_status'   => 'required|string',
            'post_image'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ];
    }
}
