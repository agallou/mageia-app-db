<div class="pager">
<ul>
<?php if ($link = $pager->getFirstPage()): ?>
  <li><?php echo link_to(htmlentities('<<') . 'First', $madburl->urlFor($module . '/' . $action, $madbcontext, array('extra_parameters' => array('page' => $link)))) ?></li>
<?php endif; ?>
<?php if ($link = $pager->getPrev()):?>
  <li><?php echo link_to(htmlentities('<') . 'Previous', $madburl->urlFor($module . '/' . $action, $madbcontext, array('extra_parameters' => array('page' => $link))))  ?></li>
<?php endif; ?>
<?php foreach ($pager->getPrevLinks() as $link): ?>
  <li><?php echo link_to($link, $madburl->urlFor($module . '/' . $action, $madbcontext, array('extra_parameters' => array('page' => $link)))) ?></li>
<?php endforeach; ?>
  <li class="current"><?php echo $pager->getPage()?></li>
<?php foreach ($pager->getNextLinks() as $link): ?>
  <li><?php echo link_to($link, $madburl->urlFor($module . '/' . $action, $madbcontext, array('extra_parameters' => array('page' => $link)))) ?></li>
<?php endforeach; ?>
<?php if ($link = $pager->getNext()): ?>
  <li><?php echo link_to('Next' . htmlentities('>'), $madburl->urlFor($module . '/' . $action, $madbcontext, array('extra_parameters' => array('page' => $link)))) ?></li>
<?php endif; ?>
<?php if ($link = $pager->getLastPage()): ?>
  <li><?php echo link_to('Last' . htmlentities('>>') ,$madburl->urlFor($module . '/' . $action, $madbcontext, array('extra_parameters' => array('page' => $link)))) ?></li>
<?php endif; ?>
</ul>
<?php if (isset($showtotal) && $showtotal): ?>
Total results : <span id="count"><?php echo $pager->getTotalRecordCount() ?></span>
<?php endif; ?>
<?php if (isset($message)): ?>
  <p><?php echo sprintf($message, $pager->getTotalRecordCount()) ?></p>
<?php endif; ?>
</div>
