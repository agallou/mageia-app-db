<h1>Version comparison with development version</h1>
<p>This page shows packages which have a newer version available in the development branch (<?php echo $dev_release; ?>) than in the stable release. Of course this doesn't mean that there *must* be an update, but it can help to spot needs. Like the other lists, it is filtered using the filters available at the top of the page.</p>
<p>Legend : <span class="newpackage bordered">absent from stable release</span>, <span class="testing bordered">being tested: same version as in <?php echo $dev_release; ?></span>, <span class="bordered">other cases: newer version in <?php echo $dev_release; ?></span>.</p>
<p>TODO : add links to RPM views</p>
<?php /*include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'package', 
  'action'      => 'comparison',
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
  'showtotal'   => true,
)); */?>

<table class="comparisontable">
  <thead>
    <tr>
      <th>Name</th>
      <th>Summary</th>
      <th>Base version</th>
      <?php if ($has_updates_testing) : ?><th>Update candidate</th><?php endif; ?>
      <?php if ($has_backports) : ?><th>Feature update</th><?php endif; ?>
      <?php if ($has_backports_testing) : ?><th>Feature update candidate</th><?php endif; ?>
      <th>Dev (<?php echo $dev_release; ?>)</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $row): ?>
    <tr<?php 
if (!$row['update_version'] and !$row['update_testing_version'] and !$row['backport_version'] and !$row['backport_testing_version']) 
{
  echo ' class="newpackage"';
}
elseif (RpmPeer::evrCompare($row['update_testing_version'], $row['dev_version'])>=0 or RpmPeer::evrCompare($row['backport_testing_version'], $row['dev_version'])>=0)
{
  echo ' class="testing"';
}
        ?>>
      <td><?php echo link_to(
                   $row['NAME'],
                   $madburl->urlFor(
                     'package/show', 
                     $madbcontext, 
                     array('extra_parameters' => array('id' => $row['ID']))
                   )
                 );
  ?></td>
      <td><?php echo $row['SUMMARY'] ?></td>
      <td><strong><?php echo $row['update_version'] ?></strong></td>
      <?php if ($has_updates_testing) : ?><td><?php echo $row['update_testing_version'] ?></td><?php endif; ?>
      <?php if ($has_backports) : ?><td><strong><?php echo $row['backport_version'] ?></strong></td><?php endif; ?>
      <?php if ($has_backports_testing) : ?><td><?php echo $row['backport_testing_version'] ?></td><?php endif; ?>
      <td><strong><?php echo $row['dev_version'] ?></strong></td>
    </tr> 
  <?php endforeach; ?>
</tbody>
</table>


<?php /*include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'package',
  'action'      => 'comparison',
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
)) */?>
