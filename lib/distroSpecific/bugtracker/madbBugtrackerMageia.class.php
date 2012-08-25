<?php
class madbBugtrackerMageia extends baseMadbBugtracker
{
  const MATCH_EXACT_ASSIGNED_TO_QA = 1;
  const MATCH_EXACT_QA_CC = 2;
  const MATCH_EXACT_NO_QA = 3;
  const MATCH_PARTIAL_ASSIGNED_TO_QA = 4;
  const MATCH_PARTIAL_QA_CC = 5;
  const MATCH_PARTIAL_NO_QA = 6;

  public function getLabelForMatchType($type)
  {
    switch ($type)
    {
      case self::MATCH_EXACT_ASSIGNED_TO_QA:
        return "QA";
      case self::MATCH_EXACT_QA_CC:
        return "QA in CC";
      case self::MATCH_EXACT_NO_QA:
        return "no QA";
      case self::MATCH_PARTIAL_ASSIGNED_TO_QA:
        return "partial match, QA";
      case self::MATCH_PARTIAL_QA_CC:
        return "partial match, QA in CC";
      case self::MATCH_PARTIAL_NO_QA:
        return "unsure";
      default:
        return $type;
    }
  }
  
  public function findBugForUpdateCandidate($name, $full=false)
  {
    $name = str_replace('.src.rpm', '', $name);
    // FIXME: URLs should be in a config file
    
    // CSV format : bug id, assignee, status
    
    // *** RPM field, summary, content or comments, exact match, only open bugs assigned to QA or with QA as CC ***
    $url = "https://bugs.mageia.org/buglist.cgi?bug_status=NEW&bug_status=ASSIGNED&bug_status=REOPENED&columnlist=assigned_to%2Cbug_status&email1=qa-bugs%40ml.mageia.org&emailassigned_to1=1&emailcc1=1&emailtype1=substring&field0-0-0=content&field0-0-1=short_desc&field0-0-2=longdesc&field0-0-3=cf_rpmpkg&product=Mageia&query_format=advanced&type0-0-0=matches&type0-0-1=substring&type0-0-2=substring&type0-0-3=substring&value0-0-0={{SEARCH}}&value0-0-1={{SEARCH}}&value0-0-2={{SEARCH}}&value0-0-3={{SEARCH}}&ctype=csv";
    $url = str_replace('{{SEARCH}}', $name, $url);
    $csv = explode("\n", file_get_contents($url));
    if (isset($csv[1]))
    {
      unset ($csv[0]);
      foreach ($csv as $row)
      {
        $row = str_getcsv($row);
        if ($row[1] == 'qa-bugs')
        {
          return array($row[0], self::MATCH_EXACT_ASSIGNED_TO_QA);
        }
      }
      return array($row[0], self::MATCH_EXACT_QA_CC);
    }
    
    // *** RPM field, match stripped RPM name, only open bugs assigned to QA or with QA as CC ***
    $stripped_name = PackagePeer::stripVersionFromName($name);
    $url = "https://bugs.mageia.org/buglist.cgi?bug_status=NEW&bug_status=ASSIGNED&bug_status=REOPENED&columnlist=assigned_to%2Cbug_status&email1=qa-bugs%40ml.mageia.org&emailassigned_to1=1&emailcc1=1&emailtype1=substring&field0-0-0=cf_rpmpkg&product=Mageia&query_format=advanced&type0-0-0=substring&value0-0-0={{SEARCH}}&ctype=csv";
    $url = str_replace('{{SEARCH}}', $stripped_name, $url);
    $csv = explode("\n", file_get_contents($url));
    if (isset($csv[1]))
    {
      unset ($csv[0]);
      foreach ($csv as $row)
      {
        $row = str_getcsv($row);
        if ($row[1] == 'qa-bugs')
        {
          return array($row[0], self::MATCH_PARTIAL_ASSIGNED_TO_QA);
        }
      }
      return array($row[0], self::MATCH_PARTIAL_QA_CC);
    }
    
    if ($full)
    {
      // *** RPM field, summary, content or comments, exact match, only open bugs ***
      $url = "https://bugs.mageia.org/buglist.cgi?bug_status=NEW&bug_status=ASSIGNED&bug_status=REOPENED&columnlist=assigned_to%2Cbug_status&field0-0-0=content&field0-0-1=short_desc&field0-0-2=longdesc&field0-0-3=cf_rpmpkg&product=Mageia&query_format=advanced&type0-0-0=matches&type0-0-1=substring&type0-0-2=substring&type0-0-3=substring&value0-0-0={{SEARCH}}&value0-0-1={{SEARCH}}&value0-0-2={{SEARCH}}&value0-0-3={{SEARCH}}&ctype=csv";
      $url = str_replace('{{SEARCH}}', $name, $url);
      $csv = explode("\n", file_get_contents($url));
      if (isset($csv[1]))
      {
        $row = str_getcsv($csv[1]);
        return array($row[0], self::MATCH_EXACT_NO_QA);
      }
    }
    
    return false;
  }
  
  public function getUrlForBug($number)
  {
    return "https://bugs.mageia.org/show_bug.cgi?id=" . $number;
  }
}
