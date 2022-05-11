<ul class="unstyled-list list-inline">
  @for ($i = 0; $i < $avgRating; $i++)
    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
  @endfor
  @for ($i = 0; $i < 5 - $avgRating; $i++)
    <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
  @endfor
</ul>
