<div class="entry-tags tags">
  <span class="entry-tags-title">{{ vendor__('Tags') }}:</span>
  @php $terms = get_the_terms( null, 'post_tag' ); @endphp

  @foreach($terms as $term)
    <a class="entry-tags-item tag"
       href="{{ esc_url( get_term_link( $term ) ) }}"
       rel="tag">{{ $term->name }}</a>
  @endforeach
</div>
