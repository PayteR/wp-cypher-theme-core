@php
  $custom_logo_id = get_theme_mod( 'custom_logo' );
  $logo_img = false;
  if($custom_logo_id) {
    $custom_logo_attr = [
      'class'    => 'navbar-logo',
      'itemprop' => 'logo',
      'alt' => get_bloginfo( 'name', 'display' ),
    ];
    $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
  }
@endphp

<a class="navbar-item" href="{{ home_url('/') }}">
  @if($logo_img)
    {!! $logo_img !!}
  @else
    {{ get_bloginfo('name', 'display') }}
  @endif
</a>
