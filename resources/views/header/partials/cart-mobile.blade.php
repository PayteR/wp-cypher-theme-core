@php $cart = WC()->cart; @endphp
@php $cart_count = $cart ? $cart->get_cart_contents_count() : 0; @endphp
@php $link = $cart_count ? get_permalink( wc_get_page_id( 'cart' ) ) : get_permalink( wc_get_page_id( 'shop' ) );
@endphp

<div class="navbar-cart is-mobile">
  <div class="navbar-item is-cart has-dropdown is-hoverable">
    <a href="{{ $link }}" class="navbar-link">
      <i class="navbar-cart-icon icon fa fa-shopping-cart"></i>
      @if($cart_count)
        <span class="navbar-cart-count">{{ $cart_count }}</span>
      @endif
    </a>
  </div>
</div>
