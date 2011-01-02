<form>
<?php echo $form ?>
<input type="submit" value="Filter" />
</form>

<div id="filtersInfo">
<?php foreach ($filters as $name => $values): ?>
  <span class="name"><?php echo $name ?></span>:
  <?php echo implode(',', $values); ?>
  <br />
<?php endforeach; ?>
</div>


