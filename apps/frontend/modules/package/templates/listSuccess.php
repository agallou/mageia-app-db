<form>
<?php echo $form ?>
<input type="submit" value="Filter" />
</form>

<div id="filtersInfo"></div>

<h1>Packages/Applications</h1>

<?php include_partial('package/pager', array('pager' => $pager, 'module' => 'package', 'madbcontext' => $madbcontext)); ?>

<div>
Total results : <span id="count"></span>
<ul id="results" class="packlist">
<?php foreach ($pager as $package): ?>
  <li><?php echo link_to($package->getName(), 'package/show?id=' . $package->getid()); ?></li> 
<?php endforeach; ?>
</ul>
</div>

<?php include_partial('package/pager', array('pager' => $pager, 'module' => 'package', 'madbcontext' => $madbcontext)); ?>



