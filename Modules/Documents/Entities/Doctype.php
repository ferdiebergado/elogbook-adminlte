<?php

namespace Modules\Documents\Entities;

// use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Doctype extends BaseModel
{
    protected $fillable = [
    	'name'
    ];

    public function documents()
    {
    	return $this->hasMany(Document::class)->withDefault();
    }
}
