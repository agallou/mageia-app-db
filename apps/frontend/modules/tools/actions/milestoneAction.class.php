<?php
class milestoneAction extends madbActions
{
  public function execute($request)
  {
    // This action is very Mageia-QA-specific, should be in a mageia-specific plugin
    $this->base_url = "https://bugs.mageia.org/buglist.cgi?priority=High&priority=Normal&priority=Low&columnlist=product%2Ccomponent%2Cbug_status%2Cshort_desc%2Cchangeddate%2Ccf_statuscomment%2Cqa_contact_realname%2Cpriority%2Cbug_severity%2Ccf_rpmpkg%2Cassigned_to_realname%2Cbug_id%2Cassigned_to&query_format=advanced&bug_status=NEW&bug_status=UNCONFIRMED&bug_status=ASSIGNED&bug_status=REOPENED&target_milestone=Mageia%206";
    $this->url_closed = "https://bugs.mageia.org/buglist.cgi?priority=High&priority=Normal&priority=Low&columnlist=product%2Ccomponent%2Cbug_status%2Cshort_desc%2Cchangeddate%2Ccf_statuscomment%2Cqa_contact_realname%2Cpriority%2Cbug_severity%2Ccf_rpmpkg%2Cassigned_to_realname%2Cbug_id%2Cassigned_to&chfieldto=Now&query_format=advanced&chfield=bug_status&chfieldfrom=2w&chfieldvalue=RESOLVED&bug_status=RESOLVED&bug_status=VERIFIED&target_milestone=Mageia%206";
    $param_created = "&chfield=%5BBug%20creation%5D&chfieldfrom=2w&chfieldto=Now";
    $this->url_created = $this->base_url . $param_created;
    $param_promoted = "&chfield=target_milestone&chfieldfrom=2w&chfieldvalue=Mageia%206&chfieldto=Now&f1=creation_ts&o1=lessthan&v1=2w";
    $this->url_promoted = $this->base_url . $param_promoted;
    $this->url_demoted = "https://bugs.mageia.org/buglist.cgi?priority=High&priority=Normal&priority=Low&j_top=AND_G&f1=target_milestone&columnlist=product%2Ccomponent%2Cbug_status%2Cshort_desc%2Cchangeddate%2Ccf_statuscomment%2Cqa_contact_realname%2Cpriority%2Cbug_severity%2Ccf_rpmpkg%2Cassigned_to_realname%2Cbug_id%2Cassigned_to&o1=changedfrom&o2=changedafter&chfieldto=Now&query_format=advanced&chfieldfrom=2w&f2=target_milestone&bug_status=NEW&bug_status=UNCONFIRMED&bug_status=ASSIGNED&bug_status=REOPENED&v1=Mageia%206&v2=2w";

    $param_csv = "&ctype=csv&human=1";

    // Too many hits on bugzilla, to be improved once we get access to database
    $this->nb_closed = count(explode("\n", file_get_contents($this->url_closed . $param_csv))) - 1;
    $this->nb_created = count(explode("\n", file_get_contents($this->url_created . $param_csv))) - 1;
    $this->nb_promoted = count(explode("\n", file_get_contents($this->url_promoted . $param_csv))) - 1;
    $this->nb_demoted = count(explode("\n", file_get_contents($this->url_demoted . $param_csv))) - 1;

    $csv = explode("\n", file_get_contents($this->base_url . $param_csv));
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
    $this->total = count($csv);
    foreach ($csv as $row)
    {
      $bug_array = str_getcsv($row);
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
