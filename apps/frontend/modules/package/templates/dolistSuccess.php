<?php $json = array() ?>
<?php $results = array() ?>
<?php foreach ($pager as $package): ?>
  <?php $results[] = array('link' => url_for('package/show?id=' . $package->getId()), 'name' => $package->getName()); ?>
<?php endforeach; ?>
<?php $json['results'] = $results ?>
<?php $json['total']   = $pager->getTotalRecordCount()?>
<?php echo json_encode($json); ?>
