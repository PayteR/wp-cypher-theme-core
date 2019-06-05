@php $cart = WC()->cart; @endphp
@php $cart_count = $cart->get_cart_contents_count(); @endphp
@php $link = $cart_count ? get_permalink( wc_get_page_id( 'cart' ) ) : get_permalink( wc_get_page_id( 'shop' ) );
@endphp


<div class="navbar-cart is-desktop">
  <div class="navbar-item is-cart has-dropdown is-hoverable">
    <a href="{{ $link }}" class="navbar-link">
      <i class="navbar-cart-icon icon fa fa-shopping-cart"></i>
      <span class="navbar-cart-count">{{ $cart_count }}</span>
    </a>
    @if(!is_cart() && !is_checkout())
    <div class="navbar-dropdown is-right">
      @if($cart_count)
        {{ \the_widget('WC_Widget_Cart') }}
      @else
        <a href="{{ $link }}" class="button is-primary"
 type="submit">{{ __('Go to shop', 'cypher') }}</a>
      @endif
    </div>
    @endif
  </div>
</div>
