<div class="pager">
<ul>
<?php if ($link = $pager->getFirstPage()): ?>
  <li><?php echo link_to(htmlentities('<<') . 'First', $module . '/list?page=' . $link) ?></li>
<?php endif; ?>
<?php if ($link = $pager->getPrev()):?>
  <li><?php echo link_to(htmlentities('<') . 'Previous', $module . '/list?page=' . $link) ?></li>
<?php endif; ?>
<?php foreach ($pager->getPrevLinks() as $link): ?>
  <li><?php echo link_to($link, $module . '/list?page=' . $link) ?></li>
<?php endforeach; ?>
  <li class="current"><?php echo $pager->getPage()?></li>
<?php foreach ($pager->getNextLinks() as $link): ?>
  <li><?php echo link_to($link, $module . '/list?page=' . $link) ?></li>
<?php endforeach; ?>
<?php if ($link = $pager->getNext()): ?>
  <li><?php echo link_to('Next' . htmlentities('>'), $module . '/list?page=' . $link) ?></li>
<?php endif; ?>
<?php if ($link = $pager->getLastPage()): ?>
  <li><?php echo link_to('Last' . htmlentities('>>') ,$module . '/list?page=' . $link) ?></li>
<?php endif; ?>
</ul>
<?php if (isset($message)): ?>
  <p><?php echo sprintf($message, $pager->getTotalRecordCount()) ?></p>
<?php endif; ?>
</div>
