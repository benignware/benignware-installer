<?php if (has_custom_logo()): ?>
  <a
    class="navbar-brand"
    href="<?php echo esc_url( home_url( '/' ) ); ?>"
    rel="home"
    title="<?php bloginfo( 'name' ); ?>"
  >
    <?php bloginfo( 'name' ); ?>
  </a>
<?php else: ?>
  <span class="navbar-brand">
    <?php the_custom_logo(); ?>
  </span>
<?php endif; ?>