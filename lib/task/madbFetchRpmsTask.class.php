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
  }
  protected function execute($arguments = array(), $options = array())
  {
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    $con = Propel::getConnection();
    
    // TODO : put that into a configuration file
    $urlSophie = "http://sophie.zarb.org";
    
    $distribution = $options['distro'];
    $config_file = $options['config'] ? $options['config'] : dirname(__FILE__) . '/../../data/distros/' . $distribution . '/distro.yml';
    
    if (file_exists($config_file))
    {
      $config = sfYaml::load($config_file);
    }
    else
    {
      echo "Configuration file not found.\n";
      return false;
    }
    
    // TODO: use the "limit" parameter
    
    // Get list of releases
    // Filter list with only_releases and exclude_releases filters
    
    // For each release
      // Add release to database if not known yet
      // Get list of media
      // Filter list with only_media and exclude_media filters
      
      // For each media
        // Add media to database if not known yet
        // Get list of archs
        // Filter list with only_archs and exclude_archs filters
        
        // For each arch
          // Add arch to database if not known yet
          // Get the list of pkgids and RPM names
          // Filter list of RPMs with only_packages and exclude_packages filters
          // Compare that list to what we have in database for that release/media/arch
           
          // For each unknown RPM (batch processing would be great here)
            // Fetch RPM infos
            // Insert RPM into database (rpm and package tables)
            // Process notifications
            
          // For each deleted RPM (absent from the list)
            // Flag the rows as deleted in rpm table
            // Update other tables so that they are exactly like it would be without this RPM
    
    $csv = dirname(__FILE__) . '/../../tmp/tmp' . $distribution . '.csv';
    $this->getFilesystem()->execute("rm -f $csv");
    if (!($csvHandle = fopen($csv, 'w')))
    {
      // TODO : throw exception
      die("couldn't open $csv for writing");
    }
    
    // Fetch RPM and SRPM names and IDs for each distrelease and arch
    foreach ($distreleases as $distrelease)
    {
      foreach ($archs as $arch)
      {
        $urlDistreleaseArch = "$urlSophie/distrib/$distribution/$distrelease/$arch";
        echo "Fetching $urlDistreleaseArch\n";
        $json = file_get_contents($urlDistreleaseArch . "?json=1");
        if ($json)
        {
          $medias = json_decode($json);
          foreach ($medias as $media)
          {
            $urlMedia = $urlDistreleaseArch . "/media/$media";
            echo "$media ";
            $json = file_get_contents($urlMedia . "?json=1");
            if ($json)
            {
              $rpms = json_decode($json);
              
              echo "(" . count($rpms) . ")";
              $failedUrlRpms = array();
              foreach ($rpms as $rpm)
              {
                if ($i++ and $i%100 == 0) 
                {
                  echo "."; 
                }
                $urlRpm = $urlMedia . "/by-pkgid/" . $rpm->pkgid;
                $json = file_get_contents($urlRpm . "?json=1");
                if ($json)
                {
                  $rpmInfos = json_decode($json);
                  $buildDate = new DateTime('@' . $rpmInfos->info->buildtime);
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
                  );
                  // Write it in the csv file
                  fwrite($csvHandle, implode("\t", $tab) . "\n");
                }
                else 
                {
                  $failedUrlRpms[] = $urlRpm;
                }
              }
            }
            else
            {
              echo ": fetch failed !";
            }
            echo "\n";
            if (!empty($failedUrlRpms))
            {
              echo count($failedUrlRpms) . " failed requests, for the following URLs :\n";
              foreach ($failedUrlRpms as $failedUrlRpm)
              {
                echo "$failedUrlRpm\n";
              }
            }
          }
        }
        else
        {
          echo "Fetch failed, or empty results !\n";
        }
      }
    }
    fclose($csvHandle);
  }
}
