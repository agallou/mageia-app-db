<?php
interface madbInstallerInterface
{
  public function getMessageForRpm(Rpm $rpm, $url);
  public function getFileContents(Rpm $rpm);
  public function getFilename(Rpm $rpm);
  public function getFileType();
}
