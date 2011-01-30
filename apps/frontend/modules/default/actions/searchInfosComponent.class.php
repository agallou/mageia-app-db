<?php

class searchInfosComponent extends madbComponent
{
  public function execute($request)
  {
    $this->madbcontext = $this->getMadbContext();
  }
}
