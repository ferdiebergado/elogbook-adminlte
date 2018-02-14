<?php
namespace Modules\Users\Entities;
use App\BaseModel;
class Jobtitle extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
