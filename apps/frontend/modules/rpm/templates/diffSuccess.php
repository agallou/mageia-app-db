<?php slot('title', $rpm->getName()) ?>

<?php slot('name') ?>
Package : <?php echo link_to(
         $rpm->getPackage()->getName(),
         $madburl->urlFor( 'package/show',
                           $madbcontext,
                           array(
                             'extra_parameters' => array(
                               'name' => $rpm->getPackage()->getName()
                             )
                           )
                         )
       ); ?>
 > RPM : <?php echo link_to(
  $rpm->getName(),
  $madburl->urlForRpm(
    $rpm,
    $madbcontext,
    array(
         'moduleaction' => 'rpm/show'
    )
  )) ?>
<?php end_slot('name') ?>

<h2>Differences with <?php         echo link_to(
    $rpm_for_comparison->getName(),
    $madburl->urlForRpm(
      $rpm_for_comparison,
      $madbcontext,
      array(
        'moduleaction' => 'rpm/show'
      )
    )) ?></h2>

<div class="rpm">
<p>(from media <?php echo $rpm_for_comparison->getMedia()->getName() ?>)</p>
  
<pre>
<?php echo $output ?>
</pre>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
$('#filtering-border').remove();
<?php end_javascript_tag() ?>