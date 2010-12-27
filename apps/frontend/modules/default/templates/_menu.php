<ul>
  <li><?php echo link_to('Homepage', '@homepage'); ?></li>
  <li>
      <h2>Latest</h2>
    <ul>
      <li><?php echo link_to('Updates (security and bugfix)', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'updates'), 'filters_parameters' => true))) ?></li>
      <li><?php echo link_to('Updates awaiting your testing', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'updates_testing'), 'filters_parameters' => true))) ?></li>
      <li><?php echo link_to('Backports (new soft versions)', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'backports'), 'filters_parameters' => true))) ?></li>
      <li><?php echo link_to('Backports awaiting your testing', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'backports_testing'), 'filters_parameters' => true))) ?></li>
    </ul>
  </li>
  <li>
      <h2>Browse applications/packages</h2>
    <ul>
      <li>By group</li>
      <li>By popularity</li>
      <li><?php echo link_to('By name', $madburl->urlFor('package/list', $madbcontext, array('filters_parameters' => true))) ?></li>
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
