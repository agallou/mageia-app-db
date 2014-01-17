<?php
class listRpmsForQaBugAction extends madbActions
{
  public function execute($request)
  {
    // TODO: This action is very Mageia-QA-specific, should be in a mageia-specific plugin

    $this->forward404Unless($request->hasParameter('bugnum'));
    
    $bugnum = $request->getParameter('bugnum');
    // a defined parameter without a value returns true, hence the test on true
    if (!$bugnum or $bugnum === true)
    {
      $this->forward404();
    }
    $bugnum = (int) $bugnum;
    $this->bugnum = $bugnum;

    $bugtrackerFactory = new madbBugtrackerFactory();
    $this->bugtracker = $bugtrackerFactory->create();
    
    $this->results = array(); // $results[distro release][match type][arch][SRPM or RPM][media][name] = name
    
    // *** exact match ***
    $match_types = array(
      'exact' => array(
        madbBugtrackerMageia::MATCH_EXACT_ASSIGNED_TO_QA, 
        madbBugtrackerMageia::MATCH_EXACT_NO_QA,
        madbBugtrackerMageia::MATCH_EXACT_QA_CC
      ),
      'partial' => array(
        madbBugtrackerMageia::MATCH_PARTIAL_ASSIGNED_TO_QA,
        madbBugtrackerMageia::MATCH_PARTIAL_NO_QA,
        madbBugtrackerMageia::MATCH_PARTIAL_QA_CC          
      )
    );
    
    foreach (array('exact', 'partial') as $match_type)
    {
      // get SRPMs for this bug number. Exact matches.
      $srpms = RpmPeer::retrieveByBugNumber($bugnum, $match_types[$match_type]);

      // then the RPMs
      foreach ($srpms as $srpm)
      {
        $distrelease = $srpm->getDistrelease()->getDisplayedName();
        $arch = $srpm->getArch()->getName();

        $this->results[$distrelease][$match_type][$arch]['SRPM'][$srpm->getMedia()->getName()][$srpm->getName()] = $srpm;
        foreach ($srpm->getRpmsRelatedById() as $rpm)
        {
          $this->results[$distrelease][$match_type][$arch]['RPM'][$rpm->getMedia()->getName()][$rpm->getName()] = $rpm;
        }
      }      
    }
    
    ksort($this->results);
    foreach ($this->results as $distrelease => $data1)
    {
      ksort($this->results[$distrelease]);
      foreach ($data1 as $match_type => $data2)
      {
        ksort($this->results[$distrelease][$match_type]);
        foreach ($data2 as $arch => $data3)
        {
          ksort($this->results[$distrelease][$match_type][$arch]);
          foreach ($data3 as $rpmtype => $data4)
          {
            ksort($this->results[$distrelease][$match_type][$arch][$rpmtype]);
            foreach ($data4 as $media => $rpms)
            {
              ksort($this->results[$distrelease][$match_type][$arch][$rpmtype][$media]);
            }
          }
        }
      }
    }
  }
}
