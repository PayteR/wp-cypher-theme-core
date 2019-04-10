<article @php post_class('entry is-singular is-type-' . get_post_type()) @endphp>
  @if (Cypher\display_title() && App::title())
  <header>
    @include('partials.header.page')
  </header>
  @endif

  @include('partials/entry/image', ['size' => 'full'])
  @include('partials/entry/content')

  <footer>
    @include('partials/entry/navigation')
  </footer>
</article>
