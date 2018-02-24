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
        'action_to_be_taken',
    	'by',
        'office_id',
        'pending'
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
    public function user()
    {
        return $this->belongsTo(\Modules\Users\Entities\User::class)->withDefault(['name' => null]);
    }
    // public function getDateAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('M j, Y g:i A');
    // }
}
