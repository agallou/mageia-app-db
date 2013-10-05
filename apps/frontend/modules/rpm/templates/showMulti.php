<?php slot('title', 'Disambiguation') ?>
<h1>Disambiguation</h1>
<p>Several RPMs match your current selection. Please choose one.</p>
<ul>
  <?php foreach ($rpms as $rpm) : ?>
  <li>
  <?php echo link_to(
          $rpm->getName(),
          $madburl->urlForRpm($rpm, $madbcontext)
        ); ?>
    (<?php echo $rpm->getIsSource() == 1 ? "Source RPM, " : "" ?>
     <?php echo $rpm->getDistrelease()->getDisplayedName() ?>,
     <?php echo $rpm->getArch()->getName()?> media,
     <?php echo $rpm->getMedia()->getName()?>)
  </li>
  <?php endforeach ?>
</ul>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
$('#filtering').remove();
<?php end_javascript_tag() ?>
