<?php
class installDialogAction extends madbActions
{
  /**
   * Input: RPM id
   * Output: contents of a dialog for installing the RPM
   * Action type: ajax
   * 
   * @param sfRequest $request 
   */
  public function execute($request)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('Url', 'Tag'));
    
    if (!$request->hasParameter('id'))
    {
      $contents = "id parameter missing";
      return $this->renderText($contents);
    }
    $id = $request->getParameter('id');
    if (!$rpm = RpmPeer::retrieveByPK($id))
    {
      $contents = "No RPM found for id '$id'";
      return $this->renderText($contents);
    }
    
    $installerFactory = new madbInstallerFactory();
    if (!$installer = $installerFactory->create())
    {
      $contents = "No installer class found for the current distribution";
      return $this->renderText($contents);
    }

    $url = $this->madburl->urlForRpm($rpm, $this->madbcontext, array('moduleaction' => 'rpm/install'));
    
    $link = link_to('Click here to install ' . $rpm->getName(), $url);
    $contents = <<<EOF
<br/>    
<strong>$link</strong>
<br/>    
<br/>  
EOF;
    $contents .= $installer->getMessageForRpm($rpm, $url);
    return $this->renderText($contents);
  }
}
