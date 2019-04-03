@if ($position = Cypher\display_sidebar())
<aside class="main-sidebar is-{{ $position }}">
  @php dynamic_sidebar('sidebar-primary') @endphp
</aside>
@endif
