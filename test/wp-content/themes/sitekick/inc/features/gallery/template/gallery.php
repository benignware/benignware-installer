<?php

?>
<div class="row g-2">
  <?php while( have_posts()) : the_post() ?>
    <div class="col-md-2">
      <figure class="figure m-0">
        <img
          src="<?= wp_get_attachment_image_src($post->ID, 'thumbnail')[0] ?>"
          class="figure-img img-fluid rounded m-0"
        />
        <?php if ($caption = wp_get_attachment_caption()): ?>
          <figcaption class="figure-caption text-end mt-2"><?= $caption ?></figcaption>
        <?php endif; ?>
      </figure>
    </div>
  <?php endwhile; ?>
</div>