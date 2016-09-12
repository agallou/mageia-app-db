<?php
class blockersAction extends madbActions
{
  public function execute($request)
  {
    // This action is very Mageia-QA-specific, should be in a mageia-specific plugin

    $url = "https://bugs.mageia.org/buglist.cgi?bug_status=NEW&bug_status=UNCONFIRMED&bug_status=ASSIGNED&bug_status=REOPENED&columnlist=product%2Ccomponent%2Cbug_status%2Cshort_desc%2Cchangeddate%2Ccf_statuscomment%2Cqa_contact_realname%2Cpriority%2Cbug_severity%2Ccf_rpmpkg%2Cassigned_to_realname%2Cbug_id%2Cassigned_to&human=1&priority=release_blocker&query_format=advanced&ctype=csv&human=1";
    $csv = explode("\n", file_get_contents($url));
    $rank['bug_id'] = 0;
    $rank['product'] = 1;
    $rank['component'] = 2;
    $rank['status'] = 3;
    $rank['summary'] = 4;
    $rank['changed'] = 5;
    $rank['statuscomment'] = 6;
    $rank['qacontact'] = 7;
    $rank['priority'] = 8;
    $rank['severity'] = 9;
    $rank['sourcerpm'] = 10;
    $rank['assigneename'] = 11;
    $rank['assignee'] = 12;

    $bugs = array();
    unset($csv[0]);
    foreach ($csv as $row)
    {
      $bug_array = str_getcsv($row);
      //print_r($bug_array);
      $bug = array();
      foreach(array_keys($rank) as $key)
      {
        $bug[$key] = $bug_array[$rank[$key]];
      }
      $assigneename = $bug['assigneename'];
      if (!isset($bugs[$assigneename]))
      {
        $bugs[$assigneename] = array();
      }
      $bugs[$assigneename][$bug['bug_id']] = $bug;
    }
    $assignees = array_keys($bugs);
    $group_assignees = array();
    foreach ($assignees as $key => $assigneename)
    {
      foreach (array("team", "group", "packagers", "maintainers", "mageia") as $word)
      {
        if (stripos($assigneename, $word) !== false)
        {
            $group_assignees[] = $assigneename;
            unset($assignees[$key]);
            break;
        }
      }
      ksort($bugs[$assigneename]);
    }
    sort($assignees);
    sort($group_assignees);

    $this->sorted_assignees = array_merge($group_assignees, $assignees);
    $this->bugs = $bugs;
    $this->now = new DateTime();
  }
}
