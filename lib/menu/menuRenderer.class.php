<?php
class menuRenderer
{

  public function __construct(madbContext $context, madbUrl $madbUrl)
  {
    $this->context = $context;
    $this->madburl = $madbUrl;
  }

  public function render(menuGroup $group)
  {
    $menuItemRenderer = new menuItemRenderer($this->context, $this->madburl);
    $render = '<ul>' . PHP_EOL;
    foreach ($group as $groupOrItem)
    {
        var_dump($groupOrItem);

      if ($groupOrItem instanceof menuGroup)
      {
        $render .= $this->render($groupOrItem);
      }
      elseif ($groupOrItem instanceof menuItem)
      {
        $render .= '  ' . $menuItemRenderer->render($groupOrItem) . PHP_EOL;
      }
    }
    $render .= '</ul>';
    return $render;
  }

}
