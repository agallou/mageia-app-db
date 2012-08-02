<h1>Current Update candidates</h1>
<?php foreach ($updates_by_version as $version => $updates_by_type): ?>
<h2>Mageia <?php echo $version ?></h2>
<table style="text-align:center;" class='comparisontable'>
  <thead>
    <th>Update <br/>type</th>
    <th>Bug number</th>
    <th style="text-align:left;">Summary (hover for RPM name)</th>
    <?php foreach ($archs as $arch): ?>
    <th>Testing <?php echo $arch ?></th>
    <?php endforeach; ?>
    <th>Procedure <br/>available?</th>
    <th>Packager feedback <br/>requested?</th>
    <th>Mageia <br/>Versions</th>
    <th>No action <br/>since (days)</th>
  </thead>
  <?php $count = array(); ?>
  <?php $count['total'] = 0; ?>
  <?php foreach (array('security', 'bugfix', 'enhancement') as $type) : ?>
    <?php $count[$type] = 0; ?>
    <?php if (isset($updates_by_type[$type])): ?>
      <?php foreach ($updates_by_type[$type] as $id): ?>
      <?php $count[$type]++; ?> 
      <?php $count['total']++; ?> 
      <tbody>
        <td><?php echo $type ?></td>
        <td style="text-align:left;"><?php echo link_to($id, 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
        <td title="<?php echo $updates[$id]['RPM']?>"><?php echo link_to($updates[$id]['summary'], 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
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
        <td><?php echo $updates[$id]['feedback'] ? "yes" : "&nbsp;" ?></td>
        <td><?php 
        foreach ($updates[$id]['versions'] as $version)
        {
          $testing_complete = true;
          foreach ($archs as $arch)
          {
            if (!isset($updates[$id]['testing_status'][$version][$arch]) or $updates[$id]['testing_status'][$version][$arch]!=1)
            {
              $testing_complete = false;
            }
          }
          if ($testing_complete)
          {
            echo '<span style="text-decoration: line-through">';
          }
          echo "$version";
          if ($testing_complete)
          {
            echo '</span>';
          }
          echo " ";
        }
        ?></td> 
        <td><?php 
        $date = new DateTime(substr($updates[$id]['changed'], 0, 10));
        echo $date->diff($now)->format("%a");
        ?></td>
      </tbody>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endforeach; ?>
</table>
Number of update candidates: <?php echo $count['total']; ?> 
(security: <?php echo $count['security'] ?>,
bugfix: <?php echo $count['bugfix'] ?>,
enhancement: <?php echo $count['enhancement'] ?>)<br/>
<br/>
<?php endforeach; ?>
