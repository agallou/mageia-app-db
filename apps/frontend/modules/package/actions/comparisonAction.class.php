<?php
class comparisonAction extends madbActions
{
  public function execute($request)
  {
    if ($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
    }
    else
    {
      $page = 1;
    }
    
    $con = Propel::getConnection();
    
    $dev_releases = DistreleasePeer::getDevels();
    if (!empty($dev_releases))
    {
      $dev_release = $dev_releases[0]; // we take the first one, don't know what to do if there are several
    }
    else
    {
      $this->forward404('no dev release in this database, impossible to use this page.');
    }
    $criteria = $this->getCriteria(filterPerimeters::PACKAGE);
    $criteria->addJoin(PackagePeer::ID, RpmPeer::PACKAGE_ID);
    $criteria->addJoin(RpmPeer::DISTRELEASE_ID, DistreleasePeer::ID);
    $criteria->add(DistreleasePeer::ID, $dev_release->getId());
    $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
    $criteria->add(MediaPeer::IS_TESTING, false);
    $criteria->add(MediaPeer::IS_THIRD_PARTY, false);
    $criteria->add(MediaPeer::IS_BACKPORTS, false);
    
    // group by just in case the dev release has several versions
    $criteria->addGroupByColumn(PackagePeer::ID);
    $criteria->clearSelectColumns();
    $criteria->addSelectColumn(PackagePeer::ID);
    $criteria->addSelectColumn(PackagePeer::NAME);
    $criteria->addSelectColumn(PackagePeer::SUMMARY);
    $criteria->addAsColumn('dev_version', RpmPeer::VERSION);
    
    $tablename = 'tmp_package';
    $toTmp = new criteriaToTemporaryTable($criteria, $tablename);
    $toTmp->setConnection($con);
    $toTmp->execute();
    
    // FIXME : check that it works with postgresql
    $sql = <<<EOF
ALTER TABLE $tablename ADD PRIMARY KEY (ID),
ADD update_version VARCHAR(255) NULL,
ADD update_testing_version VARCHAR(255) NULL,
ADD backport_version VARCHAR(255) NULL,
ADD backport_testing_version VARCHAR(255) NULL;
EOF;
    $con->exec($sql);

    foreach (array('update', 'update_testing', 'backport', 'backport_testing') as $media_type)
    {
      $criteria = $this->getCriteria(filterPerimeters::RPM);
      $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
      
      switch ($media_type)
      {
        case 'update':
          $criteria->add(MediaPeer::IS_BACKPORTS, false);
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
      $criteria->addSelectColumn(RpmPeer::PACKAGE_ID);
      $criteria->addSelectColumn(RpmPeer::VERSION);
      $stmt = BasePeer::doSelect($criteria);
      
      $fieldname = $media_type . "_version";
      
      foreach ($stmt as $row)
      {
        $sql = <<<EOF
UPDATE $tablename
SET $fieldname = '$row[VERSION]'
WHERE ID = $row[PACKAGE_ID];
EOF;
        $con->exec($sql);
      }
      $stmt->fetchAll();
    } 
    
    $sql = <<<EOF
SELECT * 
FROM $tablename
EOF;
    $stmt = $con->query($sql);
    foreach ($stmt as $row)
    {
      if (RpmPeer::evrCompare($row['dev_version'], $row['update_version']) <= 0
          || (!is_null($row['backport_version']) && RpmPeer::evrCompare($row['dev_version'], $row['backport_version']) <= 0)
          )
      {
        $sql = "DELETE FROM $tablename WHERE ID=$row[ID]"; 
        $con->exec($sql);
      }
    }
    
/*    
    $criteria = new Criteria();
    $criteria->addSelectColumn("$tablename.ID");
    $criteria->addSelectColumn("$tablename.NAME");
    $criteria->addSelectColumn("$tablename.SUMMARY");
    $criteria->addSelectColumn("$tablename.dev_version");
    $criteria->addSelectColumn("$tablename.update_version");
    $criteria->addSelectColumn("$tablename.update_testing_version");
    $criteria->addSelectColumn("$tablename.backport_version");
    $criteria->addSelectColumn("$tablename.backport_testing_version");
    $criteria->addAscendingOrderByColumn("$tablename.NAME");
    $this->stmt = BasePeer::doSelect($criteria);
*/

    $sql = <<<EOF
SELECT * 
FROM $tablename
ORDER BY NAME
EOF;
    $stmt = $con->query($sql);
    $this->rows = $stmt->fetchAll();
        
    
//    $this->pager = new PropelPager($criteria, 'BasePeer', 'doSelect', $page, 50);
  }
}
