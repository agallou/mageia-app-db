<div class="filters" style="display:none">
<form action="<?php echo $madburl->urlFor($moduleaction, $madbcontext, array('ignored_parameters' => array_merge(array_keys($filters), array('page')))) ?>"
      uglyhack="<?php echo $madburl->urlFor('default/getUrl') ?>"
      uglyhack2="<?php echo $madburl->urlFor($moduleaction, $madbcontext, array('keep_all_parameters' => true)) ?>">

<?php $partialParameters = array(
  'filters'            => $filters,
  'unremoveableFilters'=> $unremoveableFilters,
  'madburl'            => $madburl,
  'moduleaction'       => $moduleaction,
  'madbcontext'        => $madbcontext,
); ?>

<?php $otherFilters = array('group', 'source', 'media'); ?>
<?php $order = array('release', 'application', 'arch'); ?>
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

<span id="linkmore" title="Show/hide more filters">More <i class="icon-double-angle-down"></i></span>
<br style="clear:left;"/>
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
