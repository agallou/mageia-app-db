<ul>
  <li><?php echo link_to('Packages', 'package/list'); ?></li>
<?php if($sf_user->isAuthenticated()) : ?>
  <li>My Account</li>
<?php endif; ?>
</ul>
