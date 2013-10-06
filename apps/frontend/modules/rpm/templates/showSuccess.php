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
<h2>Basic items</h2>

<?php
$basics = array(
  'Name' => $rpm->getShortName(),
  'Version' => $rpm->getVersion(),
  'Release' => $rpm->getRelease(),
  'URL' => $rpm->getUrl() ? link_to($rpm->getUrl(), $rpm->getUrl()) : '',
  'Group' => $rpm->getRpmGroup()->getName(),
  'Summary' => htmlspecialchars($rpm->getSummary()),
  'Size' => $rpm->getSize(),
  'Arch' => $rpm->getRealarch(),
);
?>

<table class="infos">
  <tbody>
    <?php foreach ($basics as $name => $value): ?>
    <tr>
      <td class="name"><?php echo $name ?></td>
      <td><?php echo $value ?></td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>

<ul>
</ul>

<h2>Description</h2>
<div class="rpm-description">
<?php echo nl2br(htmlspecialchars($rpm->getDescription())) ?>
</div>

<h2>Media information</h2>
<?php
$media = array(
  'Distribution release' => $rpm->getDistrelease()->getDisplayedName(),
  'Media name' => $rpm->getMedia()->getName(),
  'Media arch' => $rpm->getArch()->getName(),
);
?>
<table class="infos">
  <tbody>
    <?php foreach ($media as $name => $value): ?>
    <tr>
      <td class="name"><?php echo $name ?></td>
      <td><?php echo $value ?></td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>



<h2>Advanced items</h2>
<?php
$advanced = array(
  'Source RPM' => ($src_rpm = $rpm->getRpmRelatedBySourceRpmId()) ? link_to($src_rpm->getName(), $madburl->urlForRpm($src_rpm, $madbcontext)) : "NOT IN DATABASE ?!",
  'Build time' => $rpm->getBuildtime(),
  'Changelog' => link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId()) . '/changelog'),
  'Files' => link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId()) . '/files'),
  'Dependencies' => link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId()) . '/deps'),

);
?>
<table class="infos">
  <tbody>
    <?php foreach ($advanced as $name => $value): ?>
    <tr>
      <td class="name"><?php echo $name ?></td>
      <td><?php echo $value ?></td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>


<br/>
<?php echo link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId())) ?>
</div>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
$('#filtering-border').remove();
<?php end_javascript_tag() ?>

</div>
