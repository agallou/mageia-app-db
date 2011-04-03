<ul>
  <li><?php echo link_to('Homepage', $madburl->urlFor('@homepage', $madbcontext, array('filters_parameters' => true))) ?></li>
  <li>
      <h2>Latest</h2>
    <ul>
    <?php if ($has_updates) : ?>
      <li><?php echo link_to('Updates', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'updates'), 'filters_parameters' => true))) ?></li>
    <?php endif; ?>
    <?php if ($has_updates_testing) : ?>
      <li><?php echo link_to('Update candidates', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'updates_testing'), 'filters_parameters' => true))) ?></li>
    <?php endif; ?>
    <?php if ($has_backports) : ?>
      <li><?php echo link_to('Backports', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'backports'), 'filters_parameters' => true))) ?></li>
    <?php endif; ?>
    <?php if ($has_backports_testing) : ?>
      <li><?php echo link_to('Backport candidates', $madburl->urlFor('rpm/list', $madbcontext, array('extra_parameters' => array('listtype' => 'backports_testing'), 'filters_parameters' => true))) ?></li>
    <?php endif; ?>
    </ul>
  </li>
  <li>
      <h2>Browse</h2>
    <ul>
      <li><?php echo link_to('By group', $madburl->urlFor('group/list', $madbcontext, array('filters_parameters' => true))) ?></li>
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
