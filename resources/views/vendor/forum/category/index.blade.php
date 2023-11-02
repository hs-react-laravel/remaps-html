{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('vendor.forum.master', ['category' => null])

@section ('content')
    <div class="d-flex flex-row justify-content-between mb-2">
        <h2 class="flex-grow-1">{{ trans('forum::general.index') }}</h2>

        @if ($user->can('moveCategories'))
            <button type="button" class="btn btn-primary" data-open-modal="create-category">
                {{ trans('forum::categories.create') }}
            </button>

            @include ('vendor.forum.category.modals.create')
        @endif
    </div>

    @foreach ($categories as $category)
        @include ('vendor.forum.category.partials.list', ['titleClass' => 'lead'])
    @endforeach
@stop
