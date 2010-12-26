<h1>Package : <?php echo $package->getName() ?></h1>
<div>
<h2>Package details</h2>
<p><span class='todo'>TODO : Add summary and description in DB so that we can print them</span></p>
<h2>List of RPMs</h2>
<p><br/><span class='todo'>TODO : keep only binary RPMs + order by descending EVR version. + differentiate "release" packages, updates and backports, and from which media they come.</span>
<br/><span class='todo'>TODO : show also RPM versions from other distreleases (you're browsing the 2011.0 release, 2011.1 has a newer version...).</span>
</p>
<ul>
  <?php foreach ($rpms as $rpm) : ?>
  <li>Name : <?php echo link_to($rpm->getName(), $madburl->urlFor('rpm/show', $madbcontext, array('extra_parameters' => array('id' => $rpm->getid())))); ?> (<?php echo $rpm->getDistrelease()->getName() ?>, <?php echo $rpm->getArch()->getName()?> media, <?php echo $rpm->getMedia()->getName()?>)</li>
  <?php endforeach; ?>
</ul>
</div>
<h2>Backport requests</h2>
<p><span class='todo'>TODO : show existing backport requests for this package (for the distrelease we're browsing).</span>
</p>
<div id="demande-backport">
Backport request
</div>
