<?php slot('title', 'Groups') ?>
<?php slot('name') ?>
Groups
<?php if (!is_null($group_name)): ?>
  (<?php echo $group_name ?>)
<?php endif; ?>

<?php end_slot('name') ?>

<div>
<ul class="packlist">
<?php foreach ($results as $values): ?>
  <li><?php
  if ($values['the_name'] == $group_name) :
    echo link_to( "[packages directly contained in this group]",
                  $madburl->urlFor( 'package/list',
                                    $madbcontext,
                                    array(
                                      'keep_all_parameters' => true,
                                      'extra_parameters' => array(
                                        't_group' => implode(',', RpmGroupPeer::getChildGroupsFor($values['the_name'], true, false)),
                                      )
                                    )
                                  )
                );
  else :
    $exploded_name = explode('/', $values['the_name']);
    $name = $exploded_name[count($exploded_name)-1];
    echo link_to( $name,
                  $madburl->urlFor( 'group/list',
                                    $madbcontext,
                                    array(
                                      'keep_all_parameters' => true,
                                      'extra_parameters' => array(
                                        't_group' => implode(',', RpmGroupPeer::getChildGroupsFor($values['the_name'], true)),
                                        'level' => $level + 1,
                                        'group_name' => str_replace('/', '|', $values['the_name'])
                                      )
                                    )
                                  )
                );
  endif;
  echo ' : ' . $values['nb_of_packages'];
  ?></li>
<?php endforeach; ?>
</ul>
</div>

