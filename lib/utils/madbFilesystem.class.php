<?php
class madbFilesystem extends sfFilesystem
{

  /**
   * removeRecusively
   *
   * @param mixed $folder
   *
   * @return void
   */
  public function removeRecusively($folder)
  {
    $this->logSection('dir-', $folder);
    $this->execute(sprintf('rm -rf %s', $folder));
  }

}
