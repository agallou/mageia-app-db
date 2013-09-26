<?php slot('name') ?>
<?php echo $title ?>
<?php end_slot('name') ?>

<?php include_component('rpm', 'list', array(
  'listtype'       => $listtype,
  'page'           => $page,
  'showpager'      => true,
  'display_header' => true,
  'limit'          => 50,
  'show_bug_links' => $show_bug_links
)) ?>
