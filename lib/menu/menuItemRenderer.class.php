<?php

require_once(dirname(__FILE__) . '/../vendor/symfony/lib/helper/UrlHelper.php');
require_once(dirname(__FILE__) . '/../vendor/symfony/lib/helper/AssetHelper.php');
require_once(dirname(__FILE__) . '/../vendor/symfony/lib/helper/TagHelper.php');


class menuItemRenderer
{

  public function __construct(madbContext $context, madbUrl $madbUrl)
  {
    $this->context = $context;
    $this->madbUrl = $madbUrl;
  }

  public function render(menuItem $item, $isCurrent = false)
  {
    $current = $isCurrent ? ' class="current"' : '';
    $render  = sprintf('<li%s><a href="%s">%s</a></li>', $current, $this->madbUrl->urlFor($item->getInternalUri(), $this->context, $item->getOptions()), $item->getName());
    return $render;
  }

}
