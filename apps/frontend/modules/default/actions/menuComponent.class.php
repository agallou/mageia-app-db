<?php 
class menuComponent extends sfComponent
{
  public function execute($request)
  {
    $this->madburl = new madbUrl($this->getContext());
    $contextFactory = new contextFactory();
    $this->madbcontext = $contextFactory->createFromRequest($this->getRequest());
  }
}
