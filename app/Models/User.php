<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'active', 'activation_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

}
