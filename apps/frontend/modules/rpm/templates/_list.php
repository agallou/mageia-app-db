<?php if ($showpager): ?>
  <?php include_partial('default/pager', array(
    'pager'       => $pager, 
    'module'      => 'rpm', 
    'action'      => 'list', 
    'madbcontext' => $madbcontext, 
    'madburl'     => $madburl,
    'showtotal'   => true,
  )) ?>
<?php endif; ?>
<table class="packlist">
  <thead>
    <?php if ($display_header): ?>
    <tr>
      <th>Name</th>
      <th>Summary</th>
      <th>Version</th>
      <?php if (!isset($short)): ?>
      <th>Build date</th>
      <th>Distribution<br/>release</th>
      <?php endif; ?>
    </tr>
    <?php endif; ?>
  </thead>
  <tbody>
  <?php $dates = array(); ?>
  <?php foreach ($pager as $rpm): ?>
    <?php $buildDate         = $rpm->getBuildtime('Y-m-d'); ?>
    <?php $dates[$buildDate] = $buildDate; ?>
    <tr class="rpm-<?php echo count($dates) % 2 ? 'odd' : 'even'?>">
      <td><?php echo link_to(
                  $rpm->getPackage()->getName(), 
                  $madburl->urlFor(
                    'package/show', 
                    $madbcontext, 
                    array('extra_parameters' => array('name' => $rpm->getPackage()->getName()))
                  )
                ); ?></td>
      <td><?php echo htmlspecialchars($rpm->getSummary()) ?></td>
      <td><?php echo link_to(
                  $rpm->getVersion(), 
                  $madburl->urlForRpm($rpm, $madbcontext)
                ); ?>
      </td>
      <?php if (!isset($short)): ?>
      <td><?php echo $buildDate ?></td>
      <td><?php echo $rpm->getDistrelease()->getDisplayedName() ?></td>
      <?php endif; ?>
    </tr> 
  <?php endforeach; ?>
</tbody>
</table>
<?php if ($showpager): ?>
  <?php include_partial('default/pager', array(
    'pager'       => $pager, 
    'module'      => 'rpm', 
    'action'      => 'list', 
    'madbcontext' => $madbcontext, 
    'madburl'     => $madburl,
  )) ?>
<?php endif; ?>
