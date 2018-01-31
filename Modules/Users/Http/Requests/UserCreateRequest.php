<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Users\Rules\EqualToCurrent;

class UserCreateRequest extends FormRequest
{
    use \App\Http\Helpers\PasswordHelper;

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->decryptPassword($this->all());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|max:150',            
            'password' => 'required|confirmed|min:6|max:32'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
