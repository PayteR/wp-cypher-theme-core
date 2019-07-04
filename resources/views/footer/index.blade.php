<footer class="footer">
  @include('footer.before.')
  <div class="container footer-container">
    <span class="footer-copyright">Copyright &copy; {{ get_bloginfo('name', 'display') }} {{ date("Y") }}</span>
    @php dynamic_sidebar('sidebar-footer') @endphp
  </div>
  @include('footer.after.')
</footer>
