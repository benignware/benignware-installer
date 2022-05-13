<?php
?>
<header class="bg-dark text-primary">
  <div class="container py-4">
    <div class="row g-1 align-items-start">
      <div class="site-logo col-md-2"><?php the_custom_logo(); ?></div>
      <div class="col-md-8">
        <h2 class="display-6 text-center">The Nr. 1 for Rock'n'Roll & Girls!</h2>
      </div>
      <div class="col-md-2 my-auto fs-5 d-flex justify-content-end">
        <a class="link-light m-1" href="https://twitter.com">
          <i class="fa-brands fa-twitter"> </i>
        </a>
        <a class="link-light m-1" href="https://instagram.com">
          <i class="fa-brands fa-instagram"> </i>
        </a>
        <a class="link-light m-1" href="https://facebook.com">
          <i class="fa-brands fa-facebook"> </i>
        </a>
        <a class="link-light m-1" href="https://tiktok.com">
          <i class="fa-brands fa-tiktok"> </i>
        </a>
        <?php
          /*
          wp_nav_menu(
            array(
              'theme_location'  => 'quickstart',
              'menu_class'      => 'nav navbar-nav me-auto mb-2 mb-lg-0',
              'container'				=> 'nav',
              'container_class' => 'navbar navbar-dark navbar-expand',
              'items_wrap'      => '<ul id="quickstart-menu-list" class="%2$s">%3$s</ul>',
              'fallback_cb'     => false,
            )
          );
          */
          
        ?>
      </div>
    </div>
  </div>
</header>