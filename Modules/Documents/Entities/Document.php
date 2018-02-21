<?php
namespace Modules\Documents\Entities;
// use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Modules\Users\Entities\User;
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
            'persons_concerned'	,
            'office_id'
    ];
    public function doctype()
    {
        return $this->belongsTo(Doctype::class)->withDefault(['name' => null]);
    }   
    public function transactions()
    {
        return $this->hasMany(Transaction::class)->latest();
    }
    public function office()
    {
        return $this->belongsTo(Office::class)->withDefault(['name' => null]);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(['name' => null]);
    }
}
