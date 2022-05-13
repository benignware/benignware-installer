<div class="row g-4 my-4">
  <?php foreach ($membership_plans as $membership_plan): ?>
    <?php
      $id = $membership_plan->get_id();
      $curreny_symbol = get_woocommerce_currency_symbol();
      $meta = get_post_meta($membership_plan->get_id());
      $description = get_field('membership_description', $id);
      $access_method = get_post_meta($id, '_access_method', true);

      switch ($access_method) {
        case 'purchase':
          $access_label = __('Join now');
          $product_ids = $membership_plan->get_product_ids();
          $products = array_map('wc_get_product', $product_ids);
  
          if (count($products) > 0) {
            $product = $products[0];
            $price = $product->price;
            $subscription_period = get_post_meta($product->get_id(), '_subscription_period', true);

            $price_label = $subscription_period
              ? sprintf('%s%s<small class="text-muted">/%s</small>', $price, $curreny_symbol, $subscription_period)
              : $price . $curreny_symbol;
            $product_id = $product->get_id();
            $checkout_url = esc_url(sprintf('%s/checkout/?add-to-cart=%s', get_site_url(), $product_id));
          } else {
            throw 'No product registered for this membership plan';
          }
          break;

        case 'signup':
          $price_label = '0' . $curreny_symbol;
          $access_label = __('Join now');
          $checkout_url = wp_registration_url();
          break;

        default:
          $price_label = __('?');
          $access_label = __('Contact us');
          $checkout_url = 'mailto: ' . get_bloginfo('admin_email');
      }

      // $widget_class = filter(implode(' ', apply_filters('sitekick_widget_classes', ['card', 'text-center'], -1, [])));
    ?>
    <div class="col-md-4">
      <div class="<?= get_widget_class('card text-center') ?>">
        <div class="card-header">
          <?= $membership_plan->name ?>
        </div>
        <div class="card-body">
          <h4 class="card-title h1"><?= $price_label; ?></h4>
          <p class="mt-3 mb-4"><?= $description; ?></p>
          <a class="w-100 btn btn-lg btn-primary" href="<?= $checkout_url ?>">
            <?= $access_label; ?>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>