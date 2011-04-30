<h2>MADB Notification Feed</h2>
<h3><?php echo $feed->getName() ?></h3>
<?php echo link_to("Mageia App DB Homepage","@homepage") ?><br>
    <ol>
<?php foreach ($rss as $item): ?>
    <li>
        <?php echo link_to($item->getPackage()->getName(),"package/show?media=".$item->getMedia()->getId()."&distrelease=".$item->getDistrelease()->getId()."&arch=".$item->getArch()->getId()."&source=".intval($item->getIsSource())."&application=".intval($item->getPackage()->getIsApplication())."&id=".$item->getPackage()->getId()) ?><br>
        <h5>Update in Package <?php echo $item->getPackage()->getName() ?> on media <?php echo $item->getMedia()->getName() ?></h5>
    </li>
<?php endforeach; ?>
    </ol>