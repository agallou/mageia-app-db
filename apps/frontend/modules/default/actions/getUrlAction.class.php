<?php
class getUrlAction extends madbActions
{

  public function execute($request)
  {
    //TODO forwardUnless baseURl

    $cleanUrls   = $this->getMadbConfig()->get('clean-urls');
    $url         = $request->getParameter('baseurl');
    $extraParams = $request->getParameter('extraParams', array());
    $url         = base64_decode($url);
    $generator   = new urlFilterGenerator($this->getContext()->getRouting(), $this->getMadbUrl());
    $urlInfos    = $generator->generate($cleanUrls, $_SERVER['PHP_SELF'], $url, $extraParams);
//var_export($urlInfos);
//die();
    $this->setVar('newUrl', $urlInfos['new_url']);
    $this->setVar('changed', $urlInfos['changed']);
    $this->getResponse()->sethttpHeader('Content-type','application/json');
  }

  protected function getMadbConfig()
  {
    return new madbConfig();
  }

  public function getDefaultParameters()
  {
    return array();
  }

}
