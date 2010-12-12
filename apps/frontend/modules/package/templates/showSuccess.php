<h1><?php echo $package->getName() ?></h1>
<div>
<h2>Package details</h2>
<p><span class='todo'>TODO : Add description in DB so that we can print it</span></p>
<h2>List of RPMs</h2>
<p><br/><span class='todo'>TODO : apply global filters to the list + keep only binary RPMs + add links to RPM pages + order by descending EVR version. + differentiate "release" packages, updates and backports, and from which media they come</span>
<br/><span class='todo'>TODO : show also RPM versions from other distreleases (you're browsing the 2011.0 release, 2011.1 has a newer version...).</span>
</p>
<ul>
  <?php foreach ($package->getRpms() as $rpm) : ?>
  <li>Name : <?php echo $rpm->getName() ?></li>
  <?php endforeach; ?>
</ul>
</div>
<h2>Backport requests</h2>
<p><span class='todo'>TODO : show existing backport requests for this package (for the distrelease we're browsing).</span>
</p>
</p>
<div id="demande-backport">
Backport request
</div>
