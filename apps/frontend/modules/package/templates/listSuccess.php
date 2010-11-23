<h2>Packages/Applications</h2>

<form>
<?php echo $form ?>
<input type="submit" value="Filter" />
</form>

Total : <?php echo $pager->getTotalRecordCount()?>
</p>

<?php include_partial('package/pager', array('pager' => $pager, 'module' => 'package', 'madbcontext' => $madbcontext)); ?>
<ul>
<?php foreach ($pager as $package): ?>
  <li><?php echo link_to($package->getName(), 'package/show?id=' . $package->getid()); ?></li> 
<?php endforeach; ?>
</ul>
<?php include_partial('package/pager', array('pager' => $pager, 'module' => 'package', 'madbcontext' => $madbcontext)); ?>
