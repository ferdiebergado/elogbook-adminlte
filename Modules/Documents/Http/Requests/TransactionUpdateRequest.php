<?php
namespace Modules\Documents\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Documents\Policies\TransactionPolicy;
use Illuminate\Validation\Rule;
class TransactionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return new TransactionPolicy;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document_id'       => 'integer',     
            'task'              =>  [
                                       'required', 
                                        Rule::in(['I', 'O'])
                                    ],
            'from_to_office'    => 'required|integer',
            'task_date'         => 'required|date',
            'task_time'         => 'required',            
            'action'            => 'required|max:250',
            'action_to_be_taken' => 'required|max:250',
            'by'                => 'filled|max:150',
            'pending'           => 'boolean',
            'transaction_doctype_id' => 'integer'
        ];
    }
}
