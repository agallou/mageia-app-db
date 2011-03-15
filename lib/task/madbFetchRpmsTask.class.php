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
      echo "Failed to get media information, aborting.\n";
      return false;
    } 
    
    // Now that we have all wanted media for all archs for all distreleases, perform some checking
    // TODO 
    // Distreleases : 
    $distreleaseObjs = DistreleasePeer::doSelect(new Criteria());
    $distreleasesDb = array();
    foreach ($distreleaseObjs as $distreleaseObj)
    {
      $distreleasesDb[] = $distreleaseObj->getName();
    }
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
    
    // - releases present in database must be still present in result. If not, abort
    // - releases present in result but absent from database :
    
    // - devel media
    // - latest stable 
    // It could be tricky (can a devel version lose it's devel version status ? Can it become obsolete ?)
    // Can a distrelease disappear ? 
    // Archs :
    $archsSophie = array();
    foreach ($distreleases as $distrelease => $archs)
    {
      foreach ($archs as $arch => $medias)
      {
        $archsSophie[$arch] = $arch;
      }
    }
    // - archs present in database must still exist in results
    $archObjs = ArchPeer::doSelect(new Criteria());
    $archsDb = array();
    foreach ($archObjs as $archObj)
    {
      $archsDb[] = $archObj->getName();
    }
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
    // - archs present in database must still exist in results
    $mediaObjs = MediaPeer::doSelect(new Criteria());
    $mediasDb = array();
    foreach ($mediaObjs as $mediaObj)
    {
      $mediasDb[] = $mediaObj->getName();
    }
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
    
    
    
    
    
    // Now fetch RPM lists and treat them
    $rpmImporter = new RpmImporter();
    
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
            $rpmInfos = $sophie->getRpmByPkgid($pkgid);
            
            // Process RPM
            $rpmImporter->importFromArray($distreleaseObj, $archObj, $mediaObj, $rpmInfos);
            
          }
          echo "\n";
          
          // TODO : handle missing packages from sophie as compared to database
          // and for being able to do it, treat -src media along with their non-src media
          //(array_diff_assoc($rpms2, $rpms));
          // For each deleted RPM (absent from the list)
            // Flag the rows as deleted in rpm table
            // Update other tables so that they are exactly like it would be without this RPM
          
        }
      }
    }
/*
                  $tab = array(
                    $rpmInfos->info->filename,
                    $rpmInfos->info->evr,
                    $rpmInfos->info->summary,
                    str_replace("\t", '\t', str_replace("\n", '\n', $rpmInfos->info->description)),
                    $buildDate->format('Y-m-d H:i:sP'),
                    $rpmInfos->info->url,
                    $rpmInfos->info->size,
                    $rpmInfos->info->sourcerpm,
                    $rpmInfos->info->license,
                    $rpmInfos->info->group,
                    $rpmInfos->info->arch,
                    $media,
                    $distribution,
                    "",
                    $distrelease,
                    $arch,
                    $rpm->pkgid
*/
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
