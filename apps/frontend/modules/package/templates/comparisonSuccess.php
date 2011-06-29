<h1>Version comparison with development version</h1>
<p>This page shows packages which have a newer version available in the development release (<?php echo $dev_release; ?>) than in the stable release. Of course this doesn't mean that there *must* be an update, but it can help to spot needs. Like the other lists, it is filtered using the filters available at the top of the page.</p>
<p>Legend : <span class="newpackage bordered">absent from the stable release</span>, <span class="testing bordered">candidate being tested, same version as the dev release</span>, <span class="bordered">other cases with a newer version in the developement release</span>.</p>
<p>TODO : add links to RPMs, show only columns that have values, print error message if someone selects a development distribution in this page</p>
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
      <th>Update candidate</th>
      <th>Feature update</th>
      <th>Feature update candidate</th>
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
      <td><?php echo $row['update_testing_version'] ?></td>
      <td><strong><?php echo $row['backport_version'] ?></strong></td>
      <td><?php echo $row['backport_testing_version'] ?></td>
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
