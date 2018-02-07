<?php
namespace Modules\Documents\Entities;
// use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Office extends BaseModel
{
	use \Wildside\Userstamps\Userstamps;
    protected $fillable = [
    	'name', 
    	'shortname', 
    	'bureauservice_id', 
    	'strand_id'
    ];
    public function strand()
    {
    	return $this->belongsTo(Strand::class)->withDefault();
    }
    public function bureauservice()
    {
    	return $this->belongsTo(Bureauservice::class)->withDefault();
    }
}
