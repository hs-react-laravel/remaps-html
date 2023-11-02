<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    | Here we specify the policy classes to use. Change these if you want to
    | extend the provided classes and use your own instead.
    |
    */
    'policies' => [
        'forum' => App\Http\Policies\Forum\ForumPolicy::class,
        'model' => [
            TeamTeaTime\Forum\Models\Category::class => App\Http\Policies\Forum\CategoryPolicy::class,
            TeamTeaTime\Forum\Models\Thread::class => App\Http\Policies\Forum\ThreadPolicy::class,
            TeamTeaTime\Forum\Models\Post::class => App\Http\Policies\Forum\PostPolicy::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application user model
    |--------------------------------------------------------------------------
    |
    | Your application's user model.
    |
    */

    'user_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Application user name
    |--------------------------------------------------------------------------
    |
    | The user model attribute to use for displaying usernames.
    |
    */

    'user_name' => 'full_name',

];
