<!doctype html>
<html {!! get_language_attributes() !!}>
@include('head.index')
<body @php body_class() @endphp>
<section id="app" class="body">
  @php do_action('get_header') @endphp
  @include('header.index')
  <main class="main">
    <div class="main-container container" role="document">
      <div class="main-content">
        @yield('content')
      </div>
      @yield('sidebar')
    </div>
  </main>
  @php do_action('get_footer') @endphp
  @include('footer.index')
  @php wp_footer() @endphp
</section>
</body>
</html>
