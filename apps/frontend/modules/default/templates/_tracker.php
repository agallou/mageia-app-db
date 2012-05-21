<?php 

$tracker_file = sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . "tracker.html";
var_dump($tracker_file);  
if (file_exists($tracker_file))
{
  echo file_get_contents($tracker_file);
}
  
  
  
  
