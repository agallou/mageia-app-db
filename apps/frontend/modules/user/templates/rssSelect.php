<h2 style="background: #F0B17C; border:1px solid sandybrown;">Select a feed (<font color="red">beta</font>):</h2>

<?php if($rssFeeds): ?>
<ul>
    <?php foreach($rssFeeds as $feed): ?>
    <li><?php echo link_to($feed->getName(), "user/rss?feed=".$feed->getId()) ?> - <font style="background: #ffff00; font-weight: bold;">description of the feed follows</font></li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
<p>You do not created any feed  yet. In order to use rss notification feature you should create some feeds and use it against notification.</p>
<?php endif; ?>