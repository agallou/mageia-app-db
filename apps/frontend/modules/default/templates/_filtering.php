<form class="filters">
<?php $partialParameters = array(
  'filters'            => $filters,
  'unremoveableFilters'=> $unremoveableFilters,
  'madburl'            => $madburl,
  'moduleaction'       => $moduleaction,
  'madbcontext'        => $madbcontext,
); ?>

<?php $otherFilters = array('group', 'source'); ?>
<?php foreach ($form as $name => $formField) : ?>
  <?php if (!in_array($name, $otherFilters)): ?>
    <?php include_partial('default/filter', array_merge($partialParameters, array(
      'name'      => $name,
      'formField' => $formField,
    ))) ?>
  <?php endif; ?>
<?php endforeach; ?>

<span id="linkmore">More...</span>

<div id="otherFilters">
<?php foreach ($form as $name => $formField) : ?>
  <?php if (in_array($name, $otherFilters)): ?>
    <?php include_partial('default/filter', array_merge($partialParameters, array(
      'name'      => $name,
      'formField' => $formField,
    ))) ?>
  <?php endif; ?>
<?php endforeach; ?>
</div>

<input type="submit" value="Filter" />
</form>

<?php include_component_slot('searching') ?>
