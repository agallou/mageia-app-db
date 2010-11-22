<ul>
  <li><?php echo link_to('Homepage', '@homepage'); ?></li>
  <li>
    Latest
    <ul>
      <li>Updates (security and bugfix)</li>
      <li>Backports (new soft versions)</li>
      <li>Packages awaiting testing</li>
    </ul>
  </li>
  <li>
    Browse applications/packages
    <ul>
      <li>By group</li>
      <li>By popularity</li>
      <li><?php echo link_to('By name', 'package/list'); ?></li>
    </ul>
  </li>
  <li>
    Requests
    <ul>
      <li>Backports requests</li>
      <li>New soft request</li>
    </ul>
  </li>
<?php if($sf_user->isAuthenticated()) : ?>
  <li>My Account</li>
<?php endif; ?>
</ul>
