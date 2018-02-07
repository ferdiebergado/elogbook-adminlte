<?php
namespace Modules\Documents\Entities;
// use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Strand extends BaseModel
{
	use \Wildside\Userstamps\Userstamps;
    protected $fillable = [
    	'name', 
    	'shortname'
    ];
    public function offices()
    {
    	return $this->hasMany(Office::class)->withDefault();
    }
    public function bureauservices()
    {
    	return $this->hasMany(Bureauservice::class)->withDefault();
    }
}
