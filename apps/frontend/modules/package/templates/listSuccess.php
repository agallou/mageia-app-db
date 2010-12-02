<h1><?php echo $title ?></h1>

<?php $module = ($title == 'Packages') ? 'package' : 'application' ?>

<?php include_partial('package/pager', array('pager' => $pager, 'module' => $module, 'message' => sprintf('(Total %s : %%s)', strtolower($title)))); ?>


<ul class="packlist">
<?php foreach ($pager as $package): ?>
  <li><?php echo link_to($package->getName(), 'package/show?id=' . $package->getid()); ?></li> 
<?php endforeach; ?>
</ul>
<?php include_partial('package/pager', array('pager' => $pager, 'module' => $module)); ?>
