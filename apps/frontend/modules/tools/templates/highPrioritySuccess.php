<?php slot('title', 'High Priority Bugs') ?>
<?php slot('name') ?>
High Priority Bugs for next release, except those already having a milestone set.
<?php end_slot('name') ?>
<p>This page lists all bug reports that have been marked with a high priority (except bugs with a milestone, which are already present in the "Intended for..." page).
The <strong>bug watcher</strong>
(QA contact field in bugzilla) is someone who commits to update the <strong>bug status comment</strong>
regularly and tries to get a status from the packagers involved and remind them about the bug if needed.
<strong>Anyone</strong> can be bug watcher.</p>
<br/><p><em>Total:
<?php  echo link_to($total, $base_url); ?>.<br/>
In the last two weeks:
<?php echo link_to($nb_created, $url_created) ?> created and <?php echo link_to($nb_promoted, $url_promoted) ?> promoted.
<?php echo link_to($nb_closed, $url_closed) ?> closed and <?php echo link_to($nb_demoted, $url_demoted) ?> demoted.
</em></p>
<br/>
<?php foreach ($sorted_assignees as $assignee):?>
  <h2><?php echo $assignee; ?></h2>
  <table class='buglist'>
    <thead>
    <tr>
      <th style="width:7%">Bug number</th>
      <th style="width:40%">Summary</th>
      <th style="width:10%">Bug Watcher</th>
      <th style="width:28%">Status comment</th>
      <th style="width:7%">Status</th>
      <th style="width:7%">No action for</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($bugs[$assignee] as $bug): ?>
    <?php $id = $bug['bug_id'] ?>
    <tr>
      <td><?php echo link_to($id, 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
      <td style="text-align:left;"><?php
      echo link_to(
              substr($bug['summary'], 0, 100) . (strlen($bug['summary'])>100 ? "[...]" : ""),
              'https://bugs.mageia.org/show_bug.cgi?id=' . $id)
      ?></td>
      <td><?php echo $bug["qacontact"] ?></td>
      <td style="text-align:left;"><?php echo $bug["statuscomment"] ?></td>
      <td><?php echo $bug["status"] ?></td>
      <td><?php
      $date = new DateTime(substr($bug['changed'], 0, 10));
      echo $date->diff($now)->format("%a");
      ?> days</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <br/>
<?php endforeach; ?>

<?php use_helper('JavascriptBase') ?>
<?php echo javascript_tag() ?>
  $('#filtering-border').remove();
<?php end_javascript_tag() ?>