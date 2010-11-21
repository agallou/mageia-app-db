<ul>
  <li><?php echo link_to('Homepage', '@homepage'); ?></li>
  <li>
    Latest
    <ul>
      <li>Updates</li>
      <li>Backports</li>
      <li>Testing</li>
    </ul>
  </li>
  <li>
    Browse
    <ul>
      <li>By group</li>
      <li>By popularity</li>
      <li>By name</li>
      <li><?php echo link_to('Packages', 'package/list'); ?></li>
      <li><?php echo link_to('Applications', 'application/list'); ?></li> 
    </ul>
  </li>
  <li>
    Requests
    <ul>
      <li>Backports requests</li>
      <li>New soft requests</li>
    </ul>
  </li>
<?php if($sf_user->isAuthenticated()) : ?>
  <li>My Account</li>
<?php endif; ?>
</ul>
