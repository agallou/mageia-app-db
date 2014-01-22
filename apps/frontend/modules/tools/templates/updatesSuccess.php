<?php slot('title', 'Current Update candidates') ?>
<?php slot('name') ?>
Current Update candidates
<?php end_slot('name') ?>
<p>
A <span class="feedback">gray background</span> means "QA team waiting for packager feedback".<br />
A star* next to the update type means that an advisory has been uploaded to SVN already.
</p>
<br />
<?php foreach ($updates_by_version as $version => $updates_by_type): ?>
<h2>Mageia <?php echo $version ?></h2>
<table class='buglist'>
  <thead>
    <th>Update <br/>type</th>
    <th>Bug number</th>
    <th style="text-align:left;">Summary (hover for RPM name)</th>
    <?php foreach ($archs as $arch): ?>
    <th>Test <?php echo $arch ?></th>
    <?php endforeach; ?>
    <th>Proced. <br/>avail.?</th>
    <th>Mageia <br/>Version</th>
    <th>No action <br/>for (days)</th>
    <th>Lists</th>
    <th>Quick search</th>
  </thead>
  <tbody>
  <?php $count = array(); ?>
  <?php $count['total'] = 0; ?>
  <?php foreach (array('security', 'bugfix', 'enhancement') as $type) : ?>
    <?php $count[$type] = 0; ?>
    <?php if (isset($updates_by_type[$type])): ?>
      <?php foreach ($updates_by_type[$type] as $id): ?>
      <?php
      $tr_class = '';
      switch ($updates[$id]['severity'])
      {
        case 'enhancement':
          $tr_class = 'enhancement';
          break;
        case 'low':
          $tr_class = 'low';
          break;
        case 'major':
          $tr_class = ($type == 'security') ? 'major' : '';
          break;
        case 'critical':
          $tr_class = ($type == 'security') ? 'critical' : 'major';
          break;
        default:
          break;
      }
      if ($updates[$id]['feedback'])
      {
        $tr_class .= " feedback";
      }
      ?>
      <tr class="<?php echo $tr_class ?>">
        <?php $count[$type]++; ?> 
        <?php $count['total']++; ?> 
        <td><?php echo $type . ($updates[$id]['has_advisory'] ? '*' : '') ?></td>
        <td><?php echo link_to($id, 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
        <td style="text-align:left;" title="<?php echo $updates[$id]['RPM']?>"><?php 
        echo link_to(
                substr($updates[$id]['summary'], 0, 100) . (strlen($updates[$id]['summary'])>100 ? "[...]" : ""), 
                'https://bugs.mageia.org/show_bug.cgi?id=' . $id) 
        ?></td>
        <?php foreach ($archs as $arch): ?>
        <td><?php 
        if (isset($updates[$id]['testing_status'][$version][$arch]) && $updates[$id]['testing_status'][$version][$arch])
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
        <td><?php 
        foreach ($updates[$id]['versions'] as $the_version)
        {
          $testing_complete = true;
          foreach ($archs as $arch)
          {
            if (!isset($updates[$id]['testing_status'][$the_version][$arch]) or $updates[$id]['testing_status'][$the_version][$arch]!=1)
            {
              $testing_complete = false;
            }
          }
          if ($testing_complete)
          {
            echo '<span style="text-decoration: line-through">';
          }
          echo "$the_version";
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
        <td><?php echo link_to("RPMs", $madburl->urlFor("tools/listRpmsForQaBug", $madbcontext, array('extra_parameters' => array('bugnum' => $id, 'application'=>0)))); ?></td>
        <td style="text-align:left;"><?php 
        if ($source_package = $updates[$id]['source_package'])
        {
          if (is_object($source_package))
          {
            $name = $source_package->getName();
            $name2 = $name;
          }
          else
          {
            $name = $source_package;
            $name2 = ".$name";
          }
          echo link_to("Bugzilla", str_replace('{{SEARCH}}', $name, $search_url));
          echo ", ";
          echo link_to("Wiki", str_replace('{{SEARCH}}', $name, $procedure_search_url));
          echo " ($name2)";
        }
        ?></td>
      </tr>  
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endforeach; ?>
  </tbody>
</table>
Number of update candidates: <?php echo $count['total']; ?> 
(security: <?php echo $count['security'] ?>,
bugfix: <?php echo $count['bugfix'] ?>,
enhancement: <?php echo $count['enhancement'] ?>)<br/>
<br/>
<?php endforeach; ?>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
  $('#filtering-border').remove();
<?php end_javascript_tag() ?>