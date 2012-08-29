<?php
class madbMatchRpmsAndBugsTask extends madbBaseTask
{

  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'match-rpms';
    $this->addOption('limit', null, sfCommandOption::PARAMETER_REQUIRED, 'max number of rpms to match', null);
    $this->addOption('all', null, sfCommandOption::PARAMETER_NONE, 'add this option to match all updates and backports, not only testing ones', null);
  }
  protected function execute($arguments = array(), $options = array())
  {
    // TODO make it less mageia specific?
    
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    $con = Propel::getConnection();
    Propel::disableInstancePooling();

    $madbConfig = new madbConfig();
    $madbDistroConfigFactory = new madbDistroConfigFactory();
    $madbDistroConfig = $madbDistroConfigFactory->getCurrentDistroConfig($madbConfig);
    
    // check config file validity (TODO : make it an actual check !)
    if (!$madbDistroConfig->check())
    {
      throw new madbException("Invalid distro configuration file'");
    }
    
    $distribution = $madbDistroConfig->getName();
    
    // Match only if there's a bugtracker distro-specific class existing in madb
    $bugtrackerFactory = new madbBugtrackerFactory();
    $bugtracker = $bugtrackerFactory->create();
    if (!$bugtracker)
    {
      throw new madbException("No bug tracker handling class found for distribution $distribution.");
    }

    // Select source RPMs
    $criteria = new Criteria();
    $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
    $criteria->add(RpmPeer::IS_SOURCE, true);
    if (!$options['all'])
    {
      $criteria->add(MediaPeer::IS_TESTING, true);
    }
    else
    {
      $criterion = $criteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
      $criterion->addOr($criteria->getNewCriterion(MediaPeer::IS_BACKPORTS, true));
      $criteria->add($criterion);
    }
    $criteria->addAsColumn('column1', RpmPeer::NAME);
    $criteria->setDistinct('column1');
    $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
    $limit = (int) $options['limit'];
    if ($limit > 0)
    {
      $criteria->setLimit($limit);
    }
    
    $stmt = RpmPeer::doSelectStmt($criteria);
    foreach ($stmt as $row)
    {
      $name = $row['column1'];
      echo "$name: ";
      // match the source RPM with a bug report
      $start = microtime(true);
      $match = $bugtracker->findBugForUpdateCandidate($name, true);
      $duration = round(microtime(true) - $start, 1);
      if ($match)
      {
        list($bug_number, $match_type) = $match;
        echo "$bug_number - " . $bugtracker->getLabelForMatchType($match_type);
        $criteria = new Criteria();
        $criteria->add(RpmPeer::NAME, $name);
        foreach (RpmPeer::doSelect($criteria) as $rpm)
        {
          $rpm->setBugNumber($bug_number);
          $rpm->setBugMatchType($match_type);
          $rpm->save();
          $rpm->clearAllReferences(true);
        }
      }
      else
      {
        echo "not found";
      }
      echo " (${duration}s).\n";
    }
  }
}
