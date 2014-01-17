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
 > RPM : <?php echo $rpm->getName() ?>
<?php end_slot('name') ?>

<div class="rpm">

<div>
No RPM found for comparison.
</div>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
$('#filtering-border').remove();
<?php end_javascript_tag() ?>