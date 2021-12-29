<?php slot('title', 'RPM list for Bug '.$bugnum) ?>
<?php slot('name') ?>
RPM list for <?php echo link_to("Bug $bugnum", $bugtracker->getUrlForBug($bugnum)) ?>
<?php end_slot('name') ?>

<div class='rpm'>

<h2>List of RPMs and SRPMs</h2>
  
<p>There are two types of matches: 
  <strong>exact matches</strong> (the exact SRPM name was found in the bug report) 
  and <strong>partial matches</strong> (SRPM name matched, but not version and/or release).</p>

<?php foreach ($results as $distrelease => $data1): ?>
  <br/>
  <h3><?php echo $distrelease ?></h3>
  <?php foreach ($data1 as $match_type => $data2): ?>
    <br/>
    <h4><?php echo "$match_type match" ?></h4>
    <pre>
<?php
foreach ($data2 as $arch => $data3) :
  echo "\n*** Arch: $arch ***\n";
  foreach ($data3 as $rpmtype => $data4) :
    foreach ($data4 as $media => $rpms) :
      echo "\n${rpmtype}s from '$media'\n";
      echo "========================\n";
      foreach ($rpms as $name => $rpm) :
        echo "[";
        echo link_to(
          'diff',
          $madburl->urlForRpm(
            $rpm,
            $madbcontext,
            array(
                 'moduleaction' => 'rpm/diff'
            )
          )
        );
        echo "] ";
        echo link_to(
          $name,
          $madburl->urlForRpm(
            $rpm,
            $madbcontext,
            array(
                 'moduleaction' => 'rpm/show'
            )
          )
        );
        echo "\n";
      endforeach;
    endforeach;
  endforeach;
endforeach;
?>
</pre>
  <?php endforeach; ?>
<?php endforeach; ?>

<br />
<h2>Same list, text-only.</h2>
<?php // $results[distro release][match type][arch][SRPM or RPM][media][name] = name ?>
<?php foreach ($results as $distrelease => $data1): ?>
<br/>
<h3><?php echo $distrelease ?></h3>
  <?php foreach ($data1 as $match_type => $data2): ?>
  <br/>
  <h4><?php echo "$match_type match" ?></h4>
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

</div>
  
<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
    var element = document.querySelector('#filtering-border');
    if (element) {
        element.parentNode.removeChild(element);
    }
<?php end_javascript_tag() ?>
