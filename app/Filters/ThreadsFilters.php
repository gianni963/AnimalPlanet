<?php

namespace App\Filters;
use App\Models\User;
use Illuminate\Http\Request;

class ThreadsFilters extends Filters
{
	protected $filters = ['by', 'popular','unanswered'];

    /**
     * Filter the query by a given username.
     *
     * @param  string $username
     * @return Builder
     */
	protected function by($username)
	{
		$user = User::where('name', $username)->firstOrFail();
        
        return $this->builder->where('user_id', $user->id);
	}

    /**
     * Filter the query according to most popular threads.
     *
     * @return $this
     */

	protected function popular()
	{
		//clean out any other order query that have been set
		$this->builder->getQuery()->orders = [];
		return $this->builder->orderBy('replies_count', 'desc');
	}

    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }

}