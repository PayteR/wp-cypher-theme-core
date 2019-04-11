@php
if (post_password_required()) {
  return;
}
@endphp

<section id="comments" class="comments">
  @if (have_comments())
    <h2 class="comments-title title">
      @php
        if ( 1 == get_comments_number() ) {
              /* translators: %s: post title */
              printf( vendor__( 'One response to %s' ), '&#8220;' . get_the_title() . '&#8221;' );
          } else {
              /* translators: 1: number of comments, 2: post title */
              printf(
                  vendor_n( '%1$s response to %2$s', '%1$s responses to %2$s', get_comments_number() ),
                  number_format_i18n( get_comments_number() ),
                  '&#8220;' . get_the_title() . '&#8221;'
              );
          }
      @endphp
    </h2>

    <ol class="comment-list">
      {!! wp_list_comments(['style' => 'ol', 'short_ping' => true]) !!}
    </ol>

    @if (get_comment_pages_count() > 1 && get_option('page_comments'))
      <nav class="comments-navbar">
        <ul class="pager">
          @if (get_previous_comments_link())
            <li class="previous">@php previous_comments_link(vendor__('&larr; Older comments')) @endphp</li>
          @endif
          @if (get_next_comments_link())
            <li class="next">@php next_comments_link(vendor__('Newer comments &rarr;')) @endphp</li>
          @endif
        </ul>
      </nav>
    @endif
  @endif

  @if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments'))
    <div class="notification is-warning">
      {{ vendor__('Comments are closed.') }}
    </div>
  @endif

  @php comment_form() @endphp
</section>
