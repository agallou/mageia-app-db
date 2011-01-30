<?php if ($madbcontext->hasParameter('t_search')): ?>
  You searched for : <?php echo $madbcontext->getParameter('t_search') ?>
  <?php echo link_to('Remove search', $urldelete) ?>
<?php endif; ?>

