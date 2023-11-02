<?php

namespace App\Http\Policies\Forum;

use TeamTeaTime\Forum\Models\Post;

class PostPolicy
{
    public function edit($user, Post $post): bool
    {
        return $user->getKey() === $post->author_id;
    }

    public function delete($user, Post $post): bool
    {
        return $user->getKey() === $post->author_id;
    }

    public function restore($user, Post $post): bool
    {
        return $user->getKey() === $post->author_id;
    }
}
