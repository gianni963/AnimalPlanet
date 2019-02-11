<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Activity;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'active', 'activation_token','avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    public function isAdmin()
    {
        return $this->admin;
    }

    public function hasAdminTitle()
    {
       return $this->admin_title; 
    }
    
    public function videos()
    {
        return $this->hasManyThrough(Video::class, Channel::class);
    }

    public function channel()
    {

        return $this->hasMany(Channel::class);
    }

    public function ChannelsSubscribed()
    {
        return $this->belongsToMany(Channel::class, 'subscriptions');
    }

    public function ownsChannel(Channel $channel)
    {
        return (bool) $this->channel->where('id', $channel->id)->count();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    public function isSubscribedTo(Channel $channel)
    {
        return (bool) $this->subscriptions->where('channel_id', $channel->id)->count();
    }

    public function scopeByActivationColumns(Builder $builder, $email, $token)
    {
        return $builder->where('email', $email)->where('activation_token', $token);
    }

    public function scopeByEmail(Builder $builder, $email)
    {
        return $builder->where('email', $request->email);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
             \Carbon\Carbon::now()
         );        
    }

    // public function getAvatarPathAttribute($avatar)
    // {
    //     if($avatar){
    //         return '/storage/' . $avatar;
    //     }else{
    //         return '/storage/images/avatars/default.png';
    //     }

    // }

    public function getAvatarPathAttribute($avatar)
    {

        if(! $avatar) {
            
            return config('petube.buckets.images') . '/avatar/default.png';

        }

        return config('petube.buckets.images') .'/avatar/' . $avatar ;
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf('users.%s.visits.%s', $this->id, $thread->id);        
    }

}
