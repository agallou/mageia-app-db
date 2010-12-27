<h1>Groups</h1>

<div>
<ul>
<?php foreach ($results as $values): ?>
  <li><?php echo $values['the_name'] . ' : ' . $values['nb_of_packages']; ?></li>
<?php endforeach; ?>
</ul>
</div>

