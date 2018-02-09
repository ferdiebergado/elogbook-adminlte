<?php
namespace Modules\Documents\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class TransactionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document_id'       => 'required|integer',     
            'task'              => 'required',
            'from_to_office'    => 'required|integer',
            'task_date'         => 'required|date_format:dd/mm/yyyy',
            'task_time'         => 'required',            
            'action'            => 'required|max:250'
        ];
    }
}
