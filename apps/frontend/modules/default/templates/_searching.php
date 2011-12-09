<form class="searchform" method="get" action="<?php echo $url ?>" style="display:inline">
<?php if($showTitle): ?>
Search in this page:
<?php endif; ?>
<input type="text" name="t_search" /><input type="submit" value="search" />
</form>
<?php if ($showinfos): ?>
  <?php if ($madbcontext->hasParameter('t_search')): ?>
  <span class="links">
  You searched for : <?php echo $madbcontext->getParameter('t_search') ?>
  <?php echo link_to('Clear', $urldelete) ?>
  </span>
  <?php endif; ?>
<?php endif; ?>
