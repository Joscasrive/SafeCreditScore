  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/jquery/jquery-migrate.min.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Plugin's Scripts -->
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/inlineSvg/inlineSvg.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/fancybox/jquery.fancybox.min.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/aos/aos.min.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/isotope/isotope.pkgd.min.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/isotope/packery.pkgd.min.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/isotope/image.loaded.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/slick/slick.min.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>plugins/countdown/jquery.countdown.js" defer></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>js/menu.js"></script>
  <script src="<?php echo $MY_CURRENT_PATH; ?>js/custom.js"></script>
  
  <button id="dark-toggle" title="Toggle dark mode">
    <span id="toggle-icon">🌙</span>
  </button>
  <script>
    const toggle = document.getElementById('dark-toggle');
const icon = document.getElementById('toggle-icon');

const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'dark') {
  document.documentElement.classList.add('dark');
  icon.textContent = '☀️';
}

toggle.addEventListener('click', () => {
  const isDark = document.documentElement.classList.toggle('dark');
  icon.textContent = isDark ? '☀️' : '🌙';
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
});
  </script>
</body>

</html>