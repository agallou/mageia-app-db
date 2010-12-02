<ul>
  <li><?php echo link_to('Homepage', '@homepage'); ?></li>
  <li>
      <h2>Latest</h2>
    <ul>
      <li>Updates (security and bugfix)</li>
      <li>Backports (new soft versions)</li>
      <li>Packages awaiting testing</li>
    </ul>
  </li>
  <li>
      <h2>Browse applications/packages</h2>
    <ul>
      <li>By group</li>
      <li>By popularity</li>
      <li>By name</li>
      <li><?php echo link_to('Packages', 'package/list'); ?></li>
      <li><?php echo link_to('Applications', 'application/list'); ?></li> 
    </ul>
  </li>
  <li>
      <h2>Requests</h2>
    <ul>
      <li>Backports requests</li>
      <li>New soft request</li>
    </ul>
  </li>
<?php if($sf_user->isAuthenticated()) : ?>
  <li><h2>My Account</h2></li>
<?php endif; ?>
</ul>
