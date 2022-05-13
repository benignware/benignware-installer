<p class="lead"><?php echo $title; ?></p>
<div class="row g-2" id="<?= $id ?>" data-bs-toggle="modal" data-bs-target="#<?= $id ?>-modal">
  <?php while( have_posts()) : the_post() ?>
    <div class="col-md-<?= intval(12 / $columns) ?>">
      <figure class="figure m-0 h-100">
        <img
          src="<?= wp_get_attachment_image_src($post->ID, 'medium')[0] ?>"
          class="figure-img img-fluid rounded m-0 h-100"
          data-bs-target="#<?= $id ?>-carousel" data-bs-slide-to="<?= $wp_query->current_post; ?>"
        />
      </figure>
    </div>
  <?php endwhile; ?>
</div>

<div class="modal fade" id="<?= $id ?>-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title"><?= $title ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
      <div id="<?= $id ?>-carousel" class="carousel slide h-100" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <?php while( have_posts()) : the_post() ?>
            <button data-bs-target="#<?= $id ?>-carousel" data-bs-slide-to="<?= $wp_query->current_post; ?>" class="<?= $wp_query->current_post === 0 ? 'active' : '' ?>"></button>
          <?php endwhile; ?>
        </div>
        <div class="carousel-inner h-100">
          <?php while( have_posts()) : the_post() ?>
            <div class="carousel-item h-100<?= $wp_query->current_post === 0 ? ' active' : '' ?>">
              <img
                src="<?= wp_get_attachment_image_src($post->ID, 'full')[0] ?>"
                class="img-fluid m-0 w-100 h-100"
                style="object-fit: contain; object-position: center"
              />
              <?php if ($caption = wp_get_attachment_caption()): ?>
                <div class="carousel-caption d-none d-md-block">
                  <?= $caption ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#<?= $id ?>-carousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?= $id ?>-carousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
