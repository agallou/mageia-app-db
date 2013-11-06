<?php
class installAction extends madbActions
{
  public function execute($request)
  {
    if (!$distrelease = DistreleasePeer::retrieveByName($request->getParameter('release')))
    {
      $request->setAttribute('message404', "Missing or bad parameter for release");
      $this->forward404();
    }
    if (!$arch = ArchPeer::retrieveByName($request->getParameter('arch')))
    {
      $request->setAttribute('message404', "Missing or bad parameter for arch");
      $this->forward404();
    }
    if (!$media = MediaPeer::retrieveByPK($request->getParameter('t_media')))
    {
      $request->setAttribute('message404', "Missing or bad parameter for media");
      $this->forward404();
    }
    if (!$name = $request->getParameter('name'))
    {
      $request->setAttribute('message404', "Missing parameter for name");
      $this->forward404();
    }
    if (!$rpm = RpmPeer::retrieveUniqueByName($distrelease, $arch, $media, $name))
    {
      $request->setAttribute('message404', "No RPM with name '$name' found for the given release, media and arch.");
      $this->forward404();
    }
    
    $installerFactory = new madbInstallerFactory();
    if (!$installer = $installerFactory->create())
    {
      $request->setAttribute('message404', "No installer class found for the current distribution");
    }

    // get file name, content and type from installer
    $filename = $installer->getFilename($rpm);
    $contents = $installer->getFileContents($rpm);
    $type = $installer->getFileType();
    
    // send the file
    $this->getResponse()->clearHttpHeaders();
    $this->getResponse()->setContentType($type);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="' . $filename .'"');
    $this->getResponse()->setHttpHeader('Content-Type', 'application/x-urpmi; charset=UTF-8');
    return $this->renderText($contents);
  }
}
