<h1>RPM list for <?php echo link_to("Bug $bugnum", $bugtracker->getUrlForBug($bugnum)) ?></h1>
<p>There are two types of matches: 
  <strong>exact matches</strong> (the exact SRPM name was found in the bug report) 
  and <strong>partial matches</strong> (SRPM name matched, but not version and/or release).</p>

<?php // $results[distro release][match type][arch][SRPM or RPM][media][name] = name ?>
<?php foreach ($results as $distrelease => $data1): ?>
<br/>
<h2><?php echo $distrelease ?></h2>
  <?php foreach ($data1 as $match_type => $data2): ?>
  <br/>
  <h3><?php echo "$match_type match" ?></h3>
<pre>
<?php
      foreach ($data2 as $arch => $data3) :
        echo "\n*** Arch: $arch ***\n";
        foreach ($data3 as $rpmtype => $data4) :
          foreach ($data4 as $media => $rpms) :
            echo "\n${rpmtype}s from '$media'\n";
            echo "========================\n";
            foreach ($rpms as $name => $name_again) :
              echo $name . "\n";
            endforeach;
          endforeach;
        endforeach;
      endforeach;
?>
</pre>
  <?php endforeach; ?>
<?php endforeach; ?>

<?php if (empty($results)) : ?>
<p>No RPM match.</p>
<?php endif; ?>


