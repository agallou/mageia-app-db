<ul>
  <li><?php echo link_to('Homepage', '@homepage'); ?></li>
  <li>
      <h2>Latest</h2>
    <ul>
      <li><?php echo link_to('Updates (security and bugfix)', 'rpm/list?listtype=updates'); ?></li>
      <li><?php echo link_to('Backports (new soft versions)', 'rpm/list?listtype=backports'); ?></li>
      <li><?php echo link_to('Packages awaiting your testing', 'rpm/list?listtype=testing'); ?></li>
    </ul>
  </li>
  <li>
      <h2>Browse applications/packages</h2>
    <ul>
      <li>By group</li>
      <li>By popularity</li>
      <li><?php echo link_to('By name', 'package/list'); ?></li>
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
