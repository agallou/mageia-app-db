<h1>Package : <?php echo $package->getName() ?></h1>
<div>
<h2>Package details</h2>
<p> <strong>Summary</strong> : <?php echo htmlspecialchars($package->getSummary()) ?></p>
<p> <strong>Description</strong> :<br/>
<?php echo nl2br(htmlspecialchars($package->getDescription())) ?></p>
<br/>
<h2>List of RPMs</h2>
<ul>
  <?php foreach ($rpms as $rpm) : ?>
  <li><?php echo link_to($rpm->getName(), $madburl->urlFor('rpm/show', $madbcontext, array('extra_parameters' => array('id' => $rpm->getid())))); ?> (<?php echo $rpm->getDistrelease()->getName() ?>, <?php echo $rpm->getArch()->getName()?> media, <?php echo $rpm->getMedia()->getName()?>)</li>
  <?php endforeach; ?>
</ul>
</div>
<br/>
<h2>Screenshot</h2>
(from <a href="http://screenshots.debian.net">http://screenshots.debian.net</a>)
<br/>
<a href="http://screenshots.debian.net/screenshot/<?php echo $package->getName() ?>">
  <img src="http://screenshots.debian.net/thumbnail/<?php echo $package->getName() ?>"/>
</a>
<br/>
<br/>
<!--  <h2>Backport requests</h2> -->
