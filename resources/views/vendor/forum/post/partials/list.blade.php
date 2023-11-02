<div @if (! $post->trashed())id="post-{{ $post->sequence }}"@endif
    class="post card mb-2 {{ $post->trashed() || $thread->trashed() ? 'deleted' : '' }}"
    :class="{ 'border-primary': selectedPosts.includes({{ $post->id }}) }">
    <div class="card-header">
        @if (! isset($single) || ! $single)
            <span class="float-end">
                <a href="{{ route('cf.thread.show', ['thread' => $thread, 'page' => ceil($post->sequence / $post->getPerPage())])."#post-{$post->sequence}" }}">#{{ $post->sequence }}</a>
                @if ($post->sequence != 1)
                    @if ($user->can('deletePosts', $post->thread))
                        @if ($user->can('delete', $post))
                            <input type="checkbox" name="posts[]" :value="{{ $post->id }}" v-model="selectedPosts">
                        @endif
                    @endif
                @endif
            </span>
        @endif

        {{ $post->authorName }}

        <span class="text-muted">
            @include ('vendor.forum.partials.timestamp', ['carbon' => $post->created_at])
            @if ($post->hasBeenUpdated())
                ({{ trans('forum::general.last_updated') }} @include ('vendor.forum.partials.timestamp', ['carbon' => $post->updated_at]))
            @endif
        </span>
    </div>
    <div class="card-body">
        @if ($post->parent !== null)
            @include ('vendor.forum.post.partials.quote', ['post' => $post->parent])
        @endif

        @if ($post->trashed())
            @if ($user->can('viewTrashedPosts'))
                {!! Forum::render($post->content) !!}
                <br>
            @endif
            <span class="badge rounded-pill bg-danger">{{ trans('forum::general.deleted') }}</span>
        @else
            {!! Forum::render($post->content) !!}
        @endif

        @if (! isset($single) || ! $single)
            <div class="text-end">
                @if (! $post->trashed())
                    <a href="{{ route('cf.post.show', ['thread' => $thread->id, 'post' => $post->id]) }}" class="card-link text-muted">{{ trans('forum::general.permalink') }}</a>
                    @if ($post->sequence != 1)
                        @if ($user->can('deletePosts', $post->thread))
                            @if ($user->can('delete', $post))
                                <a href="{{ route('cf.post.confirm-delete', ['thread' => $thread->id, 'post' => $post->id]) }}" class="card-link text-danger">{{ trans('forum::general.delete') }}</a>
                            @endif
                        @endif
                    @endif
                    @if ($user->can('edit', $post))
                        <a href="{{ route('cf.post.edit', ['thread' => $thread, 'post' => $post]) }}" class="card-link">{{ trans('forum::general.edit') }}</a>
                    @endif
                    @if ($user->can('reply', $post->thread))
                        <a href="{{ route('cf.post.create', ['thread' => $post->thread, 'post' => $post]) }}" class="card-link">{{ trans('forum::general.reply') }}</a>
                    @endif
                @else
                    @if ($user->can('restorePosts', $post->thread))
                        @if ($user->can('restore', $post))
                            <a href="{{ route('cf.post.confirm-restore', ['thread' => $post->thread, 'post' => $post]) }}" class="card-link">{{ trans('forum::general.restore') }}</a>
                        @endif
                    @endif
                @endif
            </div>
        @endif
    </div>
</div>
