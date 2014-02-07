<?php
class updatesAction extends madbActions
{
  public function execute($request)
  {
    // This action is very Mageia-QA-specific, should be in a mageia-specific plugin
    
    // get the list of current updates candidates from bugzilla
    $url = "https://bugs.mageia.org/buglist.cgi?bug_status=REOPENED&bug_status=NEW&bug_status=ASSIGNED&bug_status=UNCONFIRMED&columnlist=bug_severity%2Cpriority%2Cop_sys%2Cassigned_to%2Cbug_status%2Cresolution%2Cshort_desc%2Cstatus_whiteboard%2Ckeywords%2Cversion%2Ccf_rpmpkg%2Ccomponent%2Cchangeddate&field0-0-0=assigned_to&field1-0-0=keywords&query_format=advanced&type0-0-0=substring&type1-0-0=notsubstring&value0-0-0=qa-bugs&value1-0-0=vali&ctype=csv";
    // search URL based on RPM name
    $this->search_url = "https://bugs.mageia.org/buglist.cgi?columnlist=version%2Cassigned_to%2Cbug_status%2Cresolution%2Cshort_desc%2Ccf_rpmpkg%2Cstatus_whiteboard&email1=qa-bugs%40ml.mageia.org&emailassigned_to1=1&emailcc1=1&emailtype1=substring&field0-0-0=cf_rpmpkg&field0-0-2=short_desc&product=Mageia&query_format=advanced&type0-0-0=substring&type0-0-1=substring&type0-0-2=substring&type0-0-3=matches&value0-0-0={{SEARCH}}&value0-0-1={{SEARCH}}&value0-0-2={{SEARCH}}&value0-0-3=%22{{SEARCH}}%22&order=bug_id%20DESC&query_based_on=";
    $this->procedure_search_url = "https://wiki.mageia.org/mw-en/index.php?title=Special%3ASearch&redirs=1&search={{SEARCH}}&fulltext=Search&ns102=1&redirs=1&title=Special%3ASearch&advanced=1&fulltext=Advanced+search";
    $updates_csv = explode("\n", file_get_contents($url));
    $rank['bug_id'] = 0;
    $rank['severity'] = 1;
    $rank['summary'] = 7;
    $rank['whiteboard'] = 8;
    $rank['version'] = 10;
    $rank['RPM'] = 11;
    $rank['component'] = 12;
    $rank['changed'] = 13;
    
    
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
      preg_match_all('/\bmga(.)/', $update[$rank['summary']], $matches); 
      if (!empty($matches[1]))
      {
        foreach ($matches[1] as $version)
        {
          $versions[$version] = $version; 
        }
      }
      // 3) from whiteboard
      $matches = array();
      preg_match_all('/\bMGA(.)TOO/', $update[$rank['whiteboard']], $matches); 
      if (!empty($matches[1]))
      {
        foreach ($matches[1] as $version)
        {
          $versions[$version] = $version; 
        }
      }
      ksort($versions);
      
      // Get testing status for each version and arch
      $testing_status = array();
      foreach ($versions as $version)
      {
        $testing_status[$version] = array();
        // tested
        $matches = array();
        preg_match_all('/MGA'.$version.'-([^-]+)-OK\b/i', $update[$rank['whiteboard']], $matches); 
        if (!empty($matches[1]))
        {
          foreach ($matches[1] as $arch)
          {
            $testing_status[$version][$arch] = 1;
          }          
        }
        // tested, with some doubts
        $matches = array();
        preg_match_all('/MGA'.$version.'-([^-]+)-OK\?/i', $update[$rank['whiteboard']], $matches); 
        if (!empty($matches[1]))
        {
          foreach ($matches[1] as $arch)
          {
            $testing_status[$version][$arch] = 2;
          }          
        }
      }

      // for backports severity is low unless it's major or critical (bugfix or security fix to a backport)
      if ($update[$rank['component']] == 'Backports')
      {
        if (!in_array($update[$rank['severity']], array('major', 'critical')))
        {
          $update[$rank['severity']] = 'low';
        }
      }
      
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
          'whiteboard'      => $update[$rank['whiteboard']],
          'versions'        => $versions,
          'RPM'             => $update[$rank['RPM']],
          'has_procedure'   => strpos($update[$rank['whiteboard']], 'has_procedure') === false ? false : true,
          'testing_status'  => $testing_status,
          'component'       => $update[$rank['component']],
          'severity'        => $update[$rank['severity']],
          'severity_weight' => $severity_weight,
          'changed'         => $update[$rank['changed']],
          'feedback'        => strpos($update[$rank['whiteboard']], 'feedback') === false ? false : true,
          'source_package'  => $update[$rank['RPM']] 
                               ? ($source_package = PackagePeer::retrieveSourcePackageFromString($update[$rank['RPM']], false))
                                 ? $source_package
                                 : PackagePeer::stripVersionFromName($update[$rank['RPM']])
                               : false,
          'has_advisory'    => strpos($update[$rank['whiteboard']], 'advisory') === false ? false : true
      );      
    }
    $this->updates_by_version = array();
    foreach ($updates as $id => $update)
    {
      if ($update['component'] == 'Security')
      {
        $type = 'security';
      }
      elseif ($update['component'] == 'Backports')
      {
        $type = "backport";
      }
      elseif ($update['severity'] == 'enhancement')
      {
        $type = 'enhancement';
      }
      else
      {
        $type = 'bugfix';
      }

      foreach($update['versions'] as $version)
      {
        $this->updates_by_version[$version][$type][$id] = $id;
      }
    }
    ksort($this->updates_by_version);
    foreach ($this->updates_by_version as $version => $values)
    {
      foreach ($values as $type => $ids)
      {
        ksort($this->updates_by_version[$version][$type]);
        if ($type == 'security')
        {
          // sort security updates by severity
          $updates_by_severity = array();
          foreach ($this->updates_by_version[$version][$type] as $id)
          {
            if (!isset($updates_by_severity[$updates[$id]['severity_weight']]))
            {
              $updates_by_severity[$updates[$id]['severity_weight']] = array();
            }
            $updates_by_severity[$updates[$id]['severity_weight']][] = $id;
          }
          krsort($updates_by_severity);
          $this->updates_by_version[$version][$type] = array();
          foreach ($updates_by_severity as $severity_weight => $ids)
          {
            foreach ($ids as $id)
            {
              $this->updates_by_version[$version][$type][$id] = $id;
            }
          }
        }
      }
    }
    
    $this->archs = array('32' => '32', '64' => '64');
    foreach ($updates as $update)
    {
      foreach($update['testing_status'] as $statuses)
      {
        foreach ($statuses as $arch => $status)
        {
          $this->archs[$arch] = $arch;            
        }
      }
    }
    ksort($this->archs);

    $this->updates = $updates;
    $this->now = new DateTime();
  }
}
