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
        'doctype_id',
    	'from_to_office',
    	'date',
    	'action',
        'action_to_be_taken',
    	'by',
        'office_id',
        'pending',
        'parent_id'
    ];
    protected $dates = [
    	'date'
    ];
    protected $casts = [
        'pending' => 'boolean',
        'parent_id' => 'integer',
        'office_id' => 'integer',
        'from_to_office' => 'integer',
        'doctype_id' => 'integer',
        'document_id' => 'integer'
    ];   
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        'document'
    ];    
    // public function getByAttribute() 
    // {
    //     if ($this->pending && $this->task === 'I') {
    //         return $this->editor->name;
    //     } else {
    //         return $this->attributes['by'];
    //     }
    // }
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
    public function attachments()
    {
        return $this->hasMany(\Modules\Documents\Entities\Attachment::class);
    }
    // public function getDateAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('M j, Y g:i A');
    // }
}
