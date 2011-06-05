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
<?php if ($sf_user->isAuthenticated()): ?>
  <a href="#" id="packageSubscribe">Subscribe to this package's news</a>

  <div id="subscribeForm" title="Subscribe to changes for this package">
  <form>
  <?php echo $subscribe_form?>
  </form>
  </div>
<?php endif; ?>
