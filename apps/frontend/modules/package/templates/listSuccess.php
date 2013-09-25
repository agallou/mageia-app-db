<?php 
if ($rpm_group) {
  slot('title', $rpm_group->getName());
} else {
  slot('title', 'Packages/Applications');
}
?>
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

<?php if ($application): ?>
  <p>This list shows only applications. 
  <?php echo link_to(
               "Show all packages.",
               $madburl->urlFor(
                 'package/list',
                 $other_madbcontext,
                 array(
                   'keep_all_parameters' => true
                 )
               )
             );
  ?>
  </p>
<?php else: ?>
  <p>This list shows all types of packages. 
  <?php echo link_to(
               "Show only applications.",
               $madburl->urlFor(
                 'package/list',
                 $other_madbcontext,
                 array(
                   'keep_all_parameters' => true
                 )
               )
             );
  ?>
  </p>
<?php endif; ?>
