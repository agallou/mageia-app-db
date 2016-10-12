<?php slot('title', 'Security issues') ?>
<?php slot('name') ?>
Security issues
<?php end_slot('name') ?>
<br />
  <?php foreach ($updates_by_version as $version => $ids): ?>
  <h2>Mageia <?php echo $version ?></h2>
  <table class='buglist'>
    <thead>
      <th style="width:7%">Bug number</th>
      <th style="text-align:left;">Summary (hover for RPM name)</th>
      <th style="width:10%">Versions affected</th>
      <th style="width:10%">Date created</th>
      <th style="width:10%">Last action (days)</th>
    </thead>
    <tbody>
    <?php $count = array(); ?>
    <?php $count['total'] = 0; ?>
    <?php foreach ($ids as $id): ?>
      <?php
      $tr_class = '';
      switch ($updates[$id]['severity'])
      {
        case 'enhancement':
        case 'backport':
          $tr_class = 'enhancement';
          break;
        case 'low':
          $tr_class = 'low';
          break;
        case 'major':
          $tr_class = 'major';
          break;
        case 'critical':
          $tr_class = 'critical';
          break;
        default:
          break;
      }
      ?>
      <tr class="<?php echo $tr_class ?>">
        <?php $count['total']++; ?>
        <td><?php echo link_to($id, 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
        <td style="text-align:left;" title="<?php echo $updates[$id]['RPM']?>"><?php
        echo link_to(
                substr($updates[$id]['summary'], 0, 100) . (strlen($updates[$id]['summary'])>100 ? "[...]" : ""),
                'https://bugs.mageia.org/show_bug.cgi?id=' . $id)
        ?></td>
        <td><?php echo join(", ", $updates[$id]['versions']) ?></td>
        <td><?php echo $updates[$id]['created'] ?></td>
        <td><?php
        $date = new DateTime(substr($updates[$id]['changed'], 0, 10));
        echo $date->diff($now)->format("%a");
        ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
Number: <?php echo $count['total'] ?>
  <br/><br/>
  <?php endforeach; ?>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
  $('#filtering-border').remove();
<?php end_javascript_tag() ?>