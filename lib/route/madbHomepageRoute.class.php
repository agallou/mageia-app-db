<?php
class madbHomepageRoute extends sfRoute
{

  /**
   * generate
   *
   * @param mixed $params
   * @param array $context
   * @param mixed $absolute
   *
   * @return void
   */
  public function generate($params, $context = array(), $absolute = false)
  {
    if (!$this->compiled)
    {
      $this->compile();
    }
    $url       = sprintf('/%s/%s', $this->defaults['module'], $this->defaults['action']);
    $defaults  = $this->mergeArrays($this->getDefaultParameters(), $this->defaults);
    if ($extra = array_diff_key($params, $this->variables, $defaults))
    {
      foreach ($extra as $name => $value)
      {
        $url .= sprintf('/%s/%s', $name, urlencode($value));
      }
    }
    return $url;
  }

}
