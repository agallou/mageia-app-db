<?php

class error404Action extends sfActions
{

    public function execute($request)
    {
      // get the attribute we optionnally set manually before forwarding to a 404 page
      $this->message404 = $request->getAttribute('message404') ? $request->getAttribute('message404') : "";
    }
}
