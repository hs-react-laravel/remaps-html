<?php

namespace App\Http\Policies\Forum;

class ForumPolicy
{
    public function createCategories($user): bool
    {
        return $user->is_master;
    }

    public function manageCategories($user): bool
    {
        return $this->moveCategories($user) ||
               $this->renameCategories($user);
    }

    public function moveCategories($user): bool
    {
        return $user->is_master;
    }

    public function renameCategories($user): bool
    {
        return $user->is_master;
    }

    public function markThreadsAsRead($user): bool
    {
        return true;
    }

    public function viewTrashedThreads($user): bool
    {
        return true;
    }

    public function viewTrashedPosts($user): bool
    {
        return true;
    }
}
