<div class="pager <?php isset($extra_class) && print $extra_class ?>">
<div id="pagercount">
<?php if (isset($showtotal) && $showtotal): ?>
Total results : <span id="count"><?php echo $pager->getTotalRecordCount() ?></span>
<?php endif; ?>
<?php if (isset($message)): ?>
  <p><?php echo sprintf($message, $pager->getTotalRecordCount()) ?></p>
<?php endif; ?>
</div>
<div id="pagerbuttons">
<ul>
<?php $currentPage = $pager->getPage() ?>
<?php if ($link = $pager->getFirstPage() && $pager->getPage() != 1): ?>
  <li><?php echo link_to('<i class="icon-double-angle-left"></i> First', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
<?php endif; ?>
<?php if ($link = $pager->getPrev()):?>
  <li><?php echo link_to('<i class="icon-angle-left"></i> Previous', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link))))  ?></li>
<?php endif; ?>
<?php foreach ($pager->getPrevLinks() as $link): ?>
  <li><?php echo link_to($link, $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
<?php endforeach; ?>
  <li class="current"><?php echo $currentPage ?></li>
<?php foreach ($pager->getNextLinks() as $link): ?>
  <li><?php echo link_to($link, $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
<?php endforeach; ?>
<?php if ($link = $pager->getNext()): ?>
  <li><?php echo link_to('Next <i class="icon-angle-right"></i>', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
<?php endif; ?>
<?php if (($link = $pager->getLastPage()) && $currentPage != $link): ?>
  <li><?php echo link_to('Last <i class="icon-double-angle-right"></i>', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
<?php endif; ?>
</ul>
</div>
</div>
