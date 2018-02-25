<?php
namespace Modules\Users\Entities;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Users\Events\UserAmended;
use Modules\Documents\Entities\Office;
use Modules\Documents\Entities\Document;
use Modules\Users\Entities\Jobtitle;
use Modules\Documents\Entities\Transaction;
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'jobtitle_id', 'avatar', 'office_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dispatchesEvents = [
        'saved' => UserAmended::class,
        'deleted' => UserAmended::class,
        'updated' => UserAmended::class,
    ];    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function getNameAttribute()
    {
        return ucwords($this->attributes['name']);
    }
    public function getAvatarAttribute()
    {
        $avatar = $this->attributes['avatar'];
        if (empty($avatar)) {
            $avatar = config('users.default_avatar');
        }
        return $avatar;
    }
    public function office()
    {
        return $this->belongsTo(Office::class)->withDefault(['name' => null]);
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function jobtitle()
    {
        return $this->belongsTo(Jobtitle::class)->withDefault(['name' => null]);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'updated_by');
    }
}
