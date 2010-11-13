<?php
class listAction extends sfActions
{
  public function execute($request)
  {
    if ($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
    }
    else
    {
      $page = 1;
    }
    $this->pager = new PropelPager(new Criteria(), Package::PEER, 'doSelect', $page, 50);
    $this->title = 'Packages';
  }

}
