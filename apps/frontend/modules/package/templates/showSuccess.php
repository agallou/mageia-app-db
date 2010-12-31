<h1>Package : <?php echo $package->getName() ?></h1>
<div>
<h2>Package details</h2>
<p> <strong>Summary</strong> : <?php echo $package->getSummary() ?></p>
<p> <strong>Description</strong> :<br/>
<?php echo nl2br($package->getDescription()) ?></p>
<br/>
<h2>List of RPMs</h2>
<ul>
  <?php foreach ($rpms as $rpm) : ?>
  <li>Name : <?php echo link_to($rpm->getName(), $madburl->urlFor('rpm/show', $madbcontext, array('extra_parameters' => array('id' => $rpm->getid())))); ?> (<?php echo $rpm->getDistrelease()->getName() ?>, <?php echo $rpm->getArch()->getName()?> media, <?php echo $rpm->getMedia()->getName()?>)</li>
  <?php endforeach; ?>
</ul>
</div>
<br/>
<br/>
<p><span class='todo'>TODO : show also RPM versions from other distreleases (you're browsing the 2011.0 release, 2011.1 has a newer version...).</span></p>
<h2>Backport requests</h2>
<p><span class='todo'>TODO : show existing backport requests for this package (for the distrelease we're browsing), and allow to ask for new backports.</span>
</p>
