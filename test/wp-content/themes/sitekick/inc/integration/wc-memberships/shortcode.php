<?php

if (!function_exists('wc_memberships_get_membership_plans')) {
  return;
}

$render_template = function($template, $data) {
  foreach($data as $key => $value) {
    $$key = $data[$key];
  }

  ob_start();
  include $template;
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
};

add_shortcode('sitekick_memberships_join', function($params, $content) {
	$params = shortcode_atts(array(
		'title' => null,
	), $params, 'sitekick_memberships_join');
  $membership_plans = wc_memberships_get_membership_plans();

  if (count($membership_plans) === 0) {
    return;
  }

  $template = __DIR__ . '/template/memberships-join.php';

  $output = $render_template($template, [
    'title' => $params['title'],
    'membership_plans' => $membership_plans
  ]);

  return $output;
});

add_shortcode('sitekick_memberships_compare', function($params, $content) {
	$params = shortcode_atts(array(
		'title' => __('Compare plans', 'sitekick'),
	), $params, 'sitekick_memberships_compare');
  $membership_plans = wc_memberships_get_membership_plans();

  if (count($membership_plans) === 0) {
    return '';
  }

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

  $template = __DIR__ . '/template/memberships-compare.php';

  $output = $render_template($template, [
    'title' => $params['title'],
    'membership_plans' => $membership_plans,
    'membership_table_data' => $membership_table_data
  ]);

  return $output;
});
