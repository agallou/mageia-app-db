
<h1><?php echo $listtype ?> RPM</h1>

<p class='todo'>TODO : fix pager</p>
<p class='todo'>TODO : fix h1</p>


<?php include_partial('rpm/pager', array('pager' => $pager, 'module' => 'rpm', 'madbcontext' => $madbcontext)); ?>

<div>
Total results : <span id="count"></span>
<ul id="results" class="packlist">
<?php foreach ($pager as $rpm): ?>
  <li><?php echo $rpm->getBuildtime() ?> : <?php echo link_to($rpm->getName(), $madburl->urlFor('rpm/show', $madbcontext, array('extra_parameters' => array('id' => $rpm->getid())))); ?></li> 
<?php endforeach; ?>
</ul>
</div>

<?php include_partial('rpm/pager', array('pager' => $pager, 'module' => 'rpm', 'madbcontext' => $madbcontext)); ?>
