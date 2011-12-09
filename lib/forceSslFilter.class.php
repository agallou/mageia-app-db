<?php

class forceSslFilter extends sfFilter
{
  public function execute($filterChain)
  {
    if($this->isFirstCall())
    {
      $madbConfig = new madbConfig();
      if ($madbConfig->get('force-ssl'))
      {
        $request = $this->getContext()->getRequest();
        if (substr($request->getUri(), 0, 7) === 'http://')
        {
          $url = str_replace('http', 'https', $request->getUri());
          return $this->getContext()->getController()->redirect($url, 0, 301);
        }
      }
    }
    $filterChain->execute();
  }
}