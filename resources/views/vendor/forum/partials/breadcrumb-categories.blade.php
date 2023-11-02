@if ($category->parent !== null)
    @include ('vendor.forum.partials.breadcrumb-categories', ['category' => $category->parent])
@endif
<li class="breadcrumb-item"><a href="{{ route('cf.category.show', $category) }}">{{ $category->title }}</a></li>
