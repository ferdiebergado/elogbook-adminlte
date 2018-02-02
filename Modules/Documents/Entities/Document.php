<?php

namespace Modules\Documents\Entities;

// use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

/**
 * Class Document.
 *
 * @package namespace Modules\Documents\Entities;
 */
class Document extends BaseModel
{
    use \Wildside\Userstamps\Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

            'doctype_id',
            'details',
            'date_received',
            'received_from',
            'received_to',
            'date_released',
            'released_from',
            'released_to',            
            'persons_concerned', 
            'action_taken', 
            'received_by'    	

    ];

    protected $dates = [

    	'date_received',
    	'date_released'

    ];

}
