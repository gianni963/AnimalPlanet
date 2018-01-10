<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Channel extends Model
{
    use Searchable;
    protected $fillable = [ 'name', 'slug', 'description', 'image_filename'];

    public function user()
    {

    		return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function videos()
    {

    	return $this->hasMany(Video::class);
    }

    public function getImage()
    {

        if(!$this->image_filename) {
            
            return config('petube.buckets.images') . '/profile/profile_def.png';

        }

        return config('petube.buckets.images') .'/profile/' . $this->image_filename ;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscriptionCount()
    {
        return $this->subscriptions->count();
    }

    public function totalVideoViews()
    {
        return $this->hasManyThrough(VideoView::class, Video::class)->count();
    }

    
}
