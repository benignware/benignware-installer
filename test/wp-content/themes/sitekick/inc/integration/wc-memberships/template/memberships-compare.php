<?php if ($title): ?>
  <h2 class="text-center mb-4"><?= $title ?></h2>
<?php endif; ?>
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
