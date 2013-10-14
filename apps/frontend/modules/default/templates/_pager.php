<?php $currentPage = $pager->getPage() ?>
<?php $lastPage = $pager->getLastPage() ?>
<?php $isBottom = isset($bottom) && $bottom ?>
<?php $hasMultiplePages = ($lastPage > 1) ?>

<div class="pager <?php $isBottom && print 'pager-bottom' ?>">

  <?php if ($hasMultiplePages):  ?>

    <?php if (isset($showtotal) && $showtotal): ?>
    <div id="pagercount">
        Total results : <span id="count"><?php echo $pager->getTotalRecordCount() ?></span>
    </div>
    <?php endif; ?>


    <?php if ($hasMultiplePages): ?>
      <div id="pagerbuttons">
        <ul>

          <?php if ($link = $pager->getFirstPage() && $pager->getPage() != 1): ?>
            <li class="tooltip" title="First page"><?php echo link_to('<i class="icon-double-angle-left"></i>', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
          <?php endif; ?>

          <?php if ($link = $pager->getPrev()):?>
            <li class="tooltip" title="Previous page"><?php echo link_to('<i class="icon-angle-left"></i>', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link))))  ?></li>
          <?php endif; ?>

          <?php foreach ($pager->getPrevLinks() as $link): ?>
            <li><?php echo link_to($link, $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
          <?php endforeach; ?>

          <li class="current"><?php echo $currentPage ?></li>

          <?php foreach ($pager->getNextLinks() as $link): ?>
            <li><?php echo link_to($link, $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
          <?php endforeach; ?>

          <?php if ($link = $pager->getNext()): ?>
            <li class="tooltip" title="Next page"><?php echo link_to('<i class="icon-angle-right"></i>', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
          <?php endif; ?>

          <?php if (($link = $lastPage) && $currentPage != $link): ?>
            <li class="tooltip" title="Last page"><?php echo link_to('<i class="icon-double-angle-right"></i>', $madburl->urlFor($module . '/' . $action, $madbcontext, array('keep_all_parameters' => true, 'extra_parameters' => array('page' => $link)))) ?></li>
          <?php endif; ?>

        </ul>
      </div>
    <?php endif ?>


  <?php endif ?>
</div>

