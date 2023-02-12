<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserRequest extends ApiFormRequest
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:100|unique:users',
            'password'  => 'required|string|confirmed|min:6',
            'phone'     => 'required|string',
            'city'      => 'required|string'
        ];
    }

    public function update(){
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:100|unique:users,email,'.$this->user,
            'password'  => 'same:password_confirmation',
            'phone'     => 'required|string',
            'city'      => 'required|string'
        ];
    }
}
