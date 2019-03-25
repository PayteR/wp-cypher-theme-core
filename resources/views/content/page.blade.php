<article @php post_class() @endphp>
  @if(App::title())
  <header>
    @include('partials.page-header')
  </header>
  @endif
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'cypher'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
