@extends ('vendor.forum.master', ['thread' => null, 'breadcrumbs_append' => [$thread->title], 'thread_title' => $thread->title])

@section ('content')
    <div id="thread" class="v-thread">
        <div class="d-flex flex-column flex-md-row justify-content-between">
            <h2 class="flex-grow-1">{{ $thread->title }}</h2>

            <div>
                @if ($user && $user->can('deleteThreads', $thread->category) && $user && $user->can('delete', $thread))
                    @if ($thread->trashed())
                        <a href="#" class="btn btn-danger mr-3 mb-2" data-open-modal="perma-delete-thread">
                            <i data-feather="trash"></i> {{ trans('forum::general.perma_delete') }}
                        </a>
                    @else
                        <a href="#" class="btn btn-danger mr-3 mb-2" data-open-modal="delete-thread">
                            <i data-feather="trash"></i> {{ trans('forum::general.delete') }}
                        </a>
                    @endif
                @endif
                @if ($thread->trashed() && $user && $user->can('restoreThreads', $thread->category) && $user && $user->can('restore', $thread))
                    <a href="#" class="btn btn-secondary mb-2" data-open-modal="restore-thread">
                        <i data-feather="refresh-cw"></i> {{ trans('forum::general.restore') }}
                    </a>
                @endif

                @if ($user && $user->can('lockThreads', $category)
                    || $user && $user->can('pinThreads', $category)
                    || $user && $user->can('rename', $thread)
                    || $user && $user->can('moveThreadsFrom', $category))
                    <div class="btn-group mb-2" role="group">
                        @if (! $thread->trashed())
                            @if ($user && $user->can('lockThreads', $category))
                                @if ($thread->locked)
                                    <a href="#" class="btn btn-secondary" data-open-modal="unlock-thread">
                                        <i data-feather="unlock"></i> {{ trans('forum::threads.unlock') }}
                                    </a>
                                @else
                                    <a href="#" class="btn btn-secondary" data-open-modal="lock-thread">
                                        <i data-feather="lock"></i> {{ trans('forum::threads.lock') }}
                                    </a>
                                @endif
                            @endif
                            @if ($user && $user->can('pinThreads', $category))
                                @if ($thread->pinned)
                                    <a href="#" class="btn btn-secondary" data-open-modal="unpin-thread">
                                        <i data-feather="arrow-down"></i> {{ trans('forum::threads.unpin') }}
                                    </a>
                                @else
                                    <a href="#" class="btn btn-secondary" data-open-modal="pin-thread">
                                        <i data-feather="arrow-up"></i> {{ trans('forum::threads.pin') }}
                                    </a>
                                @endif
                            @endif
                            @if ($user && $user->can('rename', $thread))
                                <a href="#" class="btn btn-secondary" data-open-modal="rename-thread">
                                    <i data-feather="edit-2"></i> {{ trans('forum::general.rename') }}
                                </a>
                            @endif
                            @if ($user && $user->can('moveThreadsFrom', $category))
                                <a href="#" class="btn btn-secondary" data-open-modal="move-thread">
                                    <i data-feather="corner-up-right"></i> {{ trans('forum::general.move') }}
                                </a>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>


        <div class="thread-badges">
            @if ($thread->trashed())
                <span class="badge rounded-pill bg-danger">{{ trans('forum::general.deleted') }}</span>
            @endif
            @if ($thread->pinned)
                <span class="badge rounded-pill bg-info">{{ trans('forum::threads.pinned') }}</span>
            @endif
            @if ($thread->locked)
                <span class="badge rounded-pill bg-warning">{{ trans('forum::threads.locked') }}</span>
            @endif
        </div>

        <hr>

        @if ((count($posts) > 1 || $posts->currentPage() > 1) && ($user && $user->can('deletePosts', $thread) || $user && $user->can('restorePosts', $thread)) && count($selectablePosts) > 0)
            <form :action="postActions[selectedPostAction]" method="POST">
                @csrf
                <input type="hidden" name="_method" :value="postActionMethods[selectedPostAction]" />
        @endif

        <div class="row mb-3">
            <div class="col col-xs-8">
                {{ $posts->links('vendor.forum.pagination') }}
            </div>
            <div class="col-md-auto text-end">
                @if (! $thread->trashed())
                    @if ($user && $user->can('reply', $thread))
                        <div class="btn-group" role="group">
                            <a href="{{ route('cf.post.create', $thread) }}" class="btn btn-primary">
                                {{ trans('forum::general.new_reply') }}
                            </a>
                            <a href="#quick-reply" class="btn btn-primary">
                                {{ trans('forum::general.quick_reply') }}
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        @if ((count($posts) > 1 || $posts->currentPage() > 1) && ($user && $user->can('deletePosts', $thread) || $user && $user->can('restorePosts', $thread)) && count($selectablePosts) > 0)
            <div class="text-end pb-1">
                <div class="form-check">
                    <label for="selectAllPosts">
                        {{ trans('forum::posts.select_all') }}
                    </label>
                    <input type="checkbox" value="" id="selectAllPosts" class="align-middle" @click="toggleAll" :checked="selectedPosts.length == posts.data.length">
                </div>
            </div>
        @endif

        @foreach ($posts as $post)
            @include ('vendor.forum.post.partials.list', compact('post'))
        @endforeach

        @if ((count($posts) > 1 || $posts->currentPage() > 1) && ($user && $user->can('deletePosts', $thread) || $user && $user->can('restorePosts', $thread)) && count($selectablePosts) > 0)
                <div class="fixed-bottom-right pb-xs-0 pr-xs-0 pb-sm-3 pr-sm-3">
                    <transition name="fade">
                        <div class="card text-white bg-secondary shadow-sm" v-if="selectedPosts.length">
                            <div class="card-header text-center">
                                {{ trans('forum::general.with_selection') }}
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="bulk-actions">{{ trans_choice('forum::general.actions', 1) }}</label>
                                    </div>
                                    <select class="custom-select" id="bulk-actions" v-model="selectedPostAction">
                                        <option value="delete">{{ trans('forum::general.delete') }}</option>
                                        <option value="restore">{{ trans('forum::general.restore') }}</option>
                                    </select>
                                </div>

                                @if (config('forum.general.soft_deletes'))
                                    <div class="form-check mb-3" v-if="selectedPostAction == 'delete'">
                                        <input class="form-check-input" type="checkbox" name="permadelete" value="1" id="permadelete">
                                        <label class="form-check-label" for="permadelete">
                                            {{ trans('forum::general.perma_delete') }}
                                        </label>
                                    </div>
                                @endif

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" @click="submitPosts">{{ trans('forum::general.proceed') }}</button>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </form>
        @endif

        {{ $posts->links('vendor.forum.pagination') }}

        @if (! $thread->trashed())
            @if ($user && $user->can('reply', $thread))
                <h3>{{ trans('forum::general.quick_reply') }}</h3>
                <div id="quick-reply">
                    <form method="POST" action="{{ route('cf.post.store', $thread) }}">
                        @csrf

                        <div class="mb-3">
                            <textarea name="content" class="form-control">{{ old('content') }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-5">{{ trans('forum::general.reply') }}</button>
                        </div>
                    </form>
                </div>
            @endif
        @endif
    </div>

    @if ($thread->trashed() && $user && $user->can('restoreThreads', $thread->category) && $user && $user->can('restore', $thread))
        @component('vendor.forum.modal-form')
            @slot('key', 'restore-thread')
            @slot('title', '<i data-feather="refresh-cw" class="text-muted"></i>' . trans('forum::general.restore'))
            @slot('route', route('cf.thread.restore', $thread))
            @slot('method', 'POST')

            {{ trans('forum::general.generic_confirm') }}

            @slot('actions')
                <button type="submit" class="btn btn-primary">{{ trans('forum::general.proceed') }}</button>
            @endslot
        @endcomponent
    @endif

    @if ($user && $user->can('deleteThreads', $thread->category) && $user && $user->can('delete', $thread))
        @component('vendor.forum.modal-form')
            @slot('key', 'delete-thread')
            @slot('title', '<i data-feather="trash" class="text-muted"></i>' . trans('forum::threads.delete'))
            @slot('route', route('cf.thread.delete', $thread))
            @slot('method', 'DELETE')

            @if (config('forum.general.soft_deletes'))
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permadelete" value="1" id="permadelete">
                    <label class="form-check-label" for="permadelete">
                        {{ trans('forum::general.perma_delete') }}
                    </label>
                </div>
            @else
                {{ trans('forum::general.generic_confirm') }}
            @endif

            @slot('actions')
                <button type="submit" class="btn btn-danger">{{ trans('forum::general.proceed') }}</button>
            @endslot
        @endcomponent

        @if (config('forum.general.soft_deletes'))
            @component('vendor.forum.modal-form')
                @slot('key', 'perma-delete-thread')
                @slot('title', '<i data-feather="trash" class="text-muted"></i>' . trans_choice('forum::threads.perma_delete', 1))
                @slot('route', route('cf.thread.delete', $thread))
                @slot('method', 'DELETE')

                <input type="hidden" name="permadelete" value="1" />

                {{ trans('forum::general.generic_confirm') }}

                @slot('actions')
                    <button type="submit" class="btn btn-danger">{{ trans('forum::general.proceed') }}</button>
                @endslot
            @endcomponent
        @endif
    @endif

    @if (! $thread->trashed())
        @if ($user && $user->can('lockThreads', $category))
            @if ($thread->locked)
                @component('vendor.forum.modal-form')
                    @slot('key', 'unlock-thread')
                    @slot('title', '<i data-feather="unlock" class="text-muted"></i> ' . trans('forum::threads.unlock'))
                    @slot('route', route('cf.thread.unlock', $thread))
                    @slot('method', 'POST')

                    {{ trans('forum::general.generic_confirm') }}

                    @slot('actions')
                        <button type="submit" class="btn btn-primary">{{ trans('forum::general.proceed') }}</button>
                    @endslot
                @endcomponent
            @else
                @component('vendor.forum.modal-form')
                    @slot('key', 'lock-thread')
                    @slot('title', '<i data-feather="lock" class="text-muted"></i> ' . trans('forum::threads.lock'))
                    @slot('route', route('cf.thread.lock', $thread))
                    @slot('method', 'POST')

                    {{ trans('forum::general.generic_confirm') }}

                    @slot('actions')
                        <button type="submit" class="btn btn-primary">{{ trans('forum::general.proceed') }}</button>
                    @endslot
                @endcomponent
            @endif
        @endif
        @if ($user && $user->can('pinThreads', $category))
            @if ($thread->pinned)
                @component('vendor.forum.modal-form')
                    @slot('key', 'unpin-thread')
                    @slot('title', '<i data-feather="arrow-down" class="text-muted"></i> ' . trans('forum::threads.unpin'))
                    @slot('route', route('cf.thread.unpin', $thread))
                    @slot('method', 'POST')

                    {{ trans('forum::general.generic_confirm') }}

                    @slot('actions')
                        <button type="submit" class="btn btn-primary">{{ trans('forum::general.proceed') }}</button>
                    @endslot
                @endcomponent
            @else
                @component('vendor.forum.modal-form')
                    @slot('key', 'pin-thread')
                    @slot('title', '<i data-feather="arrow-up" class="text-muted"></i> ' . trans('forum::threads.pin'))
                    @slot('route', route('cf.thread.pin', $thread))
                    @slot('method', 'POST')

                    {{ trans('forum::general.generic_confirm') }}

                    @slot('actions')
                        <button type="submit" class="btn btn-primary">{{ trans('forum::general.proceed') }}</button>
                    @endslot
                @endcomponent
            @endif
        @endif

        @if ($user && $user->can('rename', $thread))
            @component('vendor.forum.modal-form')
                @slot('key', 'rename-thread')
                @slot('title', '<i data-feather="edit-2" class="text-muted"></i> ' . trans('forum::general.rename'))
                @slot('route', route('cf.thread.rename', $thread))
                @slot('method', 'POST')

                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="new-title">{{ trans('forum::general.title') }}</label>
                    </div>
                    <input type="text" name="title" value="{{ $thread->title }}" class="form-control">
                </div>

                @slot('actions')
                    <button type="submit" class="btn btn-primary">{{ trans('forum::general.proceed') }}</button>
                @endslot
            @endcomponent
        @endif

        @if ($user && $user->can('moveThreadsFrom', $category))
            @component('vendor.forum.modal-form')
                @slot('key', 'move-thread')
                @slot('title', '<i data-feather="corner-up-right" class="text-muted"></i> ' . trans('forum::general.move'))
                @slot('route', route('cf.thread.move', $thread))
                @slot('method', 'POST')

                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                    </div>
                    <select name="category_id" id="category-id" class="form-select">
                        @include ('vendor.forum.category.partials.options', ['hide' => $thread->category])
                    </select>
                </div>

                @slot('actions')
                    <button type="submit" class="btn btn-primary">{{ trans('forum::general.proceed') }}</button>
                @endslot
            @endcomponent
        @endif
    @endif

    <style>
    .thread-badges .badge
    {
        font-size: 100%;
    }
    </style>

    <script>
    new Vue({
        el: '.v-thread',
        name: 'Thread',
        data: {
            posts: @json($posts),
            selectablePosts: @json($selectablePosts),
            postActions: {
                'delete': "{{ route('cf.bulk.post.delete') }}",
                'restore': "{{ route('cf.bulk.post.restore') }}"
            },
            postActionMethods: {
                'delete': 'DELETE',
                'restore': 'POST'
            },
            selectedPostAction: 'delete',
            selectedPosts: [],
            selectedThreadAction: null
        },
        created ()
        {
            this.posts.data = this.posts.data.filter(post => post.sequence != 1);
        },
        methods: {
            toggleAll ()
            {
                this.selectedPosts = (this.selectedPosts.length < this.selectablePosts.length) ? this.selectablePosts : [];
            },
            submitThread (event)
            {
                if (this.threadActionMethods[this.selectedThreadAction] === 'DELETE' && ! confirm("{{ trans('forum::general.generic_confirm') }}"))
                {
                    event.preventDefault();
                }
            },
            submitPosts (event)
            {
                if (this.postActionMethods[this.selectedPostAction] === 'DELETE' && ! confirm("{{ trans('forum::general.generic_confirm') }}"))
                {
                    event.preventDefault();
                }
            }
        }
    });
    </script>
@stop
