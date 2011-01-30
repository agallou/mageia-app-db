<h1><?php echo $title ?></h1>

<?php include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'rpm', 
  'action'      => 'list', 
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
  'showtotal'   => true,
)) ?>

<div>
<table class='packlist'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Summary</th>
      <th>Version</th>
      <th>Build date</th>
      <th>Distribution<br/>release</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager as $rpm): ?>
    <tr>
      <td><?php echo link_to(
                  $rpm->getPackage()->getName(), 
                  $madburl->urlFor(
                    'package/show', 
                    $madbcontext, 
                    array('extra_parameters' => array('id' => $rpm->getPackage()->getId()))
                  )
                ); ?></td>
      <td><?php echo $rpm->getSummary() ?></td>
      <td><?php echo link_to(
                  $rpm->getVersion(), 
                  $madburl->urlFor(
                    'rpm/show', 
                    $madbcontext, 
                    array('extra_parameters' => array('id' => $rpm->getid()))
                  )
                ); ?></td>
      <td><?php echo $rpm->getBuildtime('Y-m-d') ?></td>
      <td><?php echo $rpm->getDistrelease()->getName() ?></td>
    </tr> 
  <?php endforeach; ?>
</tbody>
</table>
</div>

<?php include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'rpm', 
  'action'      => 'list', 
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
)) ?>
