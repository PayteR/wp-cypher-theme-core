@php $cart = WC()->cart; @endphp
@php $cart_subtotal = $cart->get_cart_contents_total(); @endphp
@php $cart_count = $cart->get_cart_contents_count(); @endphp



<div class="navbar-cart is-desktop">
  <div href="{{ wc_get_cart_url() }}" class="navbar-item is-cart has-dropdown is-hoverable">
    <a href="#" class="navbar-link">
      <i class="navbar-cart-icon icon fa fa-shopping-cart"></i>
      @if($cart_count)
      <span class="navbar-cart-count">{{ $cart_count }}</span>
      @endif
    </a>
    <div class="navbar-dropdown is-right">
      @if($cart_subtotal)
        {{ \the_widget('WC_Widget_Cart') }}
      @else
        <a href="{{ get_permalink( wc_get_page_id( 'shop' ) )  }}" class="button is-primary"
 type="submit">{{ __('Go to shop now', 'cypher') }}</a>
      @endif
    </div>
  </div>
</div>
