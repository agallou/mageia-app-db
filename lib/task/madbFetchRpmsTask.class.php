<?php
class madbFetchRpmsTask extends madbBaseTask
{

  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'fetch-rpms';
    $this->addOption('limit', null, sfCommandOption::PARAMETER_REQUIRED, 'number of rpms to fetch', null);
    $this->addOption('distro', null, sfCommandOption::PARAMETER_REQUIRED, 'distribution to fetch', 'mageia');
    $this->addOption('config', null, sfCommandOption::PARAMETER_REQUIRED, 'configuration file to use', null);
    $this->addOption('notify', null, sfCommandOption::PARAMETER_NONE, 'add this option if you want changes to trigger notifications', null);
    $this->addOption('add', null, sfCommandOption::PARAMETER_NONE, 'add missing distreleases, archs and media, instead of failing', null);
    $this->addOption('ignore-missing-from-sophie', null, sfCommandOption::PARAMETER_NONE, 'ignore missing distreleases, archs or media from sophie\'s response', null);
    $this->addOption('ignore-missing-stable', null, sfCommandOption::PARAMETER_NONE, 'ignore missing stable distrelease in config file', null);
  }
  protected function execute($arguments = array(), $options = array())
  {
    // TODO: use the "limit" parameter
    
    
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    $con = Propel::getConnection();
    
    $distribution = $options['distro'];
    $config_file = $options['config'] ? $options['config'] : dirname(__FILE__) . '/../../data/distros/' . $distribution . '/distro.yml';
    
    $factory = new madbDistroConfigFactory();
    $config = $factory->createFromFile($config_file);
    
    
    
    // check config file validity (TODO : make it an actual check !)
    if (!$config->check())
    {
      echo "Invalid configuration file '$config_file'";
      return false;
    }
    
    // overload $distribution with the case-sensitive name from the config file
    $distribution = $config->getName();
    
    
    
    
    $sophie = new SophieClient();
    $sophie->setDefaultType('json');
    
    // Get release, arch and media information from sophie
    // $distreleases[$release][$arch][$media] = true
    if (!$distreleases = $this->getDistreleasesArchsMedias($config, $sophie))
    {
      echo "Failed to get distrelease, arch and media information, aborting.\n";
      return false;
    } 
    
    // Now that we have all wanted media for all archs for all distreleases, perform some checking
    // TODO : better checking
    // Distreleases : 
    $distreleaseObjs = DistreleasePeer::doSelect(new Criteria());
    $distreleasesDb = array();
    foreach ($distreleaseObjs as $distreleaseObj)
    {
      $distreleasesDb[] = $distreleaseObj->getName();
    }
    // - releases present in database must be still present in result. 
    //   If not, abort, or ignore, following $options['ignore-missing-from-sophie']
    $missing_from_sophie = array_diff($distreleasesDb, array_keys($distreleases));
    if (count($missing_from_sophie))
    {
      $message = "Missing distrelease(s) from Sophie's response : " . implode(' ', $missing_from_sophie);
      if ($options['ignore-missing-from-sophie'])
      {
        echo $message . "\n";
      }
      else
      {
        throw new madbException($message);
      }
    }
    
    // - releases present in result but absent from database : 
    //   abort or add them, following $options['add']
    $missing_from_db = array_diff(array_keys($distreleases), $distreleasesDb);
    if (count($missing_from_db))
    {
      $message = "New distrelease(s) in Sophie's response : " . implode(' ', $missing_from_db);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_db as $distrelease)
        {
          $distreleaseObj = new Distrelease();
          $distreleaseObj->setName($distrelease);
          $distreleaseObj->save();
          echo "=> $distrelease added.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }
    
    // - devel distreleases
    // TODO :  It could be tricky (can a devel version lose it's devel version status ? Can it become obsolete ?)
    $new_list_devel = $config->getDevelReleases();
    $old_list_devel = array();
    $develDistreleaseObjs = DistreleasePeer::getDevels();
    foreach($develDistreleaseObjs as $develDistreleaseObj)
    {
      $old_list_devel[] = $develDistreleaseObj->getName();
    }
    // new devel releases
    $new_not_in_old = array_diff($new_list_devel, $old_list_devel);
    if ($new_not_in_old)
    {
      $message = "New devel distrelease(s) not devel in database : " . implode(' ', $new_not_in_old);
      if ($options['add'])
      {
        echo $message . "\n";
        foreach ($new_not_in_old as $distrelease)
        {
          if (!$distreleaseObj = DistreleasePeer::retrieveByName($distrelease))
          {
            throw new madbException("Distrelease $distrelease not found in database");
          }
          $distreleaseObj->setIsDevVersion(true);
          $distreleaseObj->save();
          echo "=> status updated for distrelease $distrelease.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }
    // devel releases that are no more devel
    $old_not_in_new = array_diff($old_list_devel, $new_list_devel);
    if ($old_not_in_new)
    {
      $message = "Old devel distrelease(s) no more devel in config file : " . implode(' ', $old_not_in_new);
      if ($options['add'])
      {
        echo $message . "\n";
        foreach ($old_not_in_new as $distrelease)
        {
          if (!$distreleaseObj = DistreleasePeer::retrieveByName($distrelease))
          {
            throw new madbException("Distrelease $distrelease not found in database");
          }
          $distreleaseObj->setIsDevVersion(false);
          $distreleaseObj->save();
          echo "=> status updated for distrelease $distrelease.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }
    
    // - latest stable release
    $latest = $config->getLatestStableRelease();
    if (!$new_latest_stable = DistreleasePeer::retrieveByName($latest))
    {
      $message = "Latest stable release '$latest' not found in database";
      if ($options['ignore-missing-stable'])
      {
        echo $message . "\n";
      }
      else
      {
        throw new madbException($message);
      }
    }
    // If the distrelease doesn't already know it's the latest stable release
    // Abort, or update, depending on $options['add']
    elseif (!$new_latest_stable->getIsLatest())
    {
      $message = "Distrelease $latest doesn't know it's the latest stable release";
      if ($options['add'])
      {
        echo $message . "\n";
        DistreleasePeer::updateIsLatestFlag($latest);
        echo "=> status updated for distrelease $latest.\n";
      }
      else
      {
        throw new madbException($message);
      }      
    }
    
    
    // Archs :
    $archsSophie = array();
    foreach ($distreleases as $distrelease => $archs)
    {
      foreach ($archs as $arch => $medias)
      {
        $archsSophie[$arch] = $arch;
      }
    }
    $archObjs = ArchPeer::doSelect(new Criteria());
    $archsDb = array();
    foreach ($archObjs as $archObj)
    {
      $archsDb[] = $archObj->getName();
    }
    // - archs present in database must still exist in results
    //   If not, abort, or ignore, following $options['ignore-missing-from-sophie']
    $missing_from_sophie = array_diff($archsDb, $archsSophie);
    if (count($missing_from_sophie))
    {
      $message = "Missing arch(s) from Sophie's response : " . implode(' ', $missing_from_sophie);
      if ($options['ignore-missing-from-sophie'])
      {
        echo $message . "\n";
      }
      else
      {
        throw new madbException($message);
      }
    }
    // - archs present in results but absent from database must be added in database
    //   abort or add them, following $options['add']
    $missing_from_db = array_diff($archsSophie, $archsDb);
    if (count($missing_from_db))
    {
      $message = "New arch(s) in Sophie's response : " . implode(' ', $missing_from_db);
      if ($options['add'])
      {  
        echo $message . "\n";
        // add them
        foreach ($missing_from_db as $arch)
        {
          $archObj = new Arch();
          $archObj->setName($arch);
          $archObj->save();
          echo "=> $arch added.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }
    
    
    // Media :
    $mediasSophie = array();
    foreach ($distreleases as $distrelease => $archs)
    {
      foreach ($archs as $arch => $medias)
      {
        foreach ($medias as $media => $value)
        {
          $mediasSophie[$media] = $media;
        }
      }
    }
    $mediaObjs = MediaPeer::doSelect(new Criteria());
    $mediasDb = array();
    foreach ($mediaObjs as $mediaObj)
    {
      $mediasDb[] = $mediaObj->getName();
    }
    // - media present in database must still exist in results
    //   If not, abort, or ignore, following $options['ignore-missing-from-sophie']
    $missing_from_sophie = array_diff($mediasDb, $mediasSophie);
    if (count($missing_from_sophie))
    {
      $message = "Missing media(s) from Sophie's response : " . implode(' ', $missing_from_sophie);
      if ($options['ignore-missing-from-sophie'])
      {
        echo $message . "\n";
      }
      else
      {
        throw new madbException($message);
      }
    }
    // - media present in sophie must exist in database
    //   abort or add them, following $options['add']
    $missing_from_db = array_diff($mediasSophie, $mediasDb);
    if (count($missing_from_db))
    {
      $message = "New media(s) in Sophie's response : " . implode(' ', $missing_from_db);
      if ($options['add'])
      {  
        echo $message . "\n";
        // add them
        foreach ($missing_from_db as $media)
        {
          $mediaObj = new Media();
          $mediaObj->setName($media);
          $mediaObj->save();
          echo "=> $media added.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }    
    
    // TODO : updates, backports, testing media...
    
    
    
    
    
    
    
    // Now fetch RPM lists and treat them
    $rpmImporter = new RpmImporter();
    $nbFailedRpms = 0;
    $nbRetrievedRpms = 0;
    
    foreach ($distreleases as $distrelease => $archs)
    {
      if (!$distreleaseObj = DistreleasePeer::retrieveByName($distrelease))
      {
        throw new madbException("Distrelease $distrelease not found in database");
      } 
      
      foreach ($archs as $arch => $medias)
      {
        if (!$archObj = ArchPeer::retrieveByName($arch))
        {
          throw new madbException("Arch $arch not found in database");
        } 
        foreach ($medias as $media => $unused_value)
        {
          if (!$mediaObj = MediaPeer::retrieveByName($sophie->convertMediaName($media)))
          {
            throw new madbException("Media $media not found in database");
          } 
          echo "--- $distrelease : $arch : $media"; 
          // Get the list of pkgids and RPM names
          // Filter list of RPMs with only_packages and exclude_packages filters
          $rpms = $sophie->getRpmsFromMedia( 
                    $distribution,
                    $distrelease,
                    $arch,
                    $media,
                    array(
                      'only' => $config->getOnlyRpms(), 
                      'exclude' => $config->getExcludeRpms()
                    )
                  );
          asort($rpms);
          
          // Compare that list to what we have in database for that release/media/arch
          $criteria = new Criteria();
          $criteria->addJoin(RpmPeer::DISTRELEASE_ID, DistreleasePeer::ID);
          $criteria->addJoin(RpmPeer::ARCH_ID, ArchPeer::ID);
          $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
          $criteria->add(DistreleasePeer::NAME, $distrelease);
          $criteria->add(ArchPeer::NAME, $arch);
          $criteria->add(MediaPeer::NAME, $sophie->convertMediaName($media));
          $criteria->addSelectColumn(RpmPeer::RPM_PKGID);
          $criteria->addSelectColumn(RpmPeer::NAME);
          $stmt = RpmPeer::doSelectStmt($criteria);
          $rpms2 = array();
          foreach ($stmt as $row)
          {
            $rpms2[$row['RPM_PKGID']] = $row['NAME'];
          }
          asort($rpms2);
          
          $differences = array_diff_assoc($rpms, $rpms2);
          echo " (" . count($rpms) . " RPMs , " . count($differences) . " new RPMs) ---\n";
          // For each unknown RPM 
          // TODO : (batch processing would be great here)
          foreach ($differences as $pkgid => $filename)
          {
            echo " " . $filename . " ( " . $pkgid . " )\n";
            
            // Fetch RPM infos
            try 
            {
              $rpmInfos = $sophie->getRpmByPkgid($pkgid);
              $nbRetrievedRpms++;
            }
            catch (SophieClientException $e)
            {
              echo "Error retrieving $filename : " . $e->getMessage() . "\n";
              $nbFailedRpms++;
            }
            
            // Process RPM
            $rpmImporter->importFromArray($distreleaseObj, $archObj, $mediaObj, $rpmInfos);
            
          }
          
          if (count($differences))
          {
            echo "\n";
          }
          
          // TODO : handle missing packages from sophie as compared to database
          // and for being able to do it, treat -src media along with their non-src media
          //(array_diff_assoc($rpms2, $rpms));
          // For each deleted RPM (absent from the list)
            // Flag the rows as deleted in rpm table
            // Update other tables so that they are exactly like it would be without this RPM
          
        }
      }
    }
    
    echo "Total number of retrieved RPMs : $nbRetrievedRpms\n";
    echo "Total number of failed RPMs retrievals : $nbFailedRpms\n";
  }  
  
  protected function getDistreleasesArchsMedias (madbDistroConfig $config, SophieClient $sophie)
  {
    // TODO : better error handling (no echo inside the method...)
    $distribution = $config->getName();
    $distreleases = array();
    
    $releases = $sophie->getReleases( 
                  $distribution, 
                  array(
                    'only' => $config->getOnlyReleases(), 
                    'exclude' => $config->getExcludeReleases()
                  )
              );
    if (!$releases)
    {
      echo "Failed to get a list of releases for distribution '$distribution'\n";
      return false;
    }
    
    // For each release
    foreach ($releases as $release)
    {
      // Get list of archs
      // Filter list with only_archs and exclude_archs filters
      $archs = $sophie->getArchs( 
                    $distribution,
                    $release,
                    array(
                      'only' => $config->getOnlyArchs(), 
                      'exclude' => $config->getExcludeArchs()
                    )
                  );
      if (!$archs)
      {
        echo "Failed to get a list of archs for distribution '$distribution', release '$release'.\n";
        return false;
      }
      
      // For each arch
      foreach ($archs as $arch)
      {
        // Get list of media
        // Filter list with only_media and exclude_media filters
        $medias = $sophie->getMedias( 
                      $distribution,
                      $release,
                      $arch, 
                      array(
                        'only' => $config->getOnlyMedias(), 
                        'exclude' => $config->getExcludeMedias()
                      )
                    );
        if (!$medias)
        {
          echo "Failed to get a list of medias for distribution '$distribution', release '$release', arch '$arch'.\n";
          return false;
        }
          
        // For each media
        foreach ($medias as $media)
        {
          $distreleases[$release][$arch][$media] = true;
        }
      }
    }
    
    return $distreleases;
  }
}
