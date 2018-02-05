<?php

namespace Modules\Documents\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentCreateRequest extends FormRequest
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

            'action_taken'      => 'required|max:250',

            'received_from'     => 'required_without_all:released_by,released_date,released_time,released_from,released_to|max:150',

            'received_to'       => 'required_without_all:released_by,released_date,released_time,released_from,released_to|max:150',            

            'received_date'     => 'required_without_all:released_by,released_date,released_time,released_from,released_to',

            'received_time'     => 'required_without_all:released_by,released_date,released_time,released_from,released_to',        
            
            'received_by'       => 'required_without_all:released_by,released_date,released_time,released_from,released_to|max:150',

            'released_from'     => 'required_without_all:received_by,received_date,received_time,received_from,received_to|max:150',

            'released_to'       => 'required_without_all:received_by,received_date,received_time,received_from,received_to|max:150',

            'released_date'     => 'required_without_all:received_by,received_date,received_time,received_from,received_to',  
            
            'released_time'     => 'required_without_all:received_by,received_date,received_time,received_from,received_to',          

            'released_by'       => 'required_without_all:received_by,received_date,received_time,received_from,received_to|max:150'

        ];
    }
}
