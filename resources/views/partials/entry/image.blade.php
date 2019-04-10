@if(has_post_thumbnail())
  @if(isset($isPermalink) && $isPermalink)
    <a href="{{ get_permalink() }}" class="entry-image image">
      @php the_post_thumbnail($size) @endphp
    </a>
  @else
    <div class="entry-image image">
      @php the_post_thumbnail($size) @endphp
    </div>
  @endif
@endif
