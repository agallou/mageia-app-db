<div class="filters" style="display:none">
<form>
<?php $partialParameters = array(
  'filters'            => $filters,
  'unremoveableFilters'=> $unremoveableFilters,
  'madburl'            => $madburl,
  'moduleaction'       => $moduleaction,
  'madbcontext'        => $madbcontext,
); ?>

<?php $otherFilters = array('group', 'source', 'media'); ?>
<?php $order = array('distrelease', 'application', 'arch'); ?>
<?php foreach ($order as $name) : ?>
  <?php $formField = $form[$name]; ?>
  <?php if (!in_array($name, $otherFilters)): ?>
    <?php include_partial('default/filter', array_merge($partialParameters, array(
      'name'        => $name,
      'formField'   => $formField,
      'show_delete' => false,
    ))) ?>
  <?php endif; ?>
<?php endforeach; ?>

<span id="linkmore">More...</span>

<div id="otherFilters">
<?php $order = array('source', 'media', 'group'); ?>
<?php foreach ($order as $name) : ?>
  <?php $formField = $form[$name]; ?>
  <?php if (in_array($name, $otherFilters)): ?>
    <?php include_partial('default/filter', array_merge($partialParameters, array(
      'name'        => $name,
      'formField'   => $formField,
      'show_delete' => true,
    ))) ?>
  <?php endif; ?>
<?php endforeach; ?>
</div>

<input type="submit" value="Filter" />
</form>
</div>
<script>
  $('.filters').hide();
</script>
<?php include_component_slot('searching') ?>
