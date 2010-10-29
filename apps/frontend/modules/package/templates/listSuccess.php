<h2><?php echo $title ?></h2>

<?php if (count($packages)): ?>
<ul>
  <?php foreach ($packages as $package): ?>
    <li><?php echo link_to($package->getName(), ' package/show?id=' . $package->getId()); ?></li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>
