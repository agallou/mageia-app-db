<?php
class menuRenderer
{

  public function __construct(madbContext $context, madbUrl $madbUrl, sfRequest $request)
  {
    $this->context = $context;
    $this->madburl = $madbUrl;
    $this->request = $request;
  }

  public function render(menuGroup $group)
  {
    $menuItemRenderer = new menuItemRenderer($this->context, $this->madburl);
    $render = '<ul>'.PHP_EOL;
    foreach ($group as $groupOrItem)
    {
      if ($groupOrItem instanceof menuGroup)
      {
        $icon = $groupOrItem->getIcon();
        $iconString = null === $icon ? '' : sprintf('<i class="%s"></i> ', $icon);
        $render .= "<li>" . PHP_EOL . "<h2>" . $iconString .__($groupOrItem->getName())."</h2>".PHP_EOL.$this->render($groupOrItem).'</li>'.PHP_EOL;
      }
      elseif ($groupOrItem instanceof menuItem)
      {
        $render .= $menuItemRenderer->render($groupOrItem, $this->isCurrentItem($groupOrItem)) . PHP_EOL;
      }
    }
    $render .= '</ul>'.PHP_EOL;
    return $render;
  }

  private function isCurrentItem(menuItem $item)
  {
    $options       = $item->getOptions();
    $sameModAction = $this->isInternalUriCurrent($item->getInternalUri());
    if (!$sameModAction && isset($options['extra_active']))
    {
      foreach ($options['extra_active'] as $extra)
      {
        if (!$sameModAction)
        {
          $sameModAction = $this->isInternalUriCurrent($extra);
        }
      }
    }
    $isCurrent     = $sameModAction;
    if ($sameModAction && isset($options['extra_parameters']))
    {
      foreach ($options['extra_parameters'] as $name => $value)
      {
        $isCurrent = ($this->request->hasParameter($name) && $this->request->getParameter($name) == $value);
      }
    }
    return $isCurrent;
  }

  private function isInternalUriCurrent($internalUri)
  {
    return strpos($internalUri, sprintf('%s/%s', $this->request['module'], $this->request['action'])) > -1;
  }

}
