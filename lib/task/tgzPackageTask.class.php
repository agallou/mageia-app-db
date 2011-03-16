<?php
include_once(dirname(__FILE__).'/basePackageTask.class.php');

/**
 * tgzPackageTask
 *
 * mkdir./mageia_app_db
 * tar -zxf mageia_app_db-v0.1.tar.gz -C ./mageia_app_db
 * cd mageia_app_db
 * make (root)
 *
 *
 * @package Interface
 * @author  Adrien Gallou <adriengallou@gmail.com>
 * @version Release: <package_version>
 */
class tgzPackageTask extends basePackageTask
{

  /**
   * (non-PHPdoc)
   *
   * @see lib/vendor/symfony/task/sfTask#configure()
   * @return void
   */
  protected function configure()
  {
    $this->addArgument('version', sfCommandArgument::REQUIRED, 'Tag à utiliser');

    $this->namespace           = 'madb-package';
    $this->name                = 'tgz';
    $this->briefDescription    = 'Création du tgz';
    $this->detailedDescription = 'Création du tgz';
    $this->addOption('no-delete', null, sfCommandOption::PARAMETER_NONE, 'Ne pas supprimer les fichiers temporaires');
    $this->addOption('add-folder', null, sfCommandOption::PARAMETER_OPTIONAL, 'Dossier dans data contenant les fichiers à ajouter');
    $this->addOption('use-current', null, sfCommandOption::PARAMETER_NONE, 'Utiliser les fichiers data du project en cours et non ceux chekoutés');
  }

  /**
   * (non-PHPdoc)
   *
   * @param string[] $arguments arguments
   * @param string[] $options   options
   *
   * @see lib/vendor/symfony/task/sfTask#execute()
   * @return int
   */
  protected function execute($arguments = array(), $options = array())
  {
    $fs          = $this->getFilesystem();
    $versionName = sprintf('mageia_app_db-%s', $arguments['version']);
    $sourcesDir  = 'tmp/';
    $dataDir     = ($options['use-current']) ? 'data/' : $sourcesDir . 'usr/lib/mageia_app_db/data';

    if (!is_dir($dataDir))
    {
      $this->logBlock('datadir not found', 'ERROR');
      return 1;
    }

    //si le le dernier build à échoué on supprime le contenu des sources et du
    //build pour éviter les problèmes de fichiers qui restent dans le dossier
    $fs->removeRecusively($sourcesDir);

    //Création du dossier source
    $fs->mkdirs($sourcesDir);

    //Export from git repository
    $this->logSection('Export of version', $arguments['version']);
    $exportDir =  sprintf('%s/export/', $sourcesDir);
    $this->getFilesystem()->mkdirs($exportDir);
    $this->exportTag($arguments['version'], $exportDir);

    //On ajoute les fichiers nécéssaires au tgz
    $fs->execute(sprintf('cp -R %s/tgz/* %s', $dataDir, $sourcesDir));

    //Si on à passé l'option on copie le répertoire
    if ($options['add-folder'])
    {
      $addPath  = $dataDir . $options['add-folder'];
      $makeFile = $sourcesDir . 'Makefile';

      //On ignore les fichiers commendant par un _
      $fs->execute(sprintf('cp -R %s/[^_*]* %s', $addPath, $sourcesDir));

      //On ajoute à la partie uninstall du makefile les nouveaux fichiers
      $this->addFilesToUninstallMakefile($addPath, $makeFile);
    }

    //We delete .gitignore files
    $fs->execute(sprintf('rm -rf `find %s -type f -name .gitignore`', $sourcesDir));

    //Suppression des fichiers inutiles
    $this->deleteUnusedFilesAndFolders($exportDir);

    $this->moveFilesToTheirWebAppDirectory($exportDir, $sourcesDir);
    //TODO correct method name
    $fs->removeRecusively($exportDir);

    //On crée le tar.gz
    $this->logSection('tar.gz+', $sourcesDir . $versionName . '.tag.gz');
    $cwdir = getcwd();
    chdir($sourcesDir);
    exec(sprintf('tar -cf %1$s.tar %2$s', $versionName, '*'));
    exec(sprintf('gzip -f %s.tar', $versionName));
    chdir($cwdir);

    //Copie du tgz dans le repertoire builds du project
    $fs->mkdirs('builds/');
    $filePath =  sprintf('builds/%s.tar.gz', $versionName);
    $fs->copy($sourcesDir . $versionName . '.tar.gz', $filePath);

    if (!$options['no-delete'])
    {
      $fs->removeRecusively($sourcesDir);
    }
  }


