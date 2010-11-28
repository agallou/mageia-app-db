<?php $json = array() ?>
<?php foreach ($pager as $package): ?>
  <?php $json[] = array('link' => url_for('package/show?id=' . $package->getId()), 'name' => $package->getName()); ?>
<?php endforeach; ?>
<?php echo json_encode($json);

