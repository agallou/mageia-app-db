<?php
class madbInstallerMageia extends baseMadbInstaller
{
  public function getMessageForRpm(Rpm $rpm)
  {
    $arch = $rpm->getArch()->getName();
    $media = $rpm->getMedia()->getName();
    $release = $rpm->getDistrelease()->getDisplayedName();
    $name = $rpm->getName();
    
    return <<<EOF
<p>This will install the RPM using the standard Mageia repositories configured on <strong>your</strong> system. It works only if the following prerequisites are met:
<ul>
  <li>Your distribution really is <strong>$release</strong>.</li>
  <li>You have configured the <strong>online installation sources</strong> for $release.</li>
  <li>The <strong>$media</strong> media is active and up to date.</li>
  <li>All media containing dependencies for $name are active and up to date.</li>
  <li>RPMs from the <strong>$arch</strong> arch can be installed on your system.</li>
</ul>
</p>
<br/>
<p>
To configure or update the installation sources, run the <strong>drakrpm-edit-media</strong> tool as root. 
Click the checkboxes to activate the needed media. Select "File">"Update" in the menu to update them. 
Don't forget to un-activate media afterwards if you don't want to keep them activated (such as backports media).
</p>      
EOF;
  }
  
  public function getFileContents(Rpm $rpm)
  {
    return preg_replace('/\.rpm$/', '', $rpm->getName());
  }
  
  public function getFilename(Rpm $rpm)
  {
    return $rpm->getName() . ".urpmi";
  }
  
  public function getFileType()
  {
    return "application/octet-stream";
  }
}