<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;
use App\Notifications\ThreadWasUpdated;
use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;
use Laravel\Scout\Searchable;

class Thread extends Model
{
    use RecordsActivity, Searchable;
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];
    protected $with = ['creator', 'topic'];

    protected $appends = ['isSubscribedTo'];

    protected $casts = [
        'locked' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();


        static::deleting(function ($thread){
            $thread->replies->each->delete();

        });

        static::created(function ($thread){
            $thread->update(['slug' => $thread->title]);

        });


    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/forum/threads/{$this->topic->slug}/{$this->slug}";
    }
    /**
     * A thread may have many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    /**
     * A thread belongs to a creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Add a reply to the thread.
     *
     * @param $reply
     */

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function addReply($reply)
    {

       $reply = $this->replies()->create($reply);

       event(new ThreadReceivedNewReply($reply));


       return $reply;

    }


    // public function notifySubscribers($reply)
    // {
    //    $this->subscriptions
    //         ->where('user_id', '!=', $reply->user_id)
    //         ->each
    //         ->notify($reply);
    // }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
        ->where('user_id', $userId ?: auth()->id())
        ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user)
    {

        //look in the cache for the proper key

        // compare that carbon instance with the $thread->updated_at
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);

    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];


    }

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }


}