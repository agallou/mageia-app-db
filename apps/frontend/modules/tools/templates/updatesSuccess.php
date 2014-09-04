<?php slot('title', 'Current Update candidates') ?>
<?php slot('name') ?>
Current Update candidates
<?php end_slot('name') ?>
<p>
See <a href="https://wiki.mageia.org/en/QA_process_for_validating_updates">QA process for validating updates</a> for instructions (and join <a href="irc://irc.freenode.net/#mageia-qa">our QA IRC channel</a>).</p>
<p>A <span class="feedback">gray background</span> means "QA team waiting for packager feedback". A star* next to the update type means that an advisory has been uploaded to SVN already.
</p>
<br />
<?php foreach (array('pending', 'validated') as $status): ?>
  <?php if ($status == 'validated'): ?>
  <br/><br/><br/>Below is a list of validated updates waiting to be pushed to the updates media. Those without a star* need an advisory to be uploaded, first.<br/><br/>
  <?php endif ?>
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
    <?php foreach (array('security', 'bugfix', 'enhancement', 'backport') as $type) : ?>
      <?php $count[$type] = 0; ?>
      <?php if (isset($updates_by_type[$type])): ?>
        <?php foreach ($updates_by_type[$type] as $id): ?>
        <?php
        if (false !== strpos($updates[$id]['keywords'], 'validated_update') && $status == 'pending')
        {
          continue;
        }
        if (false === strpos($updates[$id]['keywords'], 'validated_update') && $status == 'validated')
        {
          continue;
        }
        
        
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
          <td style="white-space:nowrap"><?php
          foreach (array_keys($updates_by_version) as $the_version)
          {
            if (in_array($the_version, $updates[$id]['versions']))
            {
              $testing_complete = true;
              $testing_one_ok = false;
              foreach ($archs as $arch)
              {
                if (!isset($updates[$id]['testing_status'][$the_version][$arch]) or $updates[$id]['testing_status'][$the_version][$arch]!=1)
                {
                  $testing_complete = false;
                }
                if (isset($updates[$id]['testing_status'][$the_version][$arch]) and $updates[$id]['testing_status'][$the_version][$arch]==1)
                {
                  $testing_one_ok = true;
                }
              }
              $testing_class = "testing_not_ok";
              $title = "Testing not complete for any arch";
              $symbol = "⚈";
              if ($testing_complete)
              {
                $testing_class = "testing_complete";
                $title = "Testing complete for both archs";
                $symbol = "⚉";
              }
              elseif ($testing_one_ok)
              {
                $testing_class = "testing_one_ok";
                $title = "Testing half-complete (only one arch)";
              }
            }
            else
            {
              $testing_class = "testing_hidden";
            }
            echo "<span class=\"$testing_class\" title= \"$title\">$the_version";
            echo "<span>$symbol</span></span> ";
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
Number of update candidates: <?php echo $count['total'] - $count['backport']; ?> 
(security: <?php echo $count['security'] ?>,
bugfix: <?php echo $count['bugfix'] ?>,
enhancement: <?php echo $count['enhancement'] ?>)<br/>
Number of backports : <?php echo $count['backport'] ?><br/>
  <br/>
  <?php endforeach; ?>
<?php endforeach; ?>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
  $('#filtering-border').remove();
<?php end_javascript_tag() ?>