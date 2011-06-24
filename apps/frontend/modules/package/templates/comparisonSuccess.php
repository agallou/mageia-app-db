<h1>Version comparison with development version</h1>

<?php /*include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'package', 
  'action'      => 'comparison',
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
  'showtotal'   => true,
)); */?>

<table class="packlist">
  <thead>
    <tr>
      <th>Name</th>
      <th>Summary</th>
      <th>Base version</th>
      <th>Update candidate</th>
      <th>Feature update</th>
      <th>Feature update candidate</th>
      <th>Development version</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $row): ?>
    <tr>
      <td><?php echo $row['NAME'] ?></td>
      <td><?php echo $row['SUMMARY'] ?></td>
      <td><?php echo $row['update_version'] ?></td>
      <td><?php echo $row['update_testing_version'] ?></td>
      <td><?php echo $row['backport_version'] ?></td>
      <td><?php echo $row['backport_testing_version'] ?></td>
      <td><?php echo $row['dev_version'] ?></td>
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
