<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View as ViewFactory;
use TeamTeaTime\Forum\Support\CategoryPrivacy;
use TeamTeaTime\Forum\Events\UserViewingIndex;
use TeamTeaTime\Forum\Models\Category;
use TeamTeaTime\Forum\Models\Thread;
use TeamTeaTime\Forum\Support\Web\Forum;

use App\Models\User;

class CustomForumController extends Controller
{
    protected $user;
    public function __construct() {
        $this->user = User::find(11);
        view()->share('user', $this->user);
    }
    public function category_index(Request $request) {

        $categories = CategoryPrivacy::getFilteredTreeFor($this->user);

        if ($this->user !== null) {
            UserViewingIndex::dispatch($this->user);
        }

        return view('vendor.forum.category.index', compact('categories'));
    }
    public function category_create(Request $request) {
        $category = Category::create([
            'title' => $request['title'],
            'description' => isset($request['description']) ? $request['description'] : '',
            'color' => isset($request['color']) ? $request['color'] : config('forum.web.default_category_color'),
            'accepts_threads' => isset($request['accepts_threads']) && $request['accepts_threads'],
            'is_private' => isset($request['is_private']) && $request['is_private'],
        ]);

        Forum::alert('success', 'categories.created');

        return new RedirectResponse(route('cf.category.show', $category));
    }
    public function category_show(Request $request, $category) {
        $category = Category::find($category);

        if (! $category->isAccessibleTo($this->user)) {
            abort(404);
        }

        $privateAncestor = $this->user && $this->user->can('manageCategories')
            ? Category::defaultOrder()
                ->where('is_private', true)
                ->ancestorsOf($category->id)
                ->first()
            : [];

        $categories = $this->user && $this->user->can('moveCategories')
            ? Category::defaultOrder()
                ->with('children')
                ->where('accepts_threads', true)
                ->withDepth()
                ->get()
            : [];

        $threads = $this->user && $this->user->can('viewTrashedThreads')
            ? $category->threads()->withTrashed()
            : $category->threads();

        $threads = $threads
            ->with('firstPost', 'lastPost', 'firstPost.author', 'lastPost.author', 'lastPost.thread', 'author')
            ->orderBy('pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate();

        $selectableThreadIds = [];
        if ($this->user) {
            if ($this->user->can('moveThreadsFrom', $category) ||
                $this->user->can('lockThreads', $category) ||
                $this->user->can('pinThreads', $category)) {
                // There are no thread-specific abilities corresponding to these,
                // so we can include all of the threads for this page
                $selectableThreadIds = $threads->pluck('id')->toArray();
            } else {
                $canDeleteThreads = $this->user->can('deleteThreads', $category);
                $canRestoreThreads = $this->user->can('restoreThreads', $category);

                if ($canDeleteThreads || $canRestoreThreads) {
                    foreach ($threads as $thread) {
                        if (($canDeleteThreads && $this->user->can('delete', $thread))
                            || $canRestoreThreads && $this->user->can('restore', $thread)
                        ) {
                            $selectableThreadIds[] = $thread->id;
                        }
                    }
                }
            }
        }

        return view('vendor.forum.category.show', compact('privateAncestor', 'categories', 'category', 'threads', 'selectableThreadIds'));
    }
    public function category_update(Request $request, $category) {
        $category = Category::find($category);
        $category->update([
            'title' => $request['title'] ?? null,
            'description' => $request['description'] ?? null,
            'color' => $request['color'] ?? null,
            'accepts_threads' => $request['accepts_threads'] ?? null,
            'is_private' => $request['is_private'] ?? null
        ]);

        Forum::alert('success', 'categories.updated', 1);

        return new RedirectResponse(route('cf.category.show', $category));
    }

    public function thread_create(Request $request, $category) {
        $category = Category::find($category);

        if (! $category->accepts_threads) {
            Forum::alert('warning', 'categories.threads_disabled');

            return new RedirectResponse(route('cf.category.show', $category));
        }

        return view('vendor.forum.thread.create', compact('category'));
    }
    public function thread_store(Request $request, $category) {
        $category = Category::find($category);

        $thread = Thread::create([
            'author_id' => $this->user->getKey(),
            'category_id' => $category->id,
            'title' => $request->title,
        ]);

        $post = $thread->posts()->create([
            'author_id' => $this->user->getKey(),
            'content' => $request->content,
            'sequence' => 1,
        ]);

        $thread->update([
            'first_post_id' => $post->id,
            'last_post_id' => $post->id,
        ]);

        $thread->category->updateWithoutTouch([
            'newest_thread_id' => $thread->id,
            'latest_active_thread_id' => $thread->id,
            'thread_count' => DB::raw('thread_count + 1'),
            'post_count' => DB::raw('post_count + 1'),
        ]);

        Forum::alert('success', 'threads.created');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
    public function thread_show(Request $request, $thread) {
        $thread = Thread::find($thread);

        if (! $thread->category->isAccessibleTo($this->user)) {
            abort(404);
        }

        if ($thread->category->is_private) {
            $this->authorize('view', $thread);
        }

        if ($request->user() !== null) {
            $thread->markAsRead($this->user->getKey());
        }

        $category = $thread->category;
        $categories = $this->user && $this->user->can('moveThreadsFrom', $category)
                    ? Category::acceptsThreads()->get()->toTree()
                    : [];

        $posts = config('forum.general.display_trashed_posts') || $this->user && $this->user->can('viewTrashedPosts')
               ? $thread->posts()->withTrashed()
               : $thread->posts();

        $posts = $posts
            ->with('author', 'thread')
            ->orderBy('created_at', 'asc')
            ->paginate();

        $selectablePosts = [];

        if ($this->user) {
            foreach ($posts as $post) {
                if ($this->user->can('delete', $post) || $this->user->can('restore', $post)) {
                    $selectablePosts[] = $post->id;
                }
            }
        }

        return view('vendor.forum.thread.show', compact('categories', 'category', 'thread', 'posts', 'selectablePosts'));
    }
    public function thread_delete()
    {

    }

    public function post_store(Request $request, $thread)
    {
        $thread = Thread::find($thread);
        $parent = $request->has('post') ? $thread->posts->find($request->input('post')) : null;

        $post = $thread->posts()->create([
            'post_id' => $parent === null ? null : $parent->id,
            'author_id' => $this->user->getKey(),
            'sequence' => $thread->posts->count() + 1,
            'content' => $request->input('content'),
        ]);

        $thread->update([
            'last_post_id' => $post->id,
            'reply_count' => DB::raw('reply_count + 1'),
        ]);

        $thread->category->updateWithoutTouch([
            'latest_active_thread_id' => $thread->id,
            'post_count' => DB::raw('post_count + 1'),
        ]);

        Forum::alert('success', 'general.reply_added');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
}
