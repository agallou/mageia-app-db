<?php
class comparisonAction extends madbActions
{
  public function execute($request)
  {
    /*
    if ($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
    }
    else
    {
      $page = 1;
    }*/
    
    $keyvalue = $this->madbcontext->getRealFilterValue('release');
    $distrelease = DistreleasePeer::retrieveByName(array_shift($keyvalue));
    
    if (!$distrelease or !$distrelease->getRealDistrelease())
    {
      $this->message = "There is no data for this release.";
      return 'Error';
    }
    $this->distrelease = $distrelease;
    if ($distrelease->getIsDevVersion())
    {
      $this->message = "There is no higher release to compare " . $distrelease->getDisplayedName() . " with.";
      return 'Error';
    }
    
    // Target second release for comparison : dev release if none defined, 'withrelease' if defined
    if ($request->hasParameter('withrelease'))
    {
      if ($target_release = DistreleasePeer::retrieveByName($request->getParameter('withrelease')))
      {
        $this->targetRelease = $target_release;
        $this->target_release = $request->getParameter('withrelease');
      }
      else
      {
        $this->message = "Unknown release '" . $request->getParameter('withrelease') . "'. Check (or remove) the withrelease parameter.";
        return 'Error';
      }
    }
    else
    {
      if ($target_release = DistreleasePeer::getDevel())
      {
        $this->targetRelease = $target_release;
        $this->target_release = $target_release->getName();
      }
      else
      {
        $this->message = "There is no development version to compare " . $distrelease->getDisplayedName() . " with.";
        return 'Error';
      }
    }
    
    // Parameters:
    if ($request->hasParameter('comptype'))
    {
      $this->show_added = false;
      $this->show_updated = false;
      $this->show_backported = false;
      $this->show_older = false;
      $this->show_newer_avail = false;
      foreach (explode('|', $request->getParameter('comptype')) as $type)
      {
        switch ($type)
        {
          case 'added':
            $this->show_added=true;
            break;
          case 'updated':
            $this->show_updated=true;
            break;
          case 'backported':
            $this->show_backported=true;
            break;
          case 'older':
            $this->show_older=true;
            break;
          case 'newer_avail':
            $this->show_newer_avail=true;
            break;
          default:
            break;
        }
      }
    }
    else
    {
      $this->show_added = true;
      $this->show_updated = true;
      $this->show_backported = true;
      $this->show_older = true;
      $this->show_newer_avail = true;
    }
    
    $exclude_testing = false;
    if ($request->getParameter('exclude_testing') == 1)
    {
      $exclude_testing = true;
    }
    $exclude_backports = false;
    if ($request->getParameter('exclude_backports') == 1)
    {
      $exclude_backports = true;
    }
    
    $con = Propel::getConnection();
    $databaseFactory = new databaseFactory();
    $database = $databaseFactory->createDefault();
    
    // Available versions outside from Mageia
    $tablename_available = 'tmp_available';
    $sql = <<<EOF
CREATE TEMPORARY TABLE $tablename_available (
  package_id INT PRIMARY KEY,
  available VARCHAR(255),
  source VARCHAR(255)
);
EOF;
    $con->exec($sql);    
    
    if ($this->show_newer_avail)
    {
      $tablename_available_raw = 'tmp_available_raw';
      $sql = <<<EOF
CREATE TEMPORARY TABLE $tablename_available_raw (
  src_package VARCHAR(255) PRIMARY KEY,
  available VARCHAR(255),
  source VARCHAR(255)
);
EOF;
      $con->exec($sql);
      
      $available_versions = $this->getYouriVersions();
      if ($available_versions)
      {
        $i=0;
        foreach ($available_versions as $row)
        {
          if ($i == 1000)
          {
            $con->exec(rtrim($sql, ','));
            $i=0;
          }
          if ($i == 0)
          {
            $sql = "INSERT INTO $tablename_available_raw (src_package, available, source) VALUES ";
          }
          $sql .= "('$row[0]', '$row[1]', '$row[2]'),";
          $i++;
        }
        $con->exec(rtrim($sql, ',')); 
      }
    
      // Find source packages and binary packages corresponding to the source_packages having a newer available version
      // Add them to $tablename_available
      $sql = <<<EOF
INSERT INTO $tablename_available (package_id, available, source)
SELECT sp.id, t.available, t.source
FROM $tablename_available_raw t 
     JOIN package sp ON (sp.name=t.src_package AND sp.is_source=TRUE);
EOF;
      $con->exec($sql);

      try
      {
        $sql = <<<EOF
INSERT INTO $tablename_available (package_id, available, source)
SELECT DISTINCT bp.id, t.available, t.source
FROM $tablename_available_raw t
     JOIN package sp ON (sp.name=t.src_package AND sp.is_source=TRUE)
     JOIN rpm sr ON sr.package_id=sp.id
     JOIN rpm br ON br.source_rpm_id=sr.id
     JOIN package bp ON br.package_id=bp.id
EOF;
        $con->exec($sql);
      }
      catch (PDOException $e)
      {
        // do nothing, this is a way to emulate INSERT IGNORE
      }
    }
      
    
    // Get packages corresponding to current filters but for the second release (dev or 'withrelease')
    $criteria = $this->getCriteria(filterPerimeters::PACKAGE);
    $criteria->addJoin(PackagePeer::ID, "$tablename_available.package_id", Criteria::LEFT_JOIN);
    $criteria->addJoin(PackagePeer::ID, RpmPeer::PACKAGE_ID);
    $criteria->add(RpmPeer::DISTRELEASE_ID, $target_release->getId());
    $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
    if ($exclude_testing)
    {
      $criteria->add(MediaPeer::IS_TESTING, false);
    }
    $criteria->add(MediaPeer::IS_THIRD_PARTY, false);
    if ($exclude_backports)
    {
      $criteria->add(MediaPeer::IS_BACKPORTS, false);
    }
    
    $criteria->clearSelectColumns();
    $criteria->addAsColumn('id', PackagePeer::ID);
    $criteria->addAsColumn('name', PackagePeer::NAME);
    $criteria->addAsColumn('summary', PackagePeer::SUMMARY);
    // FIXME : MAX is not accurate for RPM version
    $criteria->addAsColumn('dev_version', 'MAX('.RpmPeer::VERSION.')');
    $criteria->addAsColumn('available', "$tablename_available.available");
    $criteria->addAsColumn('source', "$tablename_available.source");
    // group by in case the package has several versions in the target release
    $criteria->addGroupByColumn(PackagePeer::ID);
    $criteria->addGroupByColumn(PackagePeer::NAME);
    $criteria->addGroupByColumn(PackagePeer::SUMMARY);
    $criteria->addGroupByColumn("$tablename_available.available");
    $criteria->addGroupByColumn("$tablename_available.source");
    
    $tablename = 'tmp_package';
    $database->createTableFromCriteria($criteria, $tablename);
    
    $sql = <<<EOF
ALTER TABLE $tablename ADD PRIMARY KEY (ID),
ADD update_version VARCHAR(255) NULL,
ADD update_testing_version VARCHAR(255) NULL,
ADD backport_version VARCHAR(255) NULL,
ADD backport_testing_version VARCHAR(255) NULL;
EOF;
    $con->exec($sql);   

    // Get packages from the selected stable distrelease
    foreach (array('release', 'update', 'update_testing', 'backport', 'backport_testing') as $media_type)
    {
      $criteria = $this->getCriteria(filterPerimeters::RPM);
      $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
      
      switch ($media_type)
      {
        case 'release':
          $criteria->add(MediaPeer::IS_UPDATES, false);
          $criteria->add(MediaPeer::IS_BACKPORTS, false);
          $media_type = 'update';
          break;
        case 'update':
          $criteria->add(MediaPeer::IS_UPDATES, true);
          $criteria->add(MediaPeer::IS_TESTING, false);
          break;
        case 'update_testing':
          $criteria->add(MediaPeer::IS_UPDATES, true);
          $criteria->add(MediaPeer::IS_TESTING, true);
          break;
        case 'backport':
          $criteria->add(MediaPeer::IS_BACKPORTS, true);
          $criteria->add(MediaPeer::IS_TESTING, false);
          break;
        case 'backport_testing':
          $criteria->add(MediaPeer::IS_BACKPORTS, true);
          $criteria->add(MediaPeer::IS_TESTING, true);
          break;
        default: 
          throw new madbException("Invalid media type : $media_type");
      }
      
      $criteria->clearSelectColumns();
      $criteria->addAsColumn('package_id', RpmPeer::PACKAGE_ID);
      $criteria->addAsColumn('version', RpmPeer::VERSION);
      // If there are several RPMs in updates media or any other media, take the most recently built
      // We do that with an order by, so that the more recent updates the table the last
      $criteria->addAscendingOrderByColumn(RpmPeer::BUILD_TIME);
      $stmt = BasePeer::doSelect($criteria);
      
      $fieldname = $media_type . "_version";
      
      $con->beginTransaction();
      foreach ($stmt as $row)
      {
        $sql = <<<EOF
UPDATE $tablename
SET $fieldname = '$row[version]'
WHERE id = $row[package_id];
EOF;
        $con->exec($sql);
      }
      $con->commit();
    } 
    
    if ($this->show_added)
    {
      // Add new packages from the development release to the list
      $dev_context = $this->getMadbContext();
      // FIXME : cleaner modification of the distrelease filter
      $dev_context->getParameterHolder()->set('release', $target_release->getName());
      $criteriaFactory = new criteriaFactory();
      $criteria = $criteriaFactory->createFromContext($dev_context, filterPerimeters::RPM);
      $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
      $criteria->addJoin(RpmPeer::PACKAGE_ID, PackagePeer::ID);
      $criteria->addJoin(PackagePeer::ID, "$tablename_available.package_id", Criteria::LEFT_JOIN);
      if ($exclude_testing)
      {
        $criteria->add(MediaPeer::IS_TESTING, false);
      }        
      if ($exclude_backports)
      {
        $criteria->add(MediaPeer::IS_BACKPORTS, false);
      }
      $criteria->add(MediaPeer::IS_THIRD_PARTY, false);
  
      $criteria->clearSelectColumns();
      $criteria->addAsColumn('id', PackagePeer::ID);
      $criteria->addAsColumn('name', PackagePeer::NAME);
      $criteria->addAsColumn('summary', PackagePeer::SUMMARY);
      $criteria->addAsColumn('dev_version', 'MAX('.RpmPeer::VERSION.')');
      $criteria->addAsColumn('available', "$tablename_available.available");
      $criteria->addAsColumn('source', "$tablename_available.source");
      // group by just in case the dev release has several versions
      $criteria->addGroupByColumn(PackagePeer::ID);
      $criteria->addGroupByColumn(PackagePeer::NAME);
      $criteria->addGroupByColumn(PackagePeer::SUMMARY);
      $criteria->addGroupByColumn("$tablename_available.available");
      $criteria->addGroupByColumn("$tablename_available.source");


      $stmt = BasePeer::doSelect($criteria);
      $con->beginTransaction();
      foreach ($stmt as $row)
      {
        // first check that it's not already in the table
        // because postgresql doesn't handle INSERT IGNORE
        $sql = "SELECT id FROM $tablename WHERE id='$row[id]'";
        $stmt2 = $con->query($sql);
        if (!$stmt2->fetch())
        {
          $row['name'] = addslashes($row['name']);
          $row['summary'] = addslashes($row['summary']);

          $sql = <<<EOF
INSERT INTO $tablename
  (id, name, summary, dev_version, available, source)
  VALUES ($row[id], '$row[name]', '$row[summary]', '$row[dev_version]', '$row[available]', '$row[source]');
EOF;
          $con->exec($sql);
        }
      }
      $con->commit();
    }
    
    
    $sql = <<<EOF
SELECT id, $tablename.* 
FROM $tablename
EOF;
    $stmt = $con->query($sql);
    $con->beginTransaction();
    foreach ($stmt as $row)
    {
      // Keep only packages for which one of those criteria is met:
      // - the base/update version is lower than that of the target
      // - one of the versions is higher than that of the target
      // - there is a newer version available outside the distro
      if  (
            (
              (
                !$this->show_updated 
                || (!is_null($row['update_version']) && RpmPeer::evrCompare($row['dev_version'], $row['update_version']) <= 0)
              )
              && 
              (
                !$this->show_backported 
                || is_null($row['backport_version']) 
              )
            )
            && (!$this->show_older || is_null($row['update_version'])           || RpmPeer::evrCompare($row['dev_version'], $row['update_version']) >= 0)
            && (!$this->show_older || is_null($row['update_testing_version'])   || RpmPeer::evrCompare($row['dev_version'], $row['update_testing_version']) >= 0)
            && (!$this->show_older || is_null($row['backport_version'])         || RpmPeer::evrCompare($row['dev_version'], $row['backport_version']) >= 0)
            && (!$this->show_older || is_null($row['backport_testing_version']) || RpmPeer::evrCompare($row['dev_version'], $row['backport_testing_version']) >= 0)
            && (is_null($row['available']))
          )
      {
        $sql = "DELETE FROM $tablename WHERE id=$row[id]"; 
        $con->exec($sql);
      }
    }
    $con->commit();

    $sql = <<<EOF
SELECT * 
FROM $tablename
ORDER BY NAME
EOF;
    $stmt = $con->query($sql);
    $this->rows = $stmt->fetchAll();
    
    $this->has_updates_testing = false;
    $this->has_backports = false;
    $this->has_backports_testing = false;
    $this->has_available_versions = false;
    foreach ($this->rows as $row)
    {
      if (!$this->has_updates_testing and $row['update_testing_version'])
      {
        $this->has_updates_testing = true;
      }
      if (!$this->has_backports and $row['backport_version'])
      {
        $this->has_backports = true;
      }
      if (!$this->has_backports_testing and $row['backport_testing_version'])
      {
        $this->has_backports_testing = true;
      }
      if (!$this->has_available_versions and $row['available'])
      {
        $this->has_available_versions = true;
      }
    }
    
//    $this->pager = new PropelPager($criteria, 'BasePeer', 'doSelect', $page, 50);
  }
  
  // FIXME: too youri-specific
  function getYouriVersions()
  {
    $madbConfig = new madbConfig();
    $madbDistroConfigFactory = new madbDistroConfigFactory;
    $madbDistroConfig = $madbDistroConfigFactory->getCurrentDistroConfig($madbConfig);
    $youri_url = $madbDistroConfig->getYouriCheckUrl();
    
    $list = array();
    if ($youri_url !== null)
    {
      $dom = new DOMDocument();
      if (@$dom->loadHTMLFile($youri_url))
      {
        $dom->preserveWhiteSpace = false; 
        $table = $dom->getElementsByTagName('table')->item(0);
        foreach ($table->getElementsByTagName('tr') as $row)
        {
          $fields = $row->getElementsByTagName('td');
          if ($fields->length)
          {
            $src_package = strtolower($fields->item(0)->firstChild->nodeValue);
            $available = $fields->item(4)->nodeValue;
            $source = $fields->item(5)->nodeValue;

            $list[strtolower($src_package)] = array($src_package, $available, $source);
          }
        }
      }
    }
    return $list;
  }
}
