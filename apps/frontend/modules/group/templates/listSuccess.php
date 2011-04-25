<h1>Groups</h1>
<?php if (!is_null($group_name)): ?>
<h2><?php echo $group_name ?></h2>
<?php endif; ?>
<div>
<ul class="packlist">
<?php foreach ($results as $values): ?>
  <li><?php 
  if ($values['the_name'] == $group_name) :
    echo link_to( "[packages directly contained in this group]", 
                  $madburl->urlFor( 'package/list', 
                                    $madbcontext, 
                                    array( 
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

