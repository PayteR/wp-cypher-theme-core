<article @php post_class() @endphp>
  @if (App::title() && Cypher\display_title())
  <header>
    @include('partials.post-header')
  </header>
  @endif
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'cypher'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
