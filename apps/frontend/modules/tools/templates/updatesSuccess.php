<h1>Current Update candidates</h1>
<?php foreach ($updates_by_version as $version => $buglist): ?>
<h2>Mageia <?php echo $version ?></h2>
<table class='comparisontable'>
  <thead>
    <th>Bug number</th>
    <th>Summary</th>
    <?php foreach ($archs as $arch): ?>
    <th>Testing <?php echo $arch ?></th>
    <?php endforeach; ?>
    <th>Procedure available?</th>
    <th>RPM</th>
  </thead>
  <?php foreach ($buglist as $id): ?>
  <tbody>
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
    <td><?php echo $updates[$id]['RPM'] ?></td>
  </tbody>
  <?php endforeach; ?>
</table><br/>
<?php endforeach; ?>
