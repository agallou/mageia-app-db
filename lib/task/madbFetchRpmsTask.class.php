<?php
class madbFetchRpmsTask extends madbBaseTask
{

  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'fetch-rpms';
    $this->addOption('limit', null, sfCommandOption::PARAMETER_OPTIONAL, 'number of rpms to fetch', false);
  }
  protected function execute($arguments = array(), $options = array())
  {
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    $con = Propel::getConnection();

//    $sql = "UPDATE package SET description=NULL, summary=NULL;";
//    $con->exec($sql);
    
    // TODO : put that into a configuration file
    $urlSophie = "http://sophie.zarb.org";
    
    $distribution = 'Mandriva';
    $distreleases = array(
      '2007.0',
      '2007.1',
      '2008.0',
      '2008.1',
      '2009.0',
      '2009.1',
      '2010.0',
      '2010.1',
      '2010.2',
      '2011.0',
      'cooker'
    );
    $archs = array(
      'i586', 
      'x86_64'
    );
    
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
