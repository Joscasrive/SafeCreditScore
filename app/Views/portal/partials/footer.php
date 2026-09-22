      </div><!-- /.portal-content -->
    </div><!-- /.portal-main -->
  </div><!-- /.portal-shell -->

  <script>
    (function () {
      var sidebar = document.getElementById('portalSidebar');
      var overlay = document.getElementById('portalOverlay');
      var toggle  = document.getElementById('portalToggle');

      function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
      }

      if (toggle) {
        toggle.addEventListener('click', function () {
          sidebar.classList.toggle('is-open');
          overlay.classList.toggle('is-visible');
        });
      }

      if (overlay) {
        overlay.addEventListener('click', closeSidebar);
      }
    })();
  </script>
</body>
</html>
