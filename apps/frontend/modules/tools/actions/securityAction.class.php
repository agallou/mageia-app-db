<?php
class securityAction extends madbActions
{
  public function execute($request)
  {
    // This action is very Mageia-QA-specific, should be in a mageia-specific plugin

    // get the list of current security issues from bugzilla
    $url = "https://bugs.mageia.org/buglist.cgi?bug_status=NEW&bug_status=UNCONFIRMED&bug_status=ASSIGNED&bug_status=REOPENED&columnlist=bug_severity%2Cpriority%2Cop_sys%2Cassigned_to%2Cbug_status%2Cresolution%2Cshort_desc%2Cstatus_whiteboard%2Ckeywords%2Cversion%2Ccf_rpmpkg%2Ccomponent%2Cchangeddate%2Copendate&component=Security";
    $param_csv = "&ctype=csv&human=1";

    // search URL based on RPM name
    $updates_csv = explode("\n", file_get_contents($url . $param_csv));
    $rank['bug_id'] = 0;
    $rank['severity'] = 1;
    $rank['summary'] = 7;
    $rank['whiteboard'] = 8;
    $rank['keywords'] = 9;
    $rank['version'] = 10;
    $rank['RPM'] = 11;
    $rank['component'] = 12;
    $rank['changed'] = 13;
    $rank['created'] = 14;

    $updates = array();
    unset($updates_csv[0]);
    foreach ($updates_csv as $row)
    {
      $update = str_getcsv($row);
      // Find target versions
      $versions = array();
      // 1) from version field
      $versions[$update[$rank['version']]] = $update[$rank['version']];
      // 2) from summary
      $matches = array();
      preg_match_all('/\bmga([0-9]+)\b/', $update[$rank['summary']], $matches);
      if (!empty($matches[1]))
      {
        foreach ($matches[1] as $version)
        {
          $versions[$version] = $version;
        }
      }
      // 3) from whiteboard
      $matches = array();
      preg_match_all('/\bMGA([0-9]+)TOO/', $update[$rank['whiteboard']], $matches);
      if (!empty($matches[1]))
      {
        foreach ($matches[1] as $version)
        {
          $versions[$version] = $version;
        }
      }
      ksort($versions);

      switch ($update[$rank['severity']])
      {
        case 'enhancement':
          $severity_weight = 0;
          break;
        case 'low':
          $severity_weight = 1;
          break;
        case 'major':
          $severity_weight = 3;
          break;
        case 'critical':
          $severity_weight = 4;
          break;
        default:
          $severity_weight = 2; // normal
          break;
      }

      $updates[$update[$rank['bug_id']]] = array(
          'summary'         => $update[$rank['summary']],
          'versions'        => $versions,
          'RPM'             => $update[$rank['RPM']],
          'severity'        => $update[$rank['severity']],
          'severity_weight' => $severity_weight,
          'changed'         => $update[$rank['changed']],
          'created'         => substr($update[$rank['created']], 0, 10)
      );
    }
    $this->updates_by_version = array();
    foreach ($updates as $id => $update)
    {
      foreach($update['versions'] as $version)
      {
        $this->updates_by_version[$version][$id] = $id;
      }
    }
    ksort($this->updates_by_version);
    foreach ($this->updates_by_version as $version => $values)
    {
      ksort($this->updates_by_version[$version]);
      // sort security updates by severity
      $updates_by_severity = array();
      foreach ($this->updates_by_version[$version] as $id)
      {
        if (!isset($updates_by_severity[$updates[$id]['severity_weight']]))
        {
          $updates_by_severity[$updates[$id]['severity_weight']] = array();
        }
        $updates_by_severity[$updates[$id]['severity_weight']][] = $id;
      }
      krsort($updates_by_severity);
      $this->updates_by_version[$version] = array();
      foreach ($updates_by_severity as $severity_weight => $ids)
      {
        foreach ($ids as $id)
        {
          $this->updates_by_version[$version][$id] = $id;
        }
      }
    }

    $this->updates = $updates;
    $this->now = new DateTime();
  }
}
