<h2><?php echo $title ?></h2>
Total <?php echo strtolower($title) ?> : <?php echo $pager->getTotalRecordCount()?>
</p>

<?php $module = ($title == 'Packages') ? 'package' : 'application' ?>

<?php include_partial('package/pager', array('pager' => $pager, 'module' => $module)); ?>
<ul>
<?php foreach ($pager as $package): ?>
  <li><?php echo link_to($package->getName(), 'package/show?id=' . $package->getid()); ?></li> 
<?php endforeach; ?>
</ul>
<?php include_partial('package/pager', array('pager' => $pager, 'module' => $module)); ?>
