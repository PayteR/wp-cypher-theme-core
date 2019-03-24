<header class="header">
  <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <div class="container">
      <div class="navbar-brand">
        @include('partials.logo')

        <a role="button" class="navbar-burger" aria-label="menu" data-target="primary_navigation"
           aria-expanded="false">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="primary_navigation" class="navbar-menu">
        <div class="navbar-start"></div>
        <div class="navbar-end">
          @if (has_nav_menu('primary_navigation'))
            {!! wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container' => false,
                'items_wrap' => '%3$s',
                'walker' => new App\Cypher\NavWalker()
            ]) !!}
          @endif
        </div>
      </div>
    </div>
  </nav>
</header>
