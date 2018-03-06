<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;

class Login extends Model
{
    protected $fillable = [
    	'user_id',
    	'ip',
    	'user_agent',
    	'via_remember'
    ];
    public function user()
    {
    	return $this->belongsTo(User::class)->withDefault(['name' => null]);
    }
}
