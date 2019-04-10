<article @php post_class('entry is-singular is-type-' . get_post_type()) @endphp>
  @if (Cypher\display_title() && App::title())
  <header>
    @include('partials.header.post')
  </header>
  @endif

  @include('partials/entry/image', ['size' => 'full'])
  @include('partials/entry/content')
  @include('partials/entry/tags')

  <footer>
    @include('partials/entry/navigation')
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
