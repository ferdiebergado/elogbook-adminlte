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
            'date_released',
            'released_to',            
            'persons_concerned', 
            'action_taken', 
            'action_to_be_taken',
            'received_by',
            'released_by'    	
    ];
    protected $dates = [
    	'date_received',
    	'date_released'
    ];
    public function doctype()
    {
        return $this->belongsTo(Doctype::class)->withDefault(['name' => null]);
    }
    public function received_from_office()
    {
        return $this->belongsTo(Office::class,'received_from')->withDefault(['name' => null]);
    }
    public function released_to_office()
    {
        return $this->belongsTo(Office::class,'released_to')->withDefault(['name' => null]);
    }    
}
