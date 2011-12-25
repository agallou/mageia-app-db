<h1>Packages/Applications</h1>
<?php if ($rpm_group): ?>
<h2><?php echo $rpm_group->getName(); ?></h2>
<?php endif; ?>

<?php include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'package', 
  'action'      => 'list',
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
  'showtotal'   => true,
)); ?>

<div>
<ul id="results" class="packlist">
<?php foreach ($pager as $package): ?>
  <li><?php echo link_to(
                   $package->getName(),  
                   $madburl->urlFor(
                     'package/show', 
                     $madbcontext, 
                     array('extra_parameters' => array('name' => $package->getName()))
                   )
                 );
  ?> : <?php echo htmlspecialchars($package->getSummary()); ?></li> 
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



