<?php
namespace Modules\Documents\Entities;
use App\BaseModel;
/**
 * Class Transaction.
 *
 * @package namespace Modules\Documents\Entities;
 */
class Transaction extends BaseModel
{
    use \Wildside\Userstamps\Userstamps;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task',
    	'document_id',
    	'from_to_office',
    	'date',
    	'action',
    	'by',
        'office_id'
    ];
    protected $dates = [
    	'date'
    ];
    public function document()
    {
    	return $this->belongsTo(Document::class)->withDefault();
    }
    public function target_office()
    {
        return $this->belongsTo(Office::class, 'from_to_office')->withDefault(['name' => null]);
    }
    public function office()
    {
        return $this->belongsTo(Office::class)->withDefault(['name' => null]);
    }    
}
