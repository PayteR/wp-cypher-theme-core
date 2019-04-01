<!doctype html>
<html {!! get_language_attributes() !!}>
@include('head.')
<body @php body_class() @endphp>
<section id="app" class="body">
  @php do_action('get_header') @endphp
  @include('header.')
  <main class="main">
    <div class="main-container container" role="document">
      <div class="main-content">
        @yield('content')
      </div>
      @yield('sidebar')
    </div>
  </main>
  @php do_action('get_footer') @endphp
  @include('footer.')
  @php wp_footer() @endphp
</section>
</body>
</html>
