<?php
class mageiaNavComponent extends madbComponent
{
  public function execute($request)
  {
    $request     = $this->getRequest();

    $htmlContent = null;
    $cssContent = null;

    $madbConfig = new madbConfig();
    if ($madbConfig->get('display_mageia_header')) {
      $htmlContent = file_get_contents('http://nav.mageia.org/html/?l={html[lang]}&b={body[class]}&w=1');
      $cssContent = file_get_contents('http://nav.mageia.org/css/');
    }

    $this->setVar('html_content', $htmlContent);
    $this->setVar('css_content', $cssContent);
  }
}
