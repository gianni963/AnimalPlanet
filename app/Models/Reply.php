<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;


class Reply extends Model
{
    use Favoritable;
    //use RecordsActivity;
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];
    
    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited', 'isBest'];
    /**
     * A reply has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    protected static function boot()
    {
        parent::boot();


        static::created(function($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {

            $reply->thread->decrement('replies_count');
            
        });
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-_]+)/', $this->body, $matches);
        return $matches[1];
   }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-_]+)/', '<a href="/public_profiles/$1">$0</a>', $body);
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

}
