<?xml version="1.0" encoding="ISO-8859-1" ?>
<rss version="2.0">
<channel>
  <title><?php echo $feed->getName() ?></title>
  <link><?php echo url_for("@homepage") ?></link>
  <description>MADB Notification Feed</description>
<?php foreach ($rss as $item): ?>
  <item>
    <title><?php echo $item->getPackage()->getName() ?></title>
    <link><?php url_for("package/show?media=".$item->getMedia()->getId()."&distrelease=".$item->getDistrelease()->getId()."&arch=".$item->getArch()->getId()."&source=".intval($item->getIsSource())."&application=".intval($item->getPackage()->getIsApplication())."&id=".$item->getPackage()->getId()) ?></link>
    <description>Update in Package <?php echo $item->getPackage()->getName() ?> on media <?php echo $item->getMedia()->getName() ?></description>
  </item>
<?php endforeach; ?>
</channel>
</rss>
