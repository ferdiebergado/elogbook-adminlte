<?php
namespace Modules\Documents\Entities;
// use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Modules\Users\Entities\User;
class Office extends BaseModel
{
	use \Wildside\Userstamps\Userstamps;
    protected $fillable = [
    	'name', 
    	'shortname', 
    	'bureauservice_id', 
    	'strand_id'
    ];
    protected $casts = [
        'bureauservice_id' => 'integer',
        'strand_id' => 'integer'
    ];
    public function strand()
    {
    	return $this->belongsTo(Strand::class)->withDefault(['name' => null]);
    }
    public function bureauservice()
    {
    	return $this->belongsTo(Bureauservice::class)->withDefault(['name' => null]);
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
