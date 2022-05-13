<?php

use function benignware\sitekick\get_icon;
use function benignware\sitekick\get_widget_class;

/**
* Template Name: Memberships Page
*
* @package WordPress
* @subpackage Sitekick
* @since Sitekick 1.0
*/
get_header(); ?>

<div>
  <?php if ( have_posts() ): ?>
    <?php
      /* Start the Loop */
      while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content/content-page' );

        // If comments are open or there is at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
          comments_template();
        }
      endwhile; // End of the loop.
    ?>
  <?php else: ?>
    <h1><?= __('Sign up'); ?></h1>
  <?php endif; ?>
</div>

<div class="container my-4">
  <?php
    $membership_plans = wc_memberships_get_membership_plans();

    if (count($membership_plans) > 0): ?>
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
                  $checkout_url = add_query_arg('add-to-cart', $product_id, wc_get_checkout_url());
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
      <?php
        // Setup comparison table
        $membership_table_data = array_reduce($membership_plans, function($result, $membership_plan) {
          $id = $membership_plan->get_id();
          $features_string = get_field('membership_features', $id);
          $features = $features_string ? preg_split("/\r\n|\n|\r/", $features_string) : [];

          foreach ($features as $feature) {
            if (!isset($result[$feature])) {
              $result[$feature] = [];
            }

            if (!isset($result[$feature][$id])) {
              $result[$feature][$id] = true;
            }
          }

          return $result;
        }, []);
      ?>
      <h2 class="text-center mb-4">Compare plans</h2>
      <table class="table my-4">
        <thead>
          <th></th>
          <?php foreach ($membership_plans as $membership_plan): ?>
            <th class="text-center"><?= $membership_plan->name; ?></th>
          <?php endforeach; ?>
        </thead>
        <tbody>
          <?php foreach ($membership_table_data as $feature => $feature_plans): ?>
            <tr>
              <th><?= $feature; ?>
              <?php foreach ($membership_plans as $membership_plan): ?>
                <td class="text-center"><?= isset($feature_plans[$membership_plan->get_id()])
                  ? get_icon('check', [ 'class' => 'text-success' ])
                  : get_icon('xmark', [ 'class' => 'text-danger' ]);
                ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
</div>
<?php get_footer();
