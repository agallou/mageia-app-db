<h1>Packages/Applications</h1>

<?php include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'package', 
  'action'      => 'list',
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
)); ?>

<div>
Total results : <span id="count"></span>
<ul id="results" class="packlist">
<?php foreach ($pager as $package): ?>
  <li><?php echo link_to($package->getName(),  $madburl->urlFor('package/show', $madbcontext, array('extra_parameters' => array('id' => $package->getid())))); ?></li> 
<?php endforeach; ?>
</ul>
</div>

<?php include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'package',
  'action'      => 'list',
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
)) ?>