  /**
   * moveFilesToTheirWebAppDirectory
   *
   * @see http://wiki.mandriva.com/en/Policies/Web_Applications
   *
   * @param mixed $exportDir
   * @param mixed $sources
   *
   * @return void
   */
  protected function moveFilesToTheirWebAppDirectory($exportDir, $sources)
  {
    $appname = 'mageia_app_db';
    $constantFilesDir = sprintf('%s/usr/share/%s', $sources, $appname);
    $this->getFilesystem()->mkdirs($constantFilesDir);
    $this->getFilesystem()->execute(sprintf('mv %s/apps %s', $exportDir, $constantFilesDir));
    $this->getFilesystem()->execute(sprintf('mv %s/data %s', $exportDir, $constantFilesDir));
    $this->getFilesystem()->execute(sprintf('mv %s/lib %s', $exportDir, $constantFilesDir));
    $this->getFilesystem()->execute(sprintf('mv %s/web %s', $exportDir, $constantFilesDir));
    $this->getFilesystem()->execute(sprintf('mv %s/symfony %s', $exportDir, $constantFilesDir));
    $this->getFilesystem()->execute(sprintf('mv %s/README %s', $exportDir, $constantFilesDir));
    $this->getFilesystem()->execute(sprintf('mv %s/LICENSE %s', $exportDir, $constantFilesDir));
    $this->getFilesystem()->execute(sprintf('mv %s/LICENSE.symfony %s', $exportDir, $constantFilesDir));


    //TODO only copy interesting files (ProjectConfiguration)
    $this->getFilesystem()->execute(sprintf('cp -R %s/config %s', $exportDir, $constantFilesDir));

    $configFilesDir = sprintf('%s/etc/%s', $sources, $appname);
    $this->getFilesystem()->mkdirs($configFilesDir);

    //TODO only create folder here
    $this->getFilesystem()->execute(sprintf('mv %s/config %s', $exportDir, $configFilesDir));
    $tmpFilesDir = sprintf('%s/var/cache/%s', $sources, $appname);
    $this->getFilesystem()->mkdirs($tmpFilesDir);
    $this->getFilesystem()->execute(sprintf('mv %s/cache %s', $exportDir, $tmpFilesDir));
    $logFilesDir = sprintf('%s/var/log/%s', $sources, $appname);
    $this->getFilesystem()->mkdirs($logFilesDir);
    $this->getFilesystem()->execute(sprintf('mv %s/log %s', $exportDir, $logFilesDir));
  }

  /**
   * Retourne la version majeure d'après un numéro de version
   *
   * @param  string $version version
   *
   * @return string
   */
  protected function majorFromVersion($version)
  {
    $tab = explode('.', $version);
    return $tab[0];
  }

  /**
   *
   *
   * @param string $addPath
   * @param string $makeFile
   *
   * @return void
   */
  protected function addFilesToUninstallMakefile($addPath, $makeFile)
  {
    $cont  = file_get_contents($makeFile);
    $files = sfFinder::type('file')->ignore_version_control()
                                   ->prune('_scripts')->in($addPath);
    $str   = '';
    $start = strlen(realpath($addPath));
    foreach ($files as $file)
    {
      $str .= "\t" . sprintf('rm -f %s', substr($file, $start)) . "\n";
    }
    $cont .= $str;
    file_put_contents($makeFile, $cont);
  }

}
