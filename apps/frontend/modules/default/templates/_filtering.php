<form>
<?php foreach ($form as $name => $formField) : ?>
  <?php if (!in_array($name, array_keys($filters))): ?>
    <?php continue; ?>
  <?php endif; ?>
  <?php echo $formField->render(); ?>
  <?php echo $formField->renderLabel(); ?>

  <?php $values = $filters[$name] ?>
  <?php echo implode(',', $values); ?>
  <?php if (!in_array($name, $unremoveableFilters)): ?>
    <?php echo link_to(image_tag('icons/cross'), $madburl->urlFor($moduleaction, $madbcontext, array('ignored_parameters' => array($name)))); ?>
  <?php endif; ?>
<?php endforeach; ?>

<input type="submit" value="Filter" />
</form>

<?php include_component_slot('searching') ?>
