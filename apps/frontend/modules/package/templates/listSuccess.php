<h1>Packages/Applications</h1>
<?php if (!is_null($t_group)): ?>
<h2><?php echo $t_group ?></h2>
<?php endif; ?>

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
  <li><?php echo link_to(
                   $package->getName(),  
                   $madburl->urlFor(
                     'package/show', 
                     $madbcontext, 
                     array('extra_parameters' => array('id' => $package->getid()))
                   )
                 );
  ?> : <?php echo $package->getSummary(); ?></li> 
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



