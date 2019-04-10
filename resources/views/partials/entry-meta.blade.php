<div class="entry-meta">
  <time class="entry-meta-date" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
  <span class="entry-meta-categories">
    @php the_category(', ') @endphp
  </span>
  <span class="entry-meta-author">
    {{ _x('By', 'post meta', 'cypher') }} <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
      {{ get_the_author() }}
    </a>
  </span>
</div>

