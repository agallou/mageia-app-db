<h1>RPM : <?php echo $rpm->getName() ?></h1>
<div>
<h2 class='todo'>TODO</h2>
<p class='todo'>Make this page a well organized and designed page :)</p>
<h2>Basic items</h2>
<ul>
  <li>Name : <?php echo $rpm->getPackage()->getName() ?> <span class='todo'>TODO : Use a short_name field directly from rpm table ?</span></li>
  <li>Version : <?php echo $rpm->getVersion() ?></li>
  <li>Release : <?php echo $rpm->getRelease() ?></li>
  <li>Distribution release : <?php echo $rpm->getDistrelease()->getName() ?></li>
  <li>URL : <?php echo link_to($rpm->getUrl(), $rpm->getUrl()) ?></li>
  <li>Group : <?php echo $rpm->getRpmGroup()->getName() ?></li>
  <li>Summary : <?php echo $rpm->getSummary() ?></li>
  <li>Description : <br/><?php echo $rpm->getDescription() ?></li>
  <li>Size : <?php echo $rpm->getSize() ?></li>
  <li>Arch : <?php echo $rpm->getRealarch() ?></li>
</ul>

<h2>Advanced items</h2>
<ul>
  <li>Source RPM : <?php echo $rpm->getSrcRpm() ?><span class='todo'>TODO : link to SRC.RPM page.</span></li>
  <li>Files : <span class='todo'>TODO : query Sophie2</span></li>
  <li>Provides : <span class='todo'>TODO : query Sophie2</span></li>
  <li>Requires : <span class='todo'>TODO : query Sophie2</span></li>
  <li>Obsoletes : <span class='todo'>TODO : query Sophie2</span></li>
  <li>Suggests : <span class='todo'>TODO : query Sophie2</span></li>
  <li>installed size : <span class='todo'>TODO : how do we get it ?</span></li>
</ul>

</div>