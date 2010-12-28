<h1>Groups</h1>
<?php if (!is_null($t_group)): ?>
<h2><?php echo $t_group ?></h2>
<?php endif; ?>
<div>
<ul>
<?php foreach ($results as $values): ?>
  <li><?php $exploded_name = explode('/', $values['the_name']);
  $name = $exploded_name[count($exploded_name)-1];
  echo link_to( $name, 
                $madburl->urlFor( 'group/list', 
                                  $madbcontext, 
                                  array( 
                                    'extra_parameters' => array(
                                      't_group' => str_replace('/', '|', $values['the_name']),
                                      't_level' => $t_level + 1
                                    )
                                  )
                                )
              ); 
  echo ' : ' . $values['nb_of_packages']; 
  ?></li>
<?php endforeach; ?>
</ul>
</div>

