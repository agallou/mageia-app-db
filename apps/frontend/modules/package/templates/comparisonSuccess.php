<h1>Version comparison with development version</h1>
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
      <th><?php echo $dev_release; ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $row): ?>
    <tr <?php echo $row['update_version'] ? '' : 'class="newpackage"' ?>>
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
