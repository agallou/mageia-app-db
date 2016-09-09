<?php slot('title', 'Current Blockers') ?>
<?php slot('name') ?>
Current Blockers
<?php end_slot('name') ?>
<p></p>
<br />
<?php foreach ($bugs as $assignee => $assignee_bugs):?>
  <h2><?php echo $assignee; ?></h2>
  <table class='buglist'>
    <thead>
    <tr>
      <th style="width:7%">Bug number</th>
      <th style="width:44%">Summary</th>
      <th style="width:10%">Bug Watcher</th>
      <th style="width:32%">Status comment</th>
      <th style="width:7%">Status</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($assignee_bugs as $bug): ?>
    <?php $id = $bug['bug_id'] ?>
    <tr>
      <td><?php echo link_to($id, 'https://bugs.mageia.org/show_bug.cgi?id=' . $id) ?></td>
      <td style="text-align:left;"><?php
      echo link_to(
              substr($bug['summary'], 0, 100) . (strlen($bug['summary'])>100 ? "[...]" : ""),
              'https://bugs.mageia.org/show_bug.cgi?id=' . $id)
      ?></td>
      <td><?php echo $bug["qacontact"] ?></td>
      <td><?php echo $bug["statuscomment"] ?></td>
      <td><?php echo $bug["status"] ?></td>
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