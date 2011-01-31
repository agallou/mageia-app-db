<div id="intro" class="links">
  <div class="content_group">Welcome to mageia-app-db</div>

  <p>This is a work in progress lacking many features, but you can already search and browse packages. Use the search form, browse by category or use the left menu.</p>
  <p>There are persistent navigation filters, which you can change at any time from the filter banner : distribution release, show only applications or all packages, media, arch, etc.</p>
  <p>Click <a href="http://mageia-app-db.tuxette.fr/projects/mageia-app-db/wiki">here</a> for more information about this project.</p>
</div>

<div id="groups" class="links">
  <div class="content_group">Groups</div>
  <table width="100%">
  <?php $cpt = 0 ?>
  <?php foreach ($groups as $values): ?>
    <?php if ($cpt == 0): ?>
      <tr>
    <?php endif; ?>
      <td>
      <?php $exploded_name = explode('/', $values['the_name']); ?>
      <?php $name          = $exploded_name[count($exploded_name)-1]; ?>
      <?php echo link_to(
              $name, 
              $madburl->urlFor('group/list', 
                $madbcontext, 
                 array( 
                   'extra_parameters' => array(
                      't_group'    => implode(',', RpmGroupPeer::getGroupsIdsWhereNameLike($values['the_name'] . "%")),
                      'level'      =>  1 + 1,
                      'group_name' => str_replace('/', '|', $values['the_name'])
                   )
                 )
              )
            ); ?>
      </td>
    <?php if ($cpt == sfConfig::get('app_homepage_groups_line')): ?>
      </tr>
    <?php endif; ?>
    <?php $cpt++ ?>
    <?php if ($cpt == sfConfig::get('app_homepage_groups_line')): ?>
      <?php $cpt = 0; ?>
    <?php endif; ?>
  <?php endforeach; ?>
  </table>
</div>

<div id="updates">
  <div class="content_group">Latest updates</div>
  <?php include_component('rpm', 'list', array(
    'listtype'       => 'updates',
    'page'           => 1,
    'showpager'      => false,
    'display_header' => false,
    'limit'          => sfConfig::get('app_homepage_rpm_limit'),
  )) ?>
</div>

<div id="backports">
  <div class="content_group">Latest backports</div>
  <?php include_component('rpm', 'list', array(
    'listtype'       => 'backports',
    'page'           => 1,
    'showpager'      => false,
    'display_header' => false,
    'limit'          => sfConfig::get('app_homepage_rpm_limit'),
  )) ?>
</div>
