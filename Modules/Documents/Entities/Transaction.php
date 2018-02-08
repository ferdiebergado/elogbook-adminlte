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
    	'document_id',
    	'from_to_office',
    	'date',
    	'action',
    	'by'
    ];
    protected $dates = [
    	'date'
    ];
    public function document()
    {
    	return $this->belongsTo(Document::class)->withDefault();
    }
}
