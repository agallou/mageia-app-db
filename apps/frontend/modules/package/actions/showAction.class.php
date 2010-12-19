<?php
class showAction extends madbActions
{
  public function execute($request)
  {
    $this->forward404Unless($request->hasParameter('id'), 'Package id is required');
    $id = $request->getParameter('id');
    $this->package = PackagePeer::retrieveByPk($id);
    $this->forward404Unless($this->package, 'Erroneous package id');
  }

}
