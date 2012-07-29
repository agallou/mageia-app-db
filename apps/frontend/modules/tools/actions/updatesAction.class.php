<?php
class updatesAction extends madbActions
{
  public function execute($request)
  {
    // This action is very Mageia-QA-specific, should be in a mageia-specific plugin
    
    // get the list of current updates candidates from bugzilla
    $url = "https://bugs.mageia.org/buglist.cgi?bug_status=REOPENED&bug_status=NEW&bug_status=ASSIGNED&bug_status=UNCONFIRMED&columnlist=bug_severity%2Cpriority%2Cop_sys%2Cassigned_to%2Cbug_status%2Cresolution%2Cshort_desc%2Cstatus_whiteboard%2Ckeywords%2Cversion%2Ccf_rpmpkg&field0-0-0=assigned_to&field1-0-0=keywords&query_format=advanced&type0-0-0=substring&type1-0-0=notsubstring&value0-0-0=qa-bugs&value1-0-0=vali&ctype=csv";
    $updates_csv = explode("\n", file_get_contents($url));
    $headers = $updates_csv[0];
    $rank['bug_id'] = 0;
    $rank['summary'] = 7;
    $rank['whiteboard'] = 8;
    $rank['version'] = 10;
    $rank['RPM'] = 11;
    
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
      
      $updates[$update[$rank['bug_id']]] = array(
          'summary'         => $update[$rank['summary']],
          'whiteboard'      => $update[$rank['whiteboard']],
          'versions'        => $versions,
          'RPM'             => $update[$rank['RPM']],
          'has_procedure'   => (bool) strpos($update[$rank['whiteboard']], 'has_procedure'),
          'testing_status'  => $testing_status 
      );
      
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
      
      $this->archs = array();
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
    }
  }
}
