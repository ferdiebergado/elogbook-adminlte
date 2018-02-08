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
            'persons_concerned'	
    ];
    public function doctype()
    {
        return $this->belongsTo(Doctype::class)->withDefault(['name' => null]);
    }   
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
