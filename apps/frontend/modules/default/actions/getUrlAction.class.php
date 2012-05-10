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
    $this->getResponse()->sethttpHeader('Content-type','application/json');
    return $this->renderText(json_encode(array('url' => $urlInfos['new_url'], 'changed' => $urlInfos['changed'])));
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
