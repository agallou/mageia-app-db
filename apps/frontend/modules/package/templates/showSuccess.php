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
  <li><?php echo link_to($rpm->getName(), $madburl->urlForRpm($rpm, $madbcontext)); ?> 
    (<?php echo $rpm->getDistrelease()->getName() ?>, 
     <?php echo $rpm->getArch()->getName()?> media, 
     <?php echo $rpm->getMedia()->getName()?>)
  </li>
  <?php endforeach; ?>
</ul>
</div>
<br/>
<h2>Screenshot</h2>
(from <a href="http://screenshots.debian.net">http://screenshots.debian.net</a>)
<br/>
<a rel="screenshots" href="http://screenshots.debian.net/screenshot/<?php echo $package->getName() ?>">
  <img src="http://screenshots.debian.net/thumbnail/<?php echo $package->getName() ?>" />
</a>

<br/>
<br/>
<!--  <h2>Backport requests</h2> -->
<?php if ($sf_user->isAuthenticated()): ?>
  <a href="#" id="packageSubscribe">Subscribe to this package's news</a>

  <div id="subscribeForm" title="Subscribe to changes for this package">
  Select the type of changes for which you want to be notified, and if needed restrict the subscription to one or several distribution versions, archs and/or medias.
  <br/>
  <br/>
  <form>
  
  <?php $formField = $subscribe_form['type']?>
  <?php echo $formField->renderLabel() ?>
  <?php echo $formField->render() ?>
  <?php $filterValues = $types; ?>
  <?php $values = $formField->getValue() ?>
  <?php if (!empty($values)): ?>
  <?php $displayed_values = array() ?>
  <?php foreach ($values as $value) {$displayed_values[] = $filterValues[$value];} ?>
    <span class='filtervalues'><?php echo implode(', ', $displayed_values); ?></span>
  <?php else : ?>
    <span class='filtervalues'>All</span>
  <?php endif; ?>  
  <br style="clear:both;"/>
  <br/>
  
  <?php foreach (array('distrelease', 'arch', 'media') as $fieldName) : ?>
  <?php $formField = $subscribe_form[$fieldName]?>
  <?php echo $formField->renderLabel() ?>
  <?php echo $formField->render() ?>
  <?php $filterFactory = new filterFactory(); ?>
  <?php $filter = $filterFactory->create($formField->getName()); ?>
  <?php $filterValues = $filter->getValues(); ?>
  <?php $values = $formField->getValue() ?>
  <?php if (!empty($values)): ?>
  <?php $displayed_values = array() ?>
  <?php foreach ($values as $value) {$displayed_values[] = $filterValues[$value];} ?>
    <span class='filtervalues'><?php echo implode(', ', $displayed_values); ?></span>
  <?php else : ?>
    <span class='filtervalues'>All</span>
  <?php endif; ?>  
  <br style="clear:both;"/>
  <br/>
  <?php endforeach;?>

  </form>
  </div>
<?php endif; ?>
