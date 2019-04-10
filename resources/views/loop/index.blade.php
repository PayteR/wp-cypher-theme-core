<article @php post_class('media entry is-loop is-type-' . get_post_type()) @endphp>
  <figure class="media-left">
    <a href="{{ get_permalink() }}" class="entry-image image">
      @php the_post_thumbnail('thumbnail') @endphp
    </a>
  </figure>
  <div class="media-content">
    <header>
      <h2 class="entry-title title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h2>
      @if (get_post_type() === 'post')
        @include('partials/entry-meta')
      @endif
    </header>
    <div class="entry-summary">
      @php the_excerpt() @endphp
    </div>
  </div>
</article>
