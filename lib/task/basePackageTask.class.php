<?php

abstract class basePackageTask extends madbBaseTask
{

  /**
   * Delete every unsed files
   *
   * @param string $path base path
   *
   * @return void
   */
  protected function deleteUnusedFilesAndFolders($path)
  {
    $list = $this->getFilesAndFoldersToDelete();
    foreach ($list as $toDelete)
    {
      $this->getFilesystem()->removeRecusively($path . $toDelete);
    }
  }

  /**
   * Returns the files of files and folders to delete before packaging
   *
   * @return string[]
   */
  protected function getFilesAndFoldersToDelete()
  {
    return array_map('trim', file(sfConfig::get('sf_root_dir') . '/config/tgz_exclude.txt'));
  }

  /**
   * Export a tag un the VCS
   *
   * @param string $tagname
   * @param string $directory
   *
   * @return void
   */
  protected function exportTag($tagname, $directory)
  {
    $cmd = sprintf('git archive %s | tar -x -C %s', $tagname, $directory);
    $this->getFilesystem()->execute($cmd, array(), array($this, 'log'));
  }

}
