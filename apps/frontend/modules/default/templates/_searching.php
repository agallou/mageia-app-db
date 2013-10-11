<form class="searchform" method="get" action="<?php echo $url ?>" style="display:inline">
<?php if($showTitle): ?>
Filter by package name:
<?php endif; ?>
<input type="text" name="t_search" /><input type="submit" value="filter" />
</form>
<?php if ($showinfos): ?>
  <?php if ($madbcontext->hasParameter('t_search')): ?>
  <span class="links">
  Current filter: <?php echo $madbcontext->getParameter('t_search') ?>
  <?php echo link_to('<i class="icon-remove"></i>', $urldelete) ?>
  </span>
  <?php endif; ?>
<?php endif; ?>
