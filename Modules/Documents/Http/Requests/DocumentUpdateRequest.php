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

            'persons_concerned' => 'required|max:250', 

            'action_taken'      => 'max:250',

            'received_from'     => 'required_without:released_from|max:150',

            'received_to'       => 'required_without:released_to|max:150',

            'received_date'     => 'required_without:released_date',

            'received_time'     => 'required_without:released_time',
            
            'received_by'       => 'required_without:released_by|max:150',

            'released_from'     => 'required_without:received_from|max:150',

            'released_to'       => 'required_with:released_from|max:150',

            'released_date'     => 'required_with:released_to',

            'released_time'     => 'required_with:released_date',                        

            'released_by'       => 'required_with:released_time|max:150'

        ];
    }
}
