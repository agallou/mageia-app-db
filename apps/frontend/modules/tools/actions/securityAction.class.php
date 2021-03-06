<?php
class securityAction extends madbActions
{
  public function execute($request)
  {
    // This action is very Mageia-QA-specific, should be in a mageia-specific plugin

    $this->search_url = "https://bugs.mageia.org/buglist.cgi?columnlist=version%2Cassigned_to%2Cbug_status%2Cresolution%2Cshort_desc%2Ccf_rpmpkg%2Cstatus_whiteboard&email1=qa-bugs%40ml.mageia.org&emailassigned_to1=1&emailcc1=1&emailtype1=substring&field0-0-0=cf_rpmpkg&field0-0-2=short_desc&product=Mageia&query_format=advanced&type0-0-0=substring&type0-0-1=substring&type0-0-2=substring&type0-0-3=matches&value0-0-0={{SEARCH}}&value0-0-1={{SEARCH}}&value0-0-2={{SEARCH}}&value0-0-3=%22{{SEARCH}}%22&order=bug_id%20DESC&query_based_on=";

    // get the list of current security issues from bugzilla
    $url = "https://bugs.mageia.org/buglist.cgi?bug_status=NEW&bug_status=UNCONFIRMED&bug_status=ASSIGNED&bug_status=REOPENED&columnlist=bug_severity%2Cpriority%2Cop_sys%2Cassigned_to%2Cbug_status%2Cresolution%2Cshort_desc%2Cstatus_whiteboard%2Ckeywords%2Cversion%2Ccf_rpmpkg%2Ccomponent%2Cchangeddate%2Copendate%2Ccf_statuscomment%2Cassigned_to_realname&component=Security&email1=qa-bugs&emailassigned_to1=1&emailtype1=notsubstring&query_format=advanced&query_based_on=";
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
    $rank['statuscomment'] = 15;
    $rank['assigneename'] = 16;

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

      $updates[$update[$rank['bug_id']]] = array(
          'summary'         => $update[$rank['summary']],
          'versions'        => $versions,
          'RPM'             => $update[$rank['RPM']],
          'severity'        => $update[$rank['severity']],
          'changed'         => $update[$rank['changed']],
          'created'         => substr($update[$rank['created']], 0, 10),
          'statuscomment'   => $update[$rank['statuscomment']],
          'assigneename'    => $update[$rank['assigneename']],
          'source_package'  => $update[$rank['RPM']]
                               ? ($source_package = PackagePeer::retrieveSourcePackageFromString($update[$rank['RPM']], false))
                                 ? $source_package
                                 : PackagePeer::stripVersionFromName($update[$rank['RPM']])
                               : false,
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
    }

    $this->updates = $updates;
    $this->now = new DateTime();
  }
}
