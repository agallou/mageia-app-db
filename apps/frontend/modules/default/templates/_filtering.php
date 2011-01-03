<form>
<?php echo $form ?>
<input type="submit" value="Filter" />
</form>

<div id="filtersInfo">
<?php foreach ($filters as $name => $values): ?>
  <span class="name"><?php echo $name ?></span>:
  <?php echo implode(',', $values); ?>
  <?php if (!in_array($name, $unremoveableFilters)): ?>
    <?php echo link_to('remove', $madburl->urlFor($moduleaction, $madbcontext, array('ignored_parameters' => array($name)))); ?>
  <?php endif; ?>
  <br />
<?php endforeach; ?>
</div>


