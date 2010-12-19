<?php
class showAction extends madbActions
{
  public function execute($request)
  {
    $this->forward404Unless($request->hasParameter('id'), 'RPM id is required');
    $id = $request->getParameter('id');
    $this->rpm = RpmPeer::retrieveByPk($id);
    $this->forward404Unless($this->rpm, 'Erroneous RPM id');
  }

}
