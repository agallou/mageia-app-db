<h1>RPM : <?php echo $rpm->getName() ?></h1>
<div>
<h2 class='todo'>TODO</h2>
<p class='todo'>Make this page a well organized and designed page :)</p>
<h2>Basic items</h2>
<ul>
  <li>Name : <?php echo $rpm->getShortName() ?></li>
  <li>Version : <?php echo $rpm->getVersion() ?></li>
  <li>Release : <?php echo $rpm->getRelease() ?></li>
  <li>URL : <?php echo link_to($rpm->getUrl(), $rpm->getUrl()) ?></li>
  <li>Group : <?php echo $rpm->getRpmGroup()->getName() ?></li>
  <li>Summary : <?php echo $rpm->getSummary() ?></li>
  <li>Description : <br/><?php echo nl2br($rpm->getDescription()) ?></li>
  <li>Size : <?php echo $rpm->getSize() ?></li>
  <li>Arch : <?php echo $rpm->getRealarch() ?></li>
</ul>

<h2>Media information</h2>
<ul>
  <li>Distribution release : <?php echo $rpm->getDistrelease()->getName() ?></li>
  <li>Media name : <?php echo $rpm->getMedia()->getName() ?></li>
  <li>Media arch : <?php echo $rpm->getArch()->getName() ?></li>
</ul>

<h2>Advanced items</h2>
<ul>
  <li>Source RPM : <?php $src_rpm = $rpm->getRpmRelatedBySourceRpmId();
  echo link_to(
         $src_rpm->getName(),
         $madburl->urlFor( 'rpm/show', 
                           $madbcontext, 
                           array( 
                             'extra_parameters' => array(
                               'id' => $src_rpm->getId() 
                             )
                           )
                         )
       ); ?></li>
  <li>Build time : <?php echo $rpm->getBuildtime() ?></li>
  <li>Files : <span class='todo'>TODO : query Sophie</span></li>
  <li>Provides : <span class='todo'>TODO : query Sophie</span></li>
  <li>Requires : <span class='todo'>TODO : query Sophie</span></li>
  <li>Obsoletes : <span class='todo'>TODO : query Sophie</span></li>
  <li>Suggests : <span class='todo'>TODO : query Sophie</span></li>
  <li>installed size : <span class='todo'>TODO</span></li>
</ul>

</div>