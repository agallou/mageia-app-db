<h1>Package : <?php echo link_to(
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
, RPM : <?php echo $rpm->getName() ?></h1>
<div>
<h2 class='todo'>TODO</h2>
<p class='todo'>Make this page a well organized and designed page :)</p>
<h2>Basic items</h2>
<ul>
  <li>Name : <?php echo $rpm->getShortName() ?></li>
  <li>Version : <?php echo $rpm->getVersion() ?></li>
  <li>Release : <?php echo $rpm->getRelease() ?></li>
  <li>URL : <?php echo $rpm->getUrl() ? link_to($rpm->getUrl(), $rpm->getUrl()) : '' ?></li>
  <li>Group : <?php echo $rpm->getRpmGroup()->getName() ?></li>
  <li>Summary : <?php echo htmlspecialchars($rpm->getSummary()) ?></li>
  <li>Description : <br/><?php echo nl2br(htmlspecialchars($rpm->getDescription())) ?></li>
  <li>Size : <?php echo $rpm->getSize() ?></li>
  <li>Arch : <?php echo $rpm->getRealarch() ?></li>
</ul>

<h2>Media information</h2>
<ul>
  <li>Distribution release : <?php echo $rpm->getDistrelease()->getDisplayedName() ?></li>
  <li>Media name : <?php echo $rpm->getMedia()->getName() ?></li>
  <li>Media arch : <?php echo $rpm->getArch()->getName() ?></li>
</ul>

<h2>Advanced items</h2>
<ul>
  <li>Source RPM : <?php 
  if ($src_rpm = $rpm->getRpmRelatedBySourceRpmId()) 
  {
    echo link_to(
           $src_rpm->getName(),
           $madburl->urlForRpm(
             $src_rpm, 
             $madbcontext
           )
         ); 
  }
  else
  {
    echo "NOT IN DATABASE ?!";
  }?></li>
  <li>Build time : <?php echo $rpm->getBuildtime() ?></li>
  <li>Changelog : <?php echo link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId()) . '/changelog') ?></li>
  <li>Files : <?php echo link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId()) . '/files') ?></li>
  <li>Dependencies : <?php echo link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId()) . '/deps') ?></li>
  <li>installed size : <span class='todo'>TODO</span></li>
</ul>
<br/>
<?php echo link_to("View in Sophie", $sophie->getUrlForPkgId($rpm->getRpmPkgId())) ?>
</div>