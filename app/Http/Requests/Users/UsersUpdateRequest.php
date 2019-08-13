<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('sqlsrv.mi.users')->ignore($this->user)],
            'role'  => ['required', Rule::in(['mi','sohnen'])],
            'password' => ['sometimes'],
        ];
    }

    public function update($user)
    {
        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        if ($this->password != null) {
            $user->password = $this->password;
        }

        $user->save();

    }

}
