<table>
  <tr>
    <td>
<?php if ($link = $pager->getFirstPage()): ?>
      <?php echo link_to($link, $module . '/list?page=' . $link) ?>
<?endif ?>
    </td>
    <td>
<?php if ($link = $pager->getPrev()):?>
      <?php echo link_to('Previous', $module . '/list?page=' . $link) ?>
<?php endif?>
    </td>
    <td>
<?php foreach ($pager->getPrevLinks() as $link): ?>
      <?php echo link_to($link, $module . '/list?page=' . $link) ?> - 
<?php endforeach?>
    </td>
    <td>
      <?php $pager->getPage()?></td>
    <td>
<?php foreach ($pager->getNextLinks() as $link):?>
      - <?php echo link_to($link, $module . '/list?page=' . $link) ?>
<?php endforeach?>
    </td>
    <td>
<?php if ($link = $pager->getNext()):?>
      <?php echo link_to('Next', $module . '/list?page=' . $link) ?>
<?php endif ?>
    </td>
    <td>
<?php if ($link = $pager->getLastPage()):?>
      <?php echo link_to($link, $module . '/list?page=' . $link) ?>   
<?php endif?>
    </td>
  </tr>
</table>

