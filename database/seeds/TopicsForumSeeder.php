<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = [
        	[
        		'name' => 'cats',
        		'slug' => 'cats',
        	],        	
        	[
        		'name' => 'dogs',
        		'slug' => 'dogs',
        	],        	
        	[
        		'name' => 'pets',
        		'slug' => 'pets',
        	],
        	[
        		'name' => 'aquarium',
        		'slug' => 'aquarium',
        	],
        	[
        		'name' => 'snake',
        		'slug' => 'snake',
        	], 
        	[
        		'name' => 'spiders and arachnids',
        		'slug' => 'spiders-arachnids',
        	],
        	[
        		'name' => 'snakes',
        		'slug' => 'snakes',
        	],
        	[
        		'name' => 'reptiles',
        		'slug' => 'reptiles',
        	],
        	[
        		'name' => 'pet birds',
        		'slug' => 'pet-birds',
        	],
        	[
        		'name' => 'birds',
        		'slug' => 'birds',
        	],
        	[
        		'name' => 'fish and sea',
        		'slug' => 'fish and sea',
        	],
        	[
        		'name' => 'livestocks',
        		'slug' => 'livestocks',
        	],
        	[
        		'name' => 'wild cats',
        		'slug' => 'wild-cats',
        	],
        	[
        		'name' => 'insects',
        		'slug' => 'insects',
        	],
    		[
        		'name' => 'other wild animals',
        		'slug' => 'other-wild-animals',
        	],
    		[
        		'name' => 'agriculture',
        		'slug' => 'agriculture',
        	],
    		[
        		'name' => 'pastoralism',
        		'slug' => 'pastoralism',
        	],
    		[
        		'name' => 'gardening',
        		'slug' => 'gardening',
        	],
        	[
        		'name' => 'tools implements',
        		'slug' => 'tools-implements',
        	],
        	[
        		'name' => 'fruits and vegetables',
        		'slug' => 'fruits-vegetables',
        	],
        	[
        		'name' => 'moutains',
        		'slug' => 'mountains',
        	],
        	[
        		'name' => 'flora trees...',
        		'slug' => 'flora-trees',
        	],
        	[
        		'name' => 'geology',
        		'slug' => 'geology',
        	],
        	[
        		'name' => 'natural disasters',
        		'slug' => 'natural-disasters',
        	],


        	[
        		'name' => 'food',
        		'slug' => 'food',
        	],
        	[
        		'name' => 'other',
        		'slug' => 'other',
        	],

        ];

    	foreach($topics as $topic){
    		Topic::create($topic);

    	}
    }
}
