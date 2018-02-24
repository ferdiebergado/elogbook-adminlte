<?php
namespace Modules\Users\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Users\Rules\EqualToCurrent;
use Modules\Users\Policies\UserPolicy;
// use Illuminate\Validation\Rule;
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
        return $this->all('_token');
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'email' => [
            //     'required', 
            //     'max:150', 
            //     Rule::unique('users')->ignore(auth()->user()->id)
            // ],            
            'email' => 'filled|max:150',
            'password' => 'filled|confirmed|min:6|max:32',
            'old_password' => [
                'filled', 
                new EqualToCurrent
            ],
            'userid' => 'filled|integer',
            'jobtitle_id' => 'filled|integer',
            'office_id' => 'filled|integer'
            // 'avatar' => 'filled|file|image|mimes:jpeg,png|max:512'
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
