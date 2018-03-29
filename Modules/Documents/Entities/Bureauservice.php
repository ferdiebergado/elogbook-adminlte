<?php
namespace Modules\Documents\Entities;
// use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Bureauservice extends BaseModel
{
    use \Wildside\Userstamps\Userstamps;
    protected $fillable = [
    	'name', 
    	'shortname', 
    	'strand_id'
    ];
    protected $casts = [
        'strand_id' => 'integer'
    ];
    public function offices()
    {
    	return $this->hasMany(Office::class)->withDefault();
    }
    public function strand()
    {
        return $this->belongsTo(Strand::class)->withDefault(['name' => null]);
    }
}
