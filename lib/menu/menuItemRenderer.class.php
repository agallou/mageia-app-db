<?php

require_once(dirname(__FILE__) . '/../../vendor/friendsofsymfony1/symfony1/lib/helper/UrlHelper.php');
require_once(dirname(__FILE__) . '/../../vendor/friendsofsymfony1/symfony1/lib/helper/AssetHelper.php');
require_once(dirname(__FILE__) . '/../../vendor/friendsofsymfony1/symfony1/lib/helper/I18NHelper.php');

require_once(dirname(__FILE__) . '/../../vendor/friendsofsymfony1/symfony1/lib/helper/TagHelper.php');


class menuItemRenderer
{

  public function __construct(madbContext $context, madbUrl $madbUrl)
  {
    $this->context = $context;
    $this->madbUrl = $madbUrl;
  }

  public function render(menuItem $item, $isCurrent = false)
  {
    $name = __($item->getName());
    if (null === $item->getInternalUri())
    {
      return sprintf('<li class="leaf">%s</li>', $name);
    }
    $current = $isCurrent ? 'current' : '';
    $render  = sprintf('<li class="leaf %s"><a href="%s">%s</a></li>', $current, $this->madbUrl->urlFor($item->getInternalUri(), $this->context, $item->getOptions()), $name);
    return $render;
  }

}
