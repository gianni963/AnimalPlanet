<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Comment extends Model
{

	use SoftDeletes, Orderable;

    protected $fillable = [
    	'body',
    	'user_id',
    	'reply_id',
        'commentable_id',
        'commentable_type'

    ];

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function replies()
    {
    	return $this->hasMany(Comment::class, 'reply_id', 'id')->orderBy('created_at', 'desc');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
