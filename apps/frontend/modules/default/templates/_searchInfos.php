<?php if ($madbcontext->hasParameter('t_search')): ?>
  You searched for : <?php echo $madbcontext->getParameter('t_search') ?>
  <?php echo link_to('Clear', $urldelete) ?>
<?php endif; ?>

