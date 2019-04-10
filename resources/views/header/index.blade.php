<header class="header">
  @include('header.before.')
  @php $is_cart = Cypher\is_woocommerce_activated() @endphp
  <div class="header-container">
    <nav class="navbar {{ $is_cart ? 'is-cart' : '' }}" role="navigation" aria-label="main navigation">
      <div class="container is-tablet-only-padding">
        <div class="navbar-brand">
          @include('partials.logo')

          @includeWhen($is_cart, 'header.partials.cart-mobile')

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
                  'walker' => new Cypher\NavWalker()
              ]) !!}
            @endif
          </div>

          @includeWhen($is_cart, 'header.partials.cart')
        </div>
      </div>
    </nav>
  </div>
  @include('header.after.')
</header>
