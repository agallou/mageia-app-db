<h1>Comparison between 2 releases</h1>
<p>This page compares the selected stable release with <?php echo $targetRelease->getDisplayedName(); ?>.
Like the other lists, it is filtered using the filters available at the top of the page.</p>
<p>Legend : 
<span class="newpackage bordered">added in <?php echo $target_release; ?></span>, 
<span class="testing bordered">being tested: same version as in <?php echo $target_release; ?></span>, 
<span class="bordered">newer version in <?php echo $target_release; ?></span>.
<span class="newer_avail bordered">newer available outside <?php echo $target_release; ?></span>.
<span class="backported bordered">backported</span>.
<span class="older bordered">older version in <?php echo $target_release; ?>!</span>.
</p>
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
      <th>Base version</th>
      <?php if ($has_updates_testing) : ?><th>Update<br/>candidate</th><?php endif; ?>
      <?php if ($has_backports) : ?><th>Feature update</th><?php endif; ?>
      <?php if ($has_backports_testing) : ?><th>Feature update<br/> candidate</th><?php endif; ?>
      <th>Dev (<?php echo $target_release; ?>)</th>
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
elseif (RpmPeer::evrCompare($row['update_testing_version'], $row['dev_version'])==0 or RpmPeer::evrCompare($row['backport_testing_version'], $row['dev_version'])==0)
{
  echo ' class="testing"';
}
elseif ( RpmPeer::evrCompare($row['update_version'], $row['dev_version'])>0 
      or RpmPeer::evrCompare($row['update_testing_version'], $row['dev_version'])>0
      or RpmPeer::evrCompare($row['backport_version'], $row['dev_version'])>0
      or RpmPeer::evrCompare($row['backport_testing_version'], $row['dev_version'])>0)
{
  echo ' class="older"';
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
      <td><?php  echo link_to(
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


<?php /*include_partial('default/pager', array(
  'pager'       => $pager, 
  'module'      => 'package',
  'action'      => 'comparison',
  'madbcontext' => $madbcontext, 
  'madburl'     => $madburl,
)) */?>
