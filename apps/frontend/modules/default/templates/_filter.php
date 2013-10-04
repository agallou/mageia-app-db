<?php if (!in_array($name, array('search'))): ?>
  <?php echo $formField->render(); ?>
  <?php echo $formField->renderLabel(); ?>
<?php endif; ?>
<?php if (in_array($name, array_keys($filters))): ?>
  <?php $values = $filters[$name] ?>
  <span class='filtervalues'><?php echo implode(', ', $values); ?></span>
  <?php if (!in_array($name, $unremoveableFilters) && $show_delete): ?>
    <?php echo link_to('<i class="icon-remove"></i>', $madburl->urlFor($moduleaction, $madbcontext, array('keep_all_parameters' => true, 'ignored_parameters' => array($name)))); ?>
  <?php endif; ?>
<?php else : ?>
  <span class='filtervalues'>All</span>
<?php endif; ?>
