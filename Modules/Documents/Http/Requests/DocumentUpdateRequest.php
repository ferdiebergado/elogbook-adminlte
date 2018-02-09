<?php
namespace Modules\Documents\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class DocumentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return new \Modules\Documents\Policies\DocumentPolicy;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctype_id'        => 'required|integer',            
            'details'           => 'required|min:3|max:250',
            'persons_concerned' => 'required|max:250'
        ];
    }
}
