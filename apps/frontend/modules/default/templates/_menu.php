<ul>
  <li><?php echo link_to('Homepage', '@homepage'); ?></li>
  <li><?php echo link_to('Packages', 'package/list'); ?></li>
  <li><?php echo link_to('Applications', 'application/list'); ?></li> 
<?php if($sf_user->isAuthenticated()) : ?>
  <li>My Account</li>
<?php endif; ?>
</ul>
