<?xml version="1.0" encoding="ISO-8859-1" ?>
<rss version="2.0">
<chanell>
    <title><?php echo $feed->getName() ?></title>
    <link><?php echo url_for("@homepage") ?></link>
    <description>MADB Notification Feed</description>
<?php foreach ($rss as $item): ?>
    <item>
        <title><?php echo $item->getPackage()->getName() ?></title>
        <link>user/rss</link>
        <description>New update of rpm <?php echo $item->getName() ?> in Package <?php echo $item->getPackage()->getName() ?> on media <?php echo $item->getMedia()->getName() ?></description>
    </item>
<?php endforeach; ?>
</chanell>
</rss>