<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Users\Rules\EqualToCurrent;
use Modules\Users\Policies\UserPolicy;

class UserUpdateRequest extends FormRequest
{
    use \App\Http\Helpers\PasswordHelper;

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        if (!$this->avatar) {
            return $this->decryptPassword($this->except('_token'));
        }
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'filled|max:150',            
            'password' => 'filled|confirmed|min:6|max:32',
            'avatar' => 'filled|max:150',            
            'old_password' => ['filled', new EqualToCurrent],
            'userid' => 'filled|integer'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return new UserPolicy;
        
    }
}
