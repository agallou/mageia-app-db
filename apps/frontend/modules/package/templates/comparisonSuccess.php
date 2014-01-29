<?php slot('title', 'Comparison between releases '.$distrelease->getDisplayedName().' and '.$targetRelease->getDisplayedName()) ?>

<?php slot('name') ?>
  Comparison between releases <?php echo $distrelease->getDisplayedName(); ?> and <?php echo $targetRelease->getDisplayedName(); ?>
<?php end_slot('name') ?>

<p>This page compares the packages present in <?php echo $distrelease->getDisplayedName(); ?> with those in <?php echo $targetRelease->getDisplayedName(); ?>.
 It can be customized by using the filters available at the top of the page.</p>
<br/>
<p><strong>After clicking a link, you might need to change the filter values.
For example, change <?php echo $distrelease->getDisplayedName(); ?> to <?php echo $targetRelease->getDisplayedName(); ?>, or change the arch value.</strong></p>
<br/>
<p>Legend:
<span class="newpackage bordered">added in <?php echo $target_release; ?></span> 
<?php if ($has_updates_testing || $has_backports_testing) : ?><span class="testing bordered">being tested: same version as in <?php echo $target_release; ?></span> <?php endif; ?>
<span class="bordered">newer version in <?php echo $target_release; ?></span> 
<?php if ($has_available_versions) : ?><span class="newer_avail bordered">newer available outside <?php echo $target_release; ?></span> <?php endif; ?>
<?php if ($has_backports) : ?><span class="backported bordered">backported</span> <?php endif; ?>
<span class="older bordered">older version in <?php echo $target_release; ?>!</span> 
</p>
<table class="comparisontable">
  <thead>
    <tr>
      <th>Name</th>
      <th>Base version</th>
      <?php if ($has_updates_testing) : ?><th>Update<br/>candidate</th><?php endif; ?>
      <?php if ($has_backports) : ?><th>Feature update</th><?php endif; ?>
      <?php if ($has_backports_testing) : ?><th>Feature update<br/> candidate</th><?php endif; ?>
      <th><?php echo $targetRelease->getDisplayedName(); ?></th>
      <?php if ($has_available_versions) : ?><th>Newer available<br/>version</th><?php endif; ?>
    </tr>
  </thead>
  <tbody>
  <?php $madbBaseUrl = $madburl->urlFor(
                         'package/show',
                         $madbcontext,
                         array('extra_parameters' => array('name' => '___REPLACE___ME___'))
                       );
  ?>
  <?php foreach ($rows as $row): ?>
    <tr<?php
if (!$row['update_version'] and !$row['update_testing_version'] and !$row['backport_version'] and !$row['backport_testing_version'])
{
  echo ' class="newpackage"';
}
elseif ( RpmPeer::evrCompare($row['update_version'], $row['dev_version'])>0
      or RpmPeer::evrCompare($row['update_testing_version'], $row['dev_version'])>0
      or RpmPeer::evrCompare($row['backport_version'], $row['dev_version'])>0
      or RpmPeer::evrCompare($row['backport_testing_version'], $row['dev_version'])>0)
{
  echo ' class="older"';
}
elseif (RpmPeer::evrCompare($row['update_testing_version'], $row['dev_version'])==0 or RpmPeer::evrCompare($row['backport_testing_version'], $row['dev_version'])==0)
{
  echo ' class="testing"';
}
elseif ( !(RpmPeer::evrCompare($row['update_version'], $row['dev_version'])<0
      and RpmPeer::evrCompare($row['update_testing_version'], $row['dev_version'])<0
      and RpmPeer::evrCompare($row['backport_version'], $row['dev_version'])<0
      and RpmPeer::evrCompare($row['backport_testing_version'], $row['dev_version'])<0)
      and $row['available'] )
{
  echo ' class="newer_avail"';
}
elseif (RpmPeer::evrCompare($row['backport_version'], $row['dev_version'])==0)
{
  echo ' class="backported"';
}
else
{
  // nothing to do, remains white
}
?>>
      <td class='summary'><?php  echo link_to(
                   $row['name'],
                   str_replace("___REPLACE___ME___", $row['name'], $madbBaseUrl)
                 );
  ?>
        <span class="description"><?php echo htmlspecialchars($row['summary']) ?></span></td>
      <td><strong><?php echo $row['update_version'] ?></strong></td>
      <?php if ($has_updates_testing) : ?><td><?php echo $row['update_testing_version'] ?></td><?php endif; ?>
      <?php if ($has_backports) : ?><td><strong><?php echo $row['backport_version'] ?></strong></td><?php endif; ?>
      <?php if ($has_backports_testing) : ?><td><?php echo $row['backport_testing_version'] ?></td><?php endif; ?>
      <td><strong><?php echo $row['dev_version'] ?></strong></td>
      <?php if ($has_available_versions) : ?><td><?php echo $row['available'] ?><?php echo $row['available'] ? "&nbsp;(".$row['source'].")" : "" ?></td><?php endif; ?>
    </tr>
  <?php endforeach; ?>
</tbody>
</table>
