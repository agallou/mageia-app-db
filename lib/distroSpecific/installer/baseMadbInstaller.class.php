<?php
abstract class baseMadbInstaller implements madbInstallerInterface
{
  abstract public function getMessageForRpm(Rpm $rpm, $url);
  abstract public function getFileContents(Rpm $rpm);
  abstract public function getFilename(Rpm $rpm);
  abstract public function getFileType();  
}