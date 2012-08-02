<h1>Current Update candidates</h1>
<?php foreach ($updates_by_version as $version => $updates_by_type): ?>
<h2>Mageia <?php echo $version ?></h2>
<table class='comparisontable'>
  <thead>
    <th>Update type</th>
    <th>Bug number</th>
    <th>Summary</th>
    <?php foreach ($archs as $arch): ?>
    <th>Testing <?php echo $arch ?></th>
    <?php endforeach; ?>
    <th>Procedure available?</th>
    <th>Mageia Versions</th>
    <th>RPM</th>
    <th>Last action</th>
  </thead>
  <?php $count = 0; ?>
  <?php foreach (array('security', 'bugfix', 'enhancement') as $type) : ?>
    <?php if (isset($updates_by_type[$type])): ?>
      <?php foreach ($updates_by_type[$type] as $id): ?>
      <?php $count++; ?> 
      <tbody>
        <td><?php echo $type ?></td>
        <td><?php echo link_to($id, 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
        <td><?php echo link_to($updates[$id]['summary'], 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
        <?php foreach ($archs as $arch): ?>
        <td><?php 
        if (isset($updates[$id]['testing_status'][$version][$arch]) and $updates[$id]['testing_status'][$version][$arch])
        {
          echo "OK";
          if ($updates[$id]['testing_status'][$version][$arch] == 2)
          {
            echo "?";
          }
        }
        else
        {
          echo "&nbsp;";
        }
        ?></td>
        <?php endforeach; ?>
        <td><?php echo $updates[$id]['has_procedure'] ? "yes" : "&nbsp;" ?></td>
        <td><?php echo implode(', ', $updates[$id]['versions']) ?></td>
        <td><?php echo $updates[$id]['RPM'] ?></td>
        <td><?php echo substr($updates[$id]['changed'], 0, 10) ?></td>
      </tbody>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endforeach; ?>
</table>
Number of update candidates: <?php echo $count; ?><br/>
<br/>
<?php endforeach; ?>
