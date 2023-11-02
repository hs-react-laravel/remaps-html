{{-- $thread is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends('vendor.forum.master', ['thread' => null])

@section('content')
    <div class="d-flex flex-row justify-content-between mb-2">
        <h2 style="color: {{ $category->color }};">
            {{ $category->title }} &nbsp;
            @if ($category->description)
                <small>{{ $category->description }}</small>
            @endif
        </h2>
    </div>

    <div class="v-category-show">
        <div class="clearfix">
            @if ($category->accepts_threads)
                @if($user->can('createThreads', $category))
                    <a href="{{ route('cf.thread.create', $category) }}" class="btn btn-primary float-end">{{ trans('forum::threads.new_thread') }}</a>
                @endif
            @endif

            <div class="btn-group" role="group">
                @if ($user->can('manageCategories'))
                    <button type="button" class="btn btn-secondary" data-open-modal="edit-category">
                        {{ trans('forum::general.edit') }}
                    </button>
                @endif
            </div>
        </div>

        @if (! $category->children->isEmpty())
            @foreach ($category->children as $subcategory)
                @include('vendor.forum.category.partials.list', ['category' => $subcategory])
            @endforeach
        @endif

        @if ($category->accepts_threads)
            @if (! $threads->isEmpty())
                <div class="mt-4">
                    {{ $threads->links('vendor.forum.pagination') }}
                </div>

                @if (count($selectableThreadIds) > 0)
                    @if ($user->can('manageThreads', $category))
                        <form :action="actions[selectedAction]" method="POST">
                            @csrf
                            <input type="hidden" name="_method" :value="actionMethods[selectedAction]" />

                            <div class="text-end mt-2">
                                <div class="form-check">
                                    <label for="selectAllThreads">
                                        {{ trans('forum::threads.select_all') }}
                                    </label>
                                    <input type="checkbox" value="" id="selectAllThreads" class="align-middle" @click="toggleAll" :checked="selectedThreads.length == selectableThreadIds.length">
                                </div>
                            </div>
                    @endif
                @endif

                <div class="threads list-group my-3 shadow-sm">
                    @foreach ($threads as $thread)
                        @include ('vendor.forum.thread.partials.list')
                    @endforeach
                </div>

                @if (count($selectableThreadIds) > 0)
                    @if ($user->can('manageThreads', $category))
                            <div class="fixed-bottom-right pb-xs-0 pr-xs-0 pb-sm-3 pr-sm-3 m-2" style="z-index: 1000;">
                                <transition name="fade">
                                    <div class="card text-white bg-secondary shadow-sm" v-if="selectedThreads.length">
                                        <div class="card-header text-center">
                                            {{ trans('forum::general.with_selection') }}
                                        </div>
                                        <div class="card-body">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="bulk-actions">{{ trans_choice('forum::general.actions', 1) }}</label>
                                                </div>
                                                <select class="form-select" id="bulk-actions" v-model="selectedAction">
                                                    @if ($user->can('deleteThreads', $category))
                                                        <option value="delete">{{ trans('forum::general.delete') }}</option>
                                                    @endif
                                                    @if ($user->can('restoreThreads', $category))
                                                        <option value="restore">{{ trans('forum::general.restore') }}</option>
                                                    @endif
                                                    @if ($user->can('moveThreadsFrom', $category))
                                                        <option value="move">{{ trans('forum::general.move') }}</option>
                                                    @endif
                                                    @if ($user->can('lockThreads', $category))
                                                        <option value="lock">{{ trans('forum::threads.lock') }}</option>
                                                        <option value="unlock">{{ trans('forum::threads.unlock') }}</option>
                                                    @endif
                                                    @if ($user->can('pinThreads', $category))
                                                        <option value="pin">{{ trans('forum::threads.pin') }}</option>
                                                        <option value="unpin">{{ trans('forum::threads.unpin') }}</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="mb-3" v-if="selectedAction == 'move'">
                                                <label for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                                                <select name="category_id" id="category-id" class="form-select">
                                                    @include ('vendor.forum.category.partials.options', ['hide' => $category])
                                                </select>
                                            </div>

                                            @if (config('forum.general.soft_deletes'))
                                                <div class="form-check mb-3" v-if="selectedAction == 'delete'">
                                                    <input class="form-check-input" type="checkbox" name="permadelete" value="1" id="permadelete">
                                                    <label class="form-check-label" for="permadelete">
                                                        {{ trans('forum::general.perma_delete') }}
                                                    </label>
                                                </div>
                                            @endif

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary" @click="submit" :disabled="selectedAction == null">{{ trans('forum::general.proceed') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </form>
                    @endif
                @endif
            @else
                <div class="card my-3">
                    <div class="card-body">
                        {{ trans('forum::threads.none_found') }}
                        @if($user->can('createThreads', $category))
                            <br>
                            <a href="{{ route('cf.thread.create', $category) }}">{{ trans('forum::threads.post_the_first') }}</a>
                        @endif
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col col-xs-8">
                    {{ $threads->links('vendor.forum.pagination') }}
                </div>
                <div class="col col-xs-4 text-end">
                    @if ($category->accepts_threads)
                        @if($user->can('createThreads', $category))
                            <a href="{{ route('cf.thread.create', $category) }}" class="btn btn-primary">{{ trans('forum::threads.new_thread') }}</a>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>

    @if (! $threads->isEmpty())
        @if ($user->can('markThreadsAsRead'))
            <div class="text-center mt-3">
                <button class="btn btn-primary px-5" data-open-modal="mark-threads-as-read">
                    <i data-feather="book"></i> {{ trans('forum::general.mark_read') }}
                </button>
            </div>

            @include ('vendor.forum.category.modals.mark-threads-as-read')
        @endif
    @endif

    @if ($user->can('manageCategories'))
        @include ('vendor.forum.category.modals.edit')
        @include ('vendor.forum.category.modals.delete')
    @endif

    <style>
    .list-group.threads .list-group-item
    {
        border-left-width: 2px;
    }

    .list-group.threads .list-group-item.locked
    {
        border-left-color: var(--bs-yellow);
    }

    .list-group.threads .list-group-item.pinned
    {
        border-left-color: var(--bs-cyan);
    }

    .list-group.threads .list-group-item.deleted
    {
        border-left-color: var(--bs-red);
        opacity: 0.5;
    }
    </style>

    <script>
    new Vue({
        el: '.v-category-show',
        name: 'CategoryShow',
        data: {
            selectableThreadIds: @json($selectableThreadIds),
            actions: {
                'delete': "{{ route('cf.bulk.thread.delete') }}",
                'restore': "{{ route('cf.bulk.thread.restore') }}",
                'lock': "{{ route('cf.bulk.thread.lock') }}",
                'unlock': "{{ route('cf.bulk.thread.unlock') }}",
                'pin': "{{ route('cf.bulk.thread.pin') }}",
                'unpin': "{{ route('cf.bulk.thread.unpin') }}",
                'move': "{{ route('cf.bulk.thread.move') }}"
            },
            actionMethods: {
                'delete': 'DELETE',
                'restore': 'POST',
                'lock': 'POST',
                'unlock': 'POST',
                'pin': 'POST',
                'unpin': 'POST',
                'move': 'POST'
            },
            selectedAction: null,
            selectedThreads: [],
            isEditModalOpen: false,
            isDeleteModalOpen: false
        },
        methods: {
            toggleAll ()
            {
                this.selectedThreads = (this.selectedThreads.length < this.selectableThreadIds.length) ? this.selectableThreadIds : [];
            },
            submit (event)
            {
                if (this.actionMethods[this.selectedAction] === 'DELETE' && ! confirm("{{ trans('forum::general.generic_confirm') }}"))
                {
                    event.preventDefault();
                }
            },
            onClickModal (event)
            {
                if (event.target.classList.contains('modal'))
                {
                    this.isEditModalOpen = false;
                    this.isDeleteModalOpen = false;
                }
            }
        }
    });
    </script>
@stop
