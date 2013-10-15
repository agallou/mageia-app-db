<?php
class madbFetchRpmsTask extends madbBaseTask
{

  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'fetch-rpms';
    $this->addOption('limit', null, sfCommandOption::PARAMETER_REQUIRED, 'number of rpms to fetch', null);
    $this->addOption('notify', null, sfCommandOption::PARAMETER_NONE, 'add this option if you want changes to trigger notifications', null);
    $this->addOption('add', null, sfCommandOption::PARAMETER_NONE, 'add missing distreleases, archs and media, instead of failing', null);
    $this->addOption('ignore-missing-from-sophie', null, sfCommandOption::PARAMETER_NONE, 'ignore missing distreleases, archs or media from sophie\'s response', null);
    $this->addOption('ignore-missing-stable', null, sfCommandOption::PARAMETER_NONE, 'ignore missing stable distrelease in config file', null);
  }
  protected function execute($arguments = array(), $options = array())
  {
    if (is_numeric($options['limit']) and (int) $options['limit'] > 0)
    {
      $limit = $options['limit'];
    }

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

    $sophie = new SophieClient();
    $sophie->setDefaultType('json');

    // Get release, arch and media information from sophie
    // $distreleases[$release][$arch][$media] = true
    if (!$distreleases = $this->getDistreleasesArchsMedias($madbDistroConfig, $sophie))
    {
      echo "Failed to get distrelease, arch and media information, aborting.\n";
      return false;
    }

    // Now that we have all wanted media for all archs for all distreleases, perform some checking
    // TODO : better checking
    // Distreleases :
    $criteria = new Criteria();
    $criteria->add(DistreleasePeer::IS_META, false);
    $distreleaseObjs = DistreleasePeer::doSelect($criteria);
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
    $new_list_devel = $madbDistroConfig->getDevelReleases();
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
    $latest = $madbDistroConfig->getLatestStableRelease();
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

    // - previous stable release
    $previous = $madbDistroConfig->getPreviousStableRelease();
    if (trim($previous) !== '')
    {
      if (!$new_previous_stable = DistreleasePeer::retrieveByName($previous))
      {
        $message = "Previous stable release '$previous' not found in database";
        throw new madbException($message);
      }
      // If the distrelease doesn't already know it's the previous stable release
      // Abort, or update, depending on $options['add']
      elseif (!$new_previous_stable->getIsPrevious())
      {
        $message = "Distrelease $previous doesn't know it's the previous stable release";
        if ($options['add'])
        {
          echo $message . "\n";
          DistreleasePeer::updateIsPreviousFlag($previous);
          echo "=> status updated for distrelease $previous.\n";
        }
        else
        {
          throw new madbException($message);
        }
      }
    }
    else // There's no previous release in config file
    {
      if (DistreleasePeer::getPrevious())
      {
        if ($options['add'])
        {
          // There's no previous release, update the database accordingly
          echo "There is no 'previous stable' release according to distro config file, updating database accordingly\n";
          DistreleasePeer::updateIsPreviousFlag(null);
        }
        else
        {
          throw new madbException("There is no 'previous stable' release according to distro config file, and there's one in database. Fix config or use --add to apply the change.");
        }
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
    $allMedias = MediaPeer::MediasToNames(MediaPeer::doSelect(new Criteria()));
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

    // - media present in database must still exist in results
    //   If not, abort, or ignore, following $options['ignore-missing-from-sophie']
    $missing_from_sophie = array_diff($allMedias, $mediasSophie);
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
    $missing_from_db = array_diff($mediasSophie, $allMedias);
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

    // Update the $allMedias array so that it knows the new media now
    $allMedias = MediaPeer::MediasToNames(MediaPeer::doSelect(new Criteria()));

    // updates media
    $currentUpdatesMedias = MediaPeer::MediasToNames(MediaPeer::getUpdatesMedias());
    $newUpdatesMedias = madbToolkit::filterArrayKeepOnly($allMedias, $madbDistroConfig->getUpdatesMedias());

    // - update media according to config but not according to database.
    //   abort or add them, following $options['add']
    $missing_from_db = array_diff($newUpdatesMedias, $currentUpdatesMedias);
    if (count($missing_from_db))
    {
      $message = "New updates media(s) according to config file : " . implode(' ', $missing_from_db);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_db as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsUpdates(true);
          $mediaObj->save();
          echo "=> $media is now an updates media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    // - update media according to database but not according to config.
    //   abort or change their status, following $options['add']
    $missing_from_config = array_diff($currentUpdatesMedias, $newUpdatesMedias);
    if (count($missing_from_config))
    {
      $message = "Not updates media(s) according to config file, but updates media in database : " . implode(' ', $missing_from_config);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_config as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsUpdates(false);
          $mediaObj->save();
          echo "=> $media is no longer an updates media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    // - testing media
    $currentTestingMedias = MediaPeer::MediasToNames(MediaPeer::getTestingMedias());
    $newTestingMedias = madbToolkit::filterArrayKeepOnly($allMedias, $madbDistroConfig->getTestingMedias());

    // - testing media according to config but not according to database.
    //   abort or add them, following $options['add']
    $missing_from_db = array_diff($newTestingMedias, $currentTestingMedias);
    if (count($missing_from_db))
    {
      $message = "New testing media(s) according to config file : " . implode(' ', $missing_from_db);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_db as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsTesting(true);
          $mediaObj->save();
          echo "=> $media is now a testing media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    // - testing media according to database but not according to config.
    //   abort or change their status, following $options['add']
    $missing_from_config = array_diff($currentTestingMedias, $newTestingMedias);
    if (count($missing_from_config))
    {
      $message = "Not testing media(s) according to config file, but updates media in database : " . implode(' ', $missing_from_config);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_config as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsTesting(false);
          $mediaObj->save();
          echo "=> $media is no longer a testing media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    // - backports media
    $currentBackportsMedias = MediaPeer::MediasToNames(MediaPeer::getBackportsMedias());
    $newBackportsMedias = madbToolkit::filterArrayKeepOnly($allMedias, $madbDistroConfig->getBackportsMedias());

    // - backports media according to config but not according to database.
    //   abort or add them, following $options['add']
    $missing_from_db = array_diff($newBackportsMedias, $currentBackportsMedias);
    if (count($missing_from_db))
    {
      $message = "New backports media(s) according to config file : " . implode(' ', $missing_from_db);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_db as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsBackports(true);
          $mediaObj->save();
          echo "=> $media is now a backports media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    // - backports media according to database but not according to config.
    //   abort or change their status, following $options['add']
    $missing_from_config = array_diff($currentBackportsMedias, $newBackportsMedias);
    if (count($missing_from_config))
    {
      $message = "Not backports media(s) according to config file, but updates media in database : " . implode(' ', $missing_from_config);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_config as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsBackports(false);
          $mediaObj->save();
          echo "=> $media is no longer a backports media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    // - third party media
    $currentThirdPartyMedias = MediaPeer::MediasToNames(MediaPeer::getThirdPartyMedias());
    $newThirdPartyMedias = madbToolkit::filterArrayKeepOnly($allMedias, $madbDistroConfig->getThirdPartyMedias());

    // - third party media according to config but not according to database.
    //   abort or add them, following $options['add']
    $missing_from_db = array_diff($newThirdPartyMedias, $currentThirdPartyMedias);
    if (count($missing_from_db))
    {
      $message = "New third party media(s) according to config file : " . implode(' ', $missing_from_db);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_db as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsThirdParty(true);
          $mediaObj->save();
          echo "=> $media is now a third party media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    // - third party media according to database but not according to config.
    //   abort or change their status, following $options['add']
    $missing_from_config = array_diff($currentThirdPartyMedias, $newThirdPartyMedias);
    if (count($missing_from_config))
    {
      $message = "Not third party media(s) according to config file, but updates media in database : " . implode(' ', $missing_from_config);
      if ($options['add'])
      {
        echo $message . "\n";
        // add them
        foreach ($missing_from_config as $media)
        {
          $mediaObj = MediaPeer::retrieveByName($media);
          $mediaObj->setIsThirdParty(false);
          $mediaObj->save();
          echo "=> $media is no longer a third party media.\n";
        }
      }
      else
      {
        throw new madbException($message);
      }
    }

    if($options['notify']) $notify = true;
    else
    {
        echo "\033[1;33m"."Warning: notifications will not be sent"."\033[0m"."\n";
        $notify = false;
    }
    // Now fetch RPM lists and treat them
    $rpmImporter = new RpmImporter($notify);
    $nbFailedRpms = 0;
    $nbRetrievedRpms = 0;
    $nbRemovedRpms = 0;

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
          // get list of RPMs for this media in our database
          $criteria = new Criteria();
          $criteria->addJoin(RpmPeer::DISTRELEASE_ID, DistreleasePeer::ID);
          $criteria->addJoin(RpmPeer::ARCH_ID, ArchPeer::ID);
          $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
          $criteria->add(DistreleasePeer::NAME, $distrelease);
          $criteria->add(ArchPeer::NAME, $arch);
          $criteria->add(MediaPeer::NAME, $media);
          $criteria->addAsColumn('column1', RpmPeer::RPM_PKGID);
          $criteria->addAsColumn('column2', RpmPeer::NAME);
          $stmt = RpmPeer::doSelectStmt($criteria);
          $rpmsInDatabase = array();
          foreach ($stmt as $row)
          {
            $rpmsInDatabase[$row['column1']] = $row['column2'];
          }
          asort($rpmsInDatabase);
          unset($stmt);


          $sophieMedias = array(
            'bin' => $media,
            'src' => $sophie->getSrcMediaNameFromBinMediaName($media)
          );

          $rpmsBySophieMedia = array();
          foreach ($sophieMedias as $mediaType => $sophieMedia)
          {
            // then fetch RPM lists from Sophie
            if (!$mediaObj = MediaPeer::retrieveByName($sophie->convertMediaName($media)))
            {
              if ($mediaType == 'bin')
              {
                throw new madbException("Media $media not found in database");
              }
              else
              {
                echo "--- $distrelease : $arch : Source media $sophieMedia not found in Sophie, skipping it.\n";
                continue;
              }
            }

            // Get the list of pkgids and RPM names
            // Filter list of RPMs with only_packages and exclude_packages filters
            $rpmsBySophieMedia[$sophieMedia] = $sophie->getRpmsFromMedia(
                      $distribution,
                      $distrelease,
                      $arch,
                      $sophieMedia,
                      array(
                        'only' => $madbDistroConfig->getOnlyRpms(),
                        'exclude' => $madbDistroConfig->getExcludeRpms()
                      )
                    );
            asort($rpmsBySophieMedia[$sophieMedia]);
          }

          // handle missing packages from sophie as compared to database
          // and for being able to do it, treat -src media along with their non-src media
          //(array_diff_assoc($rpms2, $rpms));
          // For each deleted RPM (absent from the list)
          $missing_from_sophie = $rpmsInDatabase;
          foreach ($rpmsBySophieMedia as $sophieMedia => $rpmsInSophie)
          {
            $missing_from_sophie = array_diff_assoc($missing_from_sophie, $rpmsInSophie);
          }

          if (count($missing_from_sophie))
          {
            echo "\n" . count($missing_from_sophie) . " RPMs are no more in Sophie, removing them :\n";
          }
          foreach ($missing_from_sophie as $pkgid => $filename)
          {
            $startTime = microtime(true);
            echo " Remove " . $filename . " ( " . $pkgid . " )";

            if (!$rpm = RpmPeer::retrieveUniqueByName($distreleaseObj, $archObj, $mediaObj, $filename))
            {
              throw new madbException("Couldn't retrieve $filename for distrelease $distrelease, arch $arch and media $media");
            }

            // Update related RPMs if needed (binary RPMs for this source RPM)
            foreach ($relatedRpms = $rpm->getRpmsRelatedById() as $relatedRpm)
            {
              $relatedRpm->setSourceRpmId(null);
              $relatedRpm->save();
              $relatedRpm->clearAllReferences(true);
            }
            unset($relatedRpm);
            $relatedRpms->clearIterator();

            // Remove the RPM itself
            $rpm->delete();

            $nbRemovedRpms++;

            $time = round(microtime(true) - $startTime, 2);
            echo " - ${time}s";
            echo "\n";
          }
          if (count($missing_from_sophie))
          {
            echo "\n";
          }
          foreach ($rpmsBySophieMedia as $sophieMedia => $rpmsInSophie)
          {
            echo "--- $distrelease : $arch : $sophieMedia";

            // Search for missing RPMs in our database
            $missing_from_db = array_diff_assoc($rpmsInSophie, $rpmsInDatabase);
            echo " (" . count($rpmsInSophie) . " RPMs , " . count($missing_from_db) . " new) ---\n";
            // For each unknown RPM
            // TODO : (batch processing would be great here)
            foreach ($missing_from_db as $pkgid => $filename)
            {
              echo " Add " . $filename . " ( " . $pkgid . " )";
              $startTime = microtime(true);

              // Fetch RPM infos
              try
              {
                $rpmInfos = $sophie->getRpmByPkgid($pkgid);
                $rpmInfos['real_filename'] = $filename;
                $time1 = round(microtime(true) - $startTime, 2);
                echo " - ${time1}s";
                $nbRetrievedRpms++;
              }
              catch (SophieClientException $e)
              {
                echo "\nError retrieving $filename : " . $e->getMessage() . "\n";
                $nbFailedRpms++;
                continue;
              }

              // Process RPM
              $rpmImporter->importFromArray($distreleaseObj, $archObj, $mediaObj, $rpmInfos);
              $time2 = round(microtime(true) - $startTime - $time1, 2);
              echo " + ${time2}s";
              echo "\n";

              // Apply --limit
              if (isset($limit) and (($nbRetrievedRpms + $nbFailedRpms) >= $limit))
              {
                echo "\nLimit $limit reached, stopping.\n";
                break 5;
              }
            }

            if (count($missing_from_db))
            {
              echo "\n";
            }
          }

        }
      }
    }

    echo "Total number of retrieved RPMs : $nbRetrievedRpms\n";
    echo "Total number of failed RPMs retrievals : $nbFailedRpms\n";
    echo "Total number of removed RPMs : $nbRemovedRpms\n";


    // if there was at least one retrieved Rpm or one removed Rpm, update application status and clear cache
    if (($nbRetrievedRpms + $nbRemovedRpms) > 0)
    {
      // Update package.is_application
      $pathToAppList = sfConfig::get('sf_root_dir') . '/' . $madbConfig->get('applications_list_file');
      $this->updateIsApplicationFromFile($pathToAppList);

      // Clear cache
      $task = new sfCacheClearTask($this->dispatcher, $this->formatter);
      $task->run();

      $task = new madbUpdateScreenshotsCacheTask($this->dispatcher, $this->formatter);
      $task->run();
    }
  }

  protected function getDistreleasesArchsMedias (madbDistroConfig $madbDistroConfig, SophieClient $sophie)
  {
    // TODO : better error handling (no echo inside the method...)
    $distribution = $madbDistroConfig->getName();
    $distreleases = array();

    $releases = $sophie->getReleases(
                  $distribution,
                  array(
                    'only' => $madbDistroConfig->getOnlyReleases(),
                    'exclude' => $madbDistroConfig->getExcludeReleases()
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
                      'only' => $madbDistroConfig->getOnlyArchs(),
                      'exclude' => $madbDistroConfig->getExcludeArchs()
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
                        'only' => $madbDistroConfig->getOnlyMedias(),
                        'exclude' => $madbDistroConfig->getExcludeMedias()
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
          $distreleases[$release][$arch][$sophie->convertMediaName($media)] = true;
        }
      }
    }

    return $distreleases;
  }

  protected function updateIsApplicationFromFile($filename)
  {
    $con = Propel::getConnection();
    $databaseFactory = new databaseFactory($con);
    $database = $databaseFactory->createDefault();

    $sql = "CREATE TEMPORARY TABLE tmpapplications (name VARCHAR(255), PRIMARY KEY (name))";
    $con->exec($sql);

    $database->loadData('tmpapplications', $filename, false);


    $sql = "UPDATE package SET is_application = FALSE";
    $con->exec($sql);


    $database->updateWithJoin(
      'package',
      '',
      'is_application=TRUE',
      'tmpapplications',
      'package.name = tmpapplications.name AND package.is_source=FALSE'
    );

    // source packages of applications are flagged as applications too
    $database->updateWithJoin(
      'package',
      'source_package',
      'is_application = TRUE',
      'rpm AS source_rpm, rpm, package',
      'source_package.ID = source_rpm.PACKAGE_ID
        AND source_rpm.ID = rpm.SOURCE_RPM_ID
        AND rpm.is_source = FALSE
        AND rpm.PACKAGE_ID = package.ID
        AND package.is_application = TRUE'
    );
  }
}
