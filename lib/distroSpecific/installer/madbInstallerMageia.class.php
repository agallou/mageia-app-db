<?php
class madbInstallerMageia extends baseMadbInstaller
{
  public function getMessageForRpm(Rpm $rpm, $url)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('Url', 'Tag'));
    
    $arch = $rpm->getArch()->getName();
    $media = $rpm->getMedia()->getName();
    $release = $rpm->getDistrelease()->getDisplayedName();
    $name = $rpm->getName();
    
    $link = link_to('Click here to install ' . $rpm->getName(), $url, array('class' => 'button'));
    
    return <<<EOF
<p>This will install the RPM using the standard Mageia repositories configured on <strong>your</strong> system.</p> 
<br/>
<p>Prerequisites:
<ul>
  <li>Distribution: <strong>$release</strong>.</li>
  <li>Media: <strong>$media</strong>, active and up to date.</li>
  <li>Architecture: <strong>$arch</strong>.</li>
  <li>The media containing dependencies for $name must be active and up to date.</li>
</ul>
</p>
<br/>    
<br/>
<p>
<strong>$link</strong>
<br/>
<br/>
<br/>
<p>To configure or update the installation sources, run the <strong>drakrpm-edit-media</strong> tool as root. 
<ul>
  <li><em>Add:</em> to add the online installation media, click the "Add" button (needed only once and only if they are not present already).</li>
  <li><em>Activate:</em> click the checkboxes to activate the needed media.</li>
  <li><em>Update:</em> select "File">"Update" in the menu to update the media.</li>
</ul>
Don't forget to un-activate media afterwards if you don't want to keep them activated (such as backports media).
</p> 
<br/>
<p><strong>Known issue:</strong>
<ul>
  <li>By default the <em>chromium</em> browser, instead of asking, downloads the file directly. Click the little arrow next to the download result 
  and choose to always open that kind of file.</li>
</ul>
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