<h1><?php echo $title ?></h1>

<?php include_component('rpm', 'list', array(
  'listtype'       => $listtype,
  'page'           => $page,
  'showpager'      => true,
  'display_header' => true,
  'limit'          => 50,
  'show_bug_links' => $show_bug_links
)) ?>
