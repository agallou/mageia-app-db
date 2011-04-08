<?php if (!in_array($name, array('search'))): ?>
  <?php echo $formField->render(); ?>
  <?php echo $formField->renderLabel(); ?>
<?php endif; ?>
<?php if (in_array($name, array_keys($filters))): ?>
  <?php $values = $filters[$name] ?>
  <?php echo implode(',', $values); ?>
  <?php if (!in_array($name, $unremoveableFilters) && $show_delete): ?>
    <?php echo link_to(image_tag('icons/cross', array('class' => 'delete')), $madburl->urlFor($moduleaction, $madbcontext, array('ignored_parameters' => array($name)))); ?>
  <?php endif; ?>
<?php endif; ?>
