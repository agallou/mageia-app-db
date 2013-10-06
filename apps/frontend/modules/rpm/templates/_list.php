<?php if ($showpager): ?>
  <?php include_partial('default/pager', array(
    'pager'       => $pager,
    'module'      => 'rpm',
    'action'      => 'list',
    'madbcontext' => $madbcontext,
    'madburl'     => $madburl,
  )) ?>
<?php endif; ?>
<?php
if ($show_bug_links)
{
  $bugtrackerFactory = new madbBugtrackerFactory();
  $bugtracker = $bugtrackerFactory->create();
}
?>

<?php if (count($pager)): ?>
  <table class="packlist">
    <thead>
      <?php if ($display_header): ?>
      <tr>
        <th>Name</th>
        <th>Summary</th>
        <th>Version</th>
        <?php if (!isset($short)): ?>
        <th>Build date</th>
        <th>Dist. Rel.</th>
          <?php if ($show_bug_links): ?>
        <th>Bug link</th>
          <?php endif; ?>
        <?php endif; ?>
      </tr>
      <?php endif; ?>
    </thead>
    <tbody>
    <?php $dates = array(); ?>
    <?php foreach ($pager as $rpm): ?>
      <?php $buildDate         = $rpm->getBuildtime('Y-m-d'); ?>
      <?php $dates[$buildDate] = $buildDate; ?>
      <tr class="rpm-<?php echo count($dates) % 2 ? 'odd' : 'even'?>">
        <td><?php echo link_to(
                    $rpm->getPackage()->getName(),
                    $madburl->urlFor(
                      'package/show',
                      $madbcontext,
                      array('extra_parameters' => array('name' => $rpm->getPackage()->getName()))
                    )
                  ); ?></td>
        <td><?php echo htmlspecialchars($rpm->getSummary()) ?></td>
        <td><?php echo link_to(
                    $rpm->getVersion(),
                    $madburl->urlForRpm($rpm, $madbcontext)
                  ); ?>
        </td>
        <?php if (!isset($short)): ?>
        <td><?php echo $buildDate ?></td>
        <td><?php echo $rpm->getDistrelease()->getDisplayedName() ?></td>
        <?php if ($show_bug_links): ?>
        <td>
        <?php
          if ($rpm->getIsSource() and $rpm->getBugNumber())
          {
            echo $link = link_to($rpm->getBugNumber() . " (" . $bugtracker->getLabelForMatchType($rpm->getBugMatchType()) . ")", $bugtracker->getUrlForBug($rpm->getBugNumber()));
          }
          elseif (!$rpm->getIsSource())
          {
            if ($srpm = $rpm->getRpmRelatedBySourceRpmId())
            {
              if ($srpm->getBugNumber())
              {
                echo $link = link_to($srpm->getBugNumber() . " (" . $bugtracker->getLabelForMatchType($srpm->getBugMatchType()) . ")", $bugtracker->getUrlForBug($srpm->getBugNumber()));
              }
            }
          }
        ?></td>
        <?php endif ?>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>

<?php else: ?>

No result.

<?php endif ?>

<?php if ($showpager): ?>
  <?php include_partial('default/pager', array(
    'pager'       => $pager,
    'module'      => 'rpm',
    'action'      => 'list',
    'madbcontext' => $madbcontext,
    'madburl'     => $madburl,
    'bottom'      => true,
    'showtotal'   => true,
  )) ?>
<?php endif; ?>
