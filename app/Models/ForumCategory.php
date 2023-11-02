<?php

namespace App\Models;

use TeamTeaTime\Forum\Models\Category;

class ForumCategory extends Category {
    public function getRouteAttribute(): string
    {
        return route('cf.category.show', $this);
    }
}
