<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View as ViewFactory;
use TeamTeaTime\Forum\Support\CategoryPrivacy;
use TeamTeaTime\Forum\Events\UserViewingIndex;
use App\Models\ForumCategory;
use TeamTeaTime\Forum\Models\Category;
use TeamTeaTime\Forum\Models\Thread;
use TeamTeaTime\Forum\Models\Post;
use TeamTeaTime\Forum\Support\Web\Forum;
use Illuminate\Http\JsonResponse;

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
    public function category_manage(Request $request)
    {
        $categories = ForumCategory::defaultOrder()->get();
        $categories->makeHidden(['_lft', '_rgt', 'thread_count', 'post_count']);

        return view('vendor.forum.category.manage', ['categories' => $categories->toTree()]);
    }

    public function thread_recent(Request $request)
    {
        $threads = Thread::recent()->with('category', 'author', 'lastPost', 'lastPost.author', 'lastPost.thread');

        if ($request->has('category_id')) {
            $threads = $threads->where('category_id', $request->input('category_id'));
        }

        $accessibleCategoryIds = CategoryPrivacy::getFilteredFor($this->user)->keys();

        $threads = $threads->get()->filter(function ($thread) use ($request, $accessibleCategoryIds) {
            return $accessibleCategoryIds->contains($thread->category_id) && (! $thread->category->is_private || $this->user && $this->user->can('view', $thread));
        });

        return view('vendor.forum.thread.recent', compact('threads'));
    }
    public function thread_unread(Request $request)
    {
        $threads = Thread::recent()->with('category', 'author', 'lastPost', 'lastPost.author', 'lastPost.thread');

        $accessibleCategoryIds = CategoryPrivacy::getFilteredFor($this->user)->keys();

        $threads = $threads->get()->filter(function ($thread) use ($request, $accessibleCategoryIds) {
            return $thread->userReadStatus !== null
                && (! $thread->category->is_private || $this->user && $accessibleCategoryIds->contains($thread->category_id) && $this->user->can('view', $thread));
        });

        return view('vendor.forum.thread.unread', compact('threads'));
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
        $thread = Thread::withTrashed()->find($thread);

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
    public function thread_delete(Request $request, $thread)
    {
        $thread = Thread::withTrashed()->find($thread);

        $threadAlreadyTrashed = $thread->trashed();
        $postsRemoved = $thread->postCount;

        if ($request->has('permadelete') && $request->input('permadelete')) {
            $thread->readers()->detach();
            $thread->posts()->withTrashed()->forceDelete();
            $thread->forceDelete();
        } else {
            // Return early if the thread was already trashed because there's nothing to do
            if ($threadAlreadyTrashed) {
                return null;
            }

            $thread->readers()->detach();
            $thread->deleteWithoutTouch();
        }

        // The thread was already trashed - skip stat/attribute updates since they were done
        // previously.
        if ($threadAlreadyTrashed) {
            Forum::alert('success', 'threads.deleted');

            return new RedirectResponse(route('cf.category.show', $thread->category));
        }

        $attributes = [
            'thread_count' => DB::raw('thread_count - 1'),
        ];

        if ($postsRemoved) {
            $attributes['post_count'] = DB::raw("post_count - {$postsRemoved}");
        }

        $category = $thread->category;

        if ($category->newest_thread_id === $thread->id) {
            $attributes['newest_thread_id'] = $category->getNewestThreadId();
        }
        if ($category->latest_active_thread_id === $thread->id) {
            $attributes['latest_active_thread_id'] = $category->getLatestActiveThreadId();
        }

        $category->update($attributes);

        Forum::alert('success', 'threads.deleted');

        return new RedirectResponse(route('cf.category.show', $thread->category));
    }
    public function thread_restore(Request $request, $thread)
    {
        $thread = Thread::withTrashed()->find($thread);
        if (! $thread->trashed()) {
            return new RedirectResponse(route('cf.thread.show', $thread));
        }

        $thread->setTouchedRelations([])->restoreWithoutTouch();

        $category = $thread->category;
        $category->update([
            'newest_thread_id' => max($thread->id, $category->newest_thread_id),
            'latest_active_thread_id' => $category->getLatestActiveThreadId(),
            'thread_count' => DB::raw('thread_count + 1'),
            'post_count' => DB::raw("post_count + {$thread->postCount}"),
        ]);

        Forum::alert('success', 'threads.updated');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
    public function thread_lock(Request $request, $thread)
    {
        $thread = Thread::find($thread);
        $thread->updateWithoutTouch([
            'locked' => true,
        ]);

        Forum::alert('success', 'threads.updated');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
    public function thread_unlock(Request $request, $thread)
    {
        $thread = Thread::find($thread);
        $thread->updateWithoutTouch([
            'locked' => false,
        ]);
        Forum::alert('success', 'threads.updated');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
    public function thread_pin(Request $request, $thread)
    {
        $thread = Thread::find($thread);
        $thread->updateWithoutTouch([
            'pinned' => true,
        ]);
        Forum::alert('success', 'threads.updated');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
    public function thread_unpin(Request $request, $thread)
    {
        $thread = Thread::find($thread);
        $thread->updateWithoutTouch([
            'pinned' => false,
        ]);
        Forum::alert('success', 'threads.updated');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
    public function thread_rename(Request $request, $thread)
    {
        $thread = Thread::find($thread);
        $thread->updateWithoutTouch([
            'title' => $request->input('title'),
        ]);
        Forum::alert('success', 'threads.updated');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }
    public function thread_move(Request $request, $thread)
    {
        $thread = Thread::find($thread);
        $sourceCategory = $thread->category;
        $destinationCategory = Category::find($request->input('category_id'));


        if ($sourceCategory->id === $destinationCategory->id) {
            return null;
        }

        $thread->updateWithoutTouch(['category_id' => $destinationCategory->id]);

        $sourceCategoryValues = [];

        if ($sourceCategory->newest_thread_id === $thread->id) {
            $sourceCategoryValues['newest_thread_id'] = $sourceCategory->getNewestThreadId();
        }
        if ($sourceCategory->latest_active_thread_id === $thread->id) {
            $sourceCategoryValues['latest_active_thread_id'] = $sourceCategory->getLatestActiveThreadId();
        }

        $sourceCategoryValues['thread_count'] = DB::raw('thread_count - 1');
        $sourceCategoryValues['post_count'] = DB::raw("post_count - {$thread->postCount}");

        $sourceCategory->updateWithoutTouch($sourceCategoryValues);

        $destinationCategory->updateWithoutTouch([
            'thread_count' => DB::raw('thread_count + 1'),
            'post_count' => DB::raw("post_count + {$thread->postCount}"),
            'newest_thread_id' => $destinationCategory->getNewestThreadId(),
            'latest_active_thread_id' => $destinationCategory->getLatestActiveThreadId(),
        ]);

        Forum::alert('success', 'threads.updated');

        return new RedirectResponse(route('cf.thread.show', $thread));
    }


    public function post_create(Request $request, $thread)
    {
        $thread = Thread::find($thread);

        $post = $request->has('post') ? $thread->posts->find($request->input('post')) : null;

        return view('vendor.forum.post.create', compact('thread', 'post'));
    }
    public function post_show(Request $request, $thread, $post)
    {
        $thread = Thread::find($thread);
        $post = Post::find($post);

        if (! $thread->category->isAccessibleTo($this->user)) {
            abort(404);
        }

        if ($thread->category->is_private) {
            $this->authorize('view', $thread);
        }

        return view('vendor.forum.post.show', compact('thread', 'post'));
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
    public function post_edit(Request $request, $thread, $post)
    {
        $post = Post::find($post);

        if ($post->trashed()) {
            return abort(404);
        }

        // $this->authorize('edit', $post);

        // UserEditingPost::dispatch($request->user(), $post);

        $thread = $post->thread;
        $category = $post->thread->category;

        return view('vendor.forum.post.edit', compact('category', 'thread', 'post'));
    }
    public function post_update(Request $request, $thread, $post)
    {
        $thread = Thread::find($thread);
        $post = Post::find($post);

        $post->update(['content' => $request->content]);

        Forum::alert('success', 'posts.updated');

        return new RedirectResponse(route('cf.thread.show', ['thread' => $thread, 'post' => $post]));
    }
    public function post_confirmDelete(Request $request, $thread, $post)
    {
        $thread = Thread::find($thread);
        $post = Post::find($post);

        return view('vendor.forum.post.confirm-delete', ['category' => $thread->category, 'thread' => $thread, 'post' => $post]);
    }
    public function post_delete(Request $request, $thread, $post)
    {
        $thread = Thread::find($thread);
        $post = Post::find($post);

        if ($request->permaDelete) {
            $post->forceDelete();
        } else {
            if ($post->trashed()) {
                return null;
            }

            $post->deleteWithoutTouch();
        }

        $lastPostInThread = $post->thread->getLastPost();

        $post->thread->updateWithoutTouch([
            'last_post_id' => $lastPostInThread->id,
            'updated_at' => $lastPostInThread->updated_at,
            'reply_count' => DB::raw('reply_count - 1'),
        ]);

        $post->thread->category->updateWithoutTouch([
            'latest_active_thread_id' => $post->thread->category->getLatestActiveThreadId(),
            'post_count' => DB::raw('post_count - 1'),
        ]);

        if ($request->permaDelete && $post->children !== null) {
            // Other posts reference this one; null their post IDs
            $post->children()->update(['post_id' => null]);
        }

        // Update sequence numbers for all of the thread's posts
        $post->thread->posts->each(function ($p) {
            $p->updateWithoutTouch(['sequence' => $p->getSequenceNumber()]);
        });

        Forum::alert('success', 'posts.deleted', 1);

        return new RedirectResponse(route('cf.thread.show', $post->thread));
    }
    public function post_confirmRestore(Request $request, $thread, $post)
    {
        $thread = Thread::find($thread);
        $post = Post::withTrashed()->find($post);

        return view('vendor.forum.post.confirm-restore', ['category' => $thread->category, 'thread' => $thread, 'post' => $post]);
    }
    public function post_restore(Request $request, $thread, $post)
    {
        $thread = Thread::find($thread);
        $post = Post::withTrashed()->find($post);

        if (! $post->trashed()) {
            return new RedirectResponse(route('cf.thread.show', ['thread' => $thread, 'post' => $post]));
        }

        $post->restoreWithoutTouch();

        $post->thread->updateWithoutTouch([
            'last_post_id' => max($post->id, $post->thread->last_post_id),
            'reply_count' => DB::raw('reply_count + 1'),
        ]);

        $post->thread->category->updateWithoutTouch([
            'latest_active_thread_id' => $post->thread->category->getLatestActiveThreadId(),
            'post_count' => DB::raw('post_count + 1'),
        ]);

        Forum::alert('success', 'posts.updated', 1);

        return new RedirectResponse(route('cf.thread.show', ['thread' => $thread, 'post' => $post]));
    }

    public function markAsRead(Request $request)
    {
        $category = Category::find($request->input('category_id'));

        $threads = Thread::recent();

        if ($category !== null) {
            $threads = $threads->where('category_id', $category->id);
        }

        $accessibleCategoryIds = CategoryPrivacy::getFilteredFor($this->user)->keys();

        $threads = $threads->get()->filter(function ($thread) {
            // @TODO: handle authorization check outside of action?
            return $thread->userReadStatus != null
                && (! $thread->category->is_private || ($accessibleCategoryIds->contains($thread->category_id) && $this->user->can('view', $thread)));
        });

        foreach ($threads as $thread) {
            $thread->markAsRead($this->user->getKey());
        }

        if ($category !== null) {
            Forum::alert('success', 'categories.marked_read', 1, ['category' => $category->title]);

            return new RedirectResponse(route('cf.category.show', $category));
        }

        Forum::alert('success', 'threads.marked_read');

        return new RedirectResponse(route('cf.unread'));
    }

    protected function bulkActionResponse(int $rowsAffected, string $transKey): RedirectResponse
    {
        Forum::alert('success', $transKey, $rowsAffected);

        return redirect()->back();
    }
    public function bulk_category_manage(Request $request)
    {
        $categoryData = $request['categories'];
        Category::rebuildTree($categoryData);
        return new JsonResponse(['success' => true], 200);
    }
    public function bulk_thread_move(Request $request)
    {
        $destinationCategory = Category::find($request->input('category_id'));
        $threadIds = $request->input('threads');
        $includeTrashed = $this->user->can('viewTrashedThreads');

        $query = DB::table(Thread::getTableName())->where('category_id', '!=', $destinationCategory->id)->whereIn('id', $threadIds);

        $threads = $includeTrashed
            ? $query->get()
            : $query->whereNull('deleted_at')->get();

        // Return early if there are no eligible threads in the selection
        if ($threads->count() == 0) {
            return null;
        }

        $threadsByCategory = $threads->groupBy('category_id');
        $sourceCategories = Category::whereIn('id', $threads->pluck('category_id'))->get();
        $destinationCategory = $destinationCategory;

        $query->update(['category_id' => $destinationCategory->id]);

        $seen = [];
        foreach ($sourceCategories as $category) {
            if (in_array($category->id, $seen)) {
                continue;
            }

            $categoryThreads = $threadsByCategory->get($category->id);
            $threadCount = $categoryThreads->count();
            $postCount = $threadCount + $categoryThreads->sum('reply_count');
            $category->updateWithoutTouch([
                'newest_thread_id' => $category->getNewestThreadId(),
                'latest_active_thread_id' => $category->getLatestActiveThreadId(),
                'thread_count' => DB::raw("thread_count - {$threadCount}"),
                'post_count' => DB::raw("post_count - {$postCount}"),
            ]);

            $seen[] = $category->id;
        }

        $threadCount = $threads->count();
        $postCount = $threads->count() + $threads->sum('reply_count');
        $destinationCategory->updateWithoutTouch([
            'newest_thread_id' => max($threads->max('id'), $destinationCategory->newest_thread_id),
            'latest_active_thread_id' => $destinationCategory->getLatestActiveThreadId(),
            'thread_count' => DB::raw("thread_count + {$threadCount}"),
            'post_count' => DB::raw("post_count + {$postCount}"),
        ]);

        return $this->bulkActionResponse($threads->count(), 'threads.updated');
    }
    public function bulk_thread_lock(Request $request)
    {
        $threadIds = $request->input('threads');
        $includeTrashed = $this->user->can('viewTrashedThreads');

        $query = DB::table(Thread::getTableName())
            ->whereIn('id', $threadIds)
            ->where(['locked' => false]);

        if (! $includeTrashed) {
            $query = $query->whereNull(Thread::DELETED_AT);
        }

        $threads = $query->get();

        // Return early if there are no eligible threads in the selection
        if ($threads->count() == 0) {
            return null;
        }

        $query->update(['locked' => true]);

        return $this->bulkActionResponse($threads->count(), 'threads.updated');
    }
    public function bulk_thread_unlock(Request $request)
    {
        $threadIds = $request->input('threads');
        $includeTrashed = $this->user->can('viewTrashedThreads');

        $query = DB::table(Thread::getTableName())
            ->whereIn('id', $threadIds)
            ->where(['locked' => true]);

        if (! $includeTrashed) {
            $query = $query->whereNull(Thread::DELETED_AT);
        }

        $threads = $query->get();

        // Return early if there are no eligible threads in the selection
        if ($threads->count() == 0) {
            return null;
        }

        $query->update(['locked' => false]);

        return $this->bulkActionResponse($threads->count(), 'threads.updated');
    }
    public function bulk_thread_pin(Request $request)
    {
        $threadIds = $request->input('threads');
        $includeTrashed = $this->user->can('viewTrashedThreads');

        $query = DB::table(Thread::getTableName())
            ->whereIn('id', $threadIds)
            ->where(['locked' => true]);

        if (! $includeTrashed) {
            $query = $query->whereNull(Thread::DELETED_AT);
        }

        $threads = $query->get();

        // Return early if there are no eligible threads in the selection
        if ($threads->count() == 0) {
            return null;
        }

        $query->update(['pinned' => true]);

        return $this->bulkActionResponse($threads->count(), 'threads.updated');
    }
    public function bulk_thread_unpin(Request $request)
    {
        $threadIds = $request->input('threads');
        $includeTrashed = $this->user->can('viewTrashedThreads');

        $query = DB::table(Thread::getTableName())
            ->whereIn('id', $threadIds)
            ->where(['locked' => true]);

        if (! $includeTrashed) {
            $query = $query->whereNull(Thread::DELETED_AT);
        }

        $threads = $query->get();

        // Return early if there are no eligible threads in the selection
        if ($threads->count() == 0) {
            return null;
        }

        $query->update(['pinned' => false]);

        return $this->bulkActionResponse($threads->count(), 'threads.updated');
    }
    public function bulk_thread_delete(Request $request)
    {
        $threadIds = $request->input('threads');
        $permaDelete = $request->input('permadelete');
        $includeTrashed = $this->user->can('viewTrashedThreads');

        $query = Thread::whereIn('id', $threadIds);

        if ($includeTrashed) {
            $threads = $query->withTrashed()->get();

            // Return early if this is a soft-delete and the selected threads are already trashed,
            // or there are no valid threads in the selection
            if (! $permaDelete && $threads->whereNull(Thread::DELETED_AT)->count() == 0) {
                return null;
            }
        } else {
            $threads = $query->get();

            // Return early if there are no valid threads in the selection
            if ($threads->count() == 0) {
                return null;
            }
        }

        // Use the raw query builder to prevent touching updated_at
        $query = DB::table(Thread::getTableName())->whereIn('id', $threadIds);

        if ($permaDelete) {
            $rowsAffected = $query->delete();

            // Drop readers for the removed threads
            DB::table(Thread::READERS_TABLE)->whereIn('thread_id', $threadIds)->delete();
        } else {
            $rowsAffected = $query->whereNull(Thread::DELETED_AT)->update([Thread::DELETED_AT => DB::raw('now()')]);
        }

        $threadsByCategory = $threads->groupBy('category_id');
        foreach ($threadsByCategory as $categoryThreads) {
            // Count only non-deleted threads for changes to category stats since soft-deleted threads
            // are already represented
            $threadCount = $categoryThreads->whereNull(Thread::DELETED_AT)->count();

            // Sum of reply counts + thread count = total posts
            $postCount = $categoryThreads->whereNull(Thread::DELETED_AT)->sum('reply_count') + $threadCount;

            $category = $categoryThreads->first()->category;

            $updates = [
                'newest_thread_id' => $category->getNewestThreadId(),
                'latest_active_thread_id' => $category->getLatestActiveThreadId(),
            ];

            if ($threadCount > 0) {
                $updates['thread_count'] = DB::raw("thread_count - {$threadCount}");
            }
            if ($postCount > 0) {
                $updates['post_count'] = DB::raw("post_count - {$postCount}");
            }

            $category->update($updates);
        }

        return $this->bulkActionResponse($threads->count(), 'threads.updated');
    }
    public function bulk_thread_restore(Request $request)
    {
        $threadIds = $request->input('threads');

        $threads = Thread::whereIn('id', $threadIds)->onlyTrashed()->get();

        // Return early if there are no eligible threads in the selection
        if ($threads->count() == 0) {
            return null;
        }

        // Use the raw query builder to prevent touching updated_at
        $rowsAffected = DB::table(Thread::getTableName())
            ->whereIn('id', $threadIds)
            ->whereNotNull(Thread::DELETED_AT)
            ->update([Thread::DELETED_AT => null]);

        if ($rowsAffected == 0) {
            return null;
        }

        $threadsByCategory = $threads->groupBy('category_id');
        foreach ($threadsByCategory as $threads) {
            $threadCount = $threads->count();
            $postCount = $threads->sum('reply_count') + $threadCount; // count the first post of each thread
            $category = $threads->first()->category;

            $category->updateWithoutTouch([
                'newest_thread_id' => max($threads->max('id'), $category->newest_thread_id),
                'latest_active_thread_id' => $category->getLatestActiveThreadId(),
                'thread_count' => DB::raw("thread_count + {$threadCount}"),
                'post_count' => DB::raw("post_count + {$postCount}"),
            ]);
        }

        return $this->bulkActionResponse($threads->count(), 'threads.updated');
    }
}
