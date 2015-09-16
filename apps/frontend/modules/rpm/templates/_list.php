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
        <th>Release</th>
        <th>Build date</th>
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
        <td class='summary'><?php echo htmlspecialchars($rpm->getSummary()) ?></td>
        <td><?php echo link_to(
                    $rpm->getVersion(),
                    $madburl->urlForRpm($rpm, $madbcontext)
                  ); ?>
        </td>
        <?php if (!isset($short)): ?>
        <td><?php echo $rpm->getRelease() ?>
        <td><?php echo $buildDate ?></td>
        <?php if ($show_bug_links): ?>
        <td>
        <?php
          if ($rpm->getBugNumber(true))
          {
            echo $link = link_to($rpm->getBugNumber(true) . " (" . $bugtracker->getLabelForMatchType($rpm->getBugMatchType(true)) . ")", $bugtracker->getUrlForBug($rpm->getBugNumber(true)));
          }
        ?></td>
        <?php endif ?>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>

  <?php if (isset($end_callback)): ?>
    <?php echo $end_callback() ?>
  <?php endif ?>

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
