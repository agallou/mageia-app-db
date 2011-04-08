<h2>MADB Notification Feed</h2>
<h3><?php echo $feed->getName() ?></h3>
<?php echo link_to("Here must be link to updates or smthn like that but its: ".url_for("@homepage")." for now...","@homepage") ?><br>
    <ol>
<?php foreach ($rss as $item): ?>
    <li>
        <?php echo link_to($item->getPackage()->getName(),"user/rss") ?><br>
        <h5>New vesrion of rpm <?php echo $item->getName() ?> in Package <?php echo $item->getPackage()->getName() ?> on media <?php echo $item->getMedia()->getName() ?></h5>
    </li>
<?php endforeach; ?>
    </ol>