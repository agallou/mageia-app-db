<?php
class madbUrlHelperMageia extends baseMadbUrlHelper
{
  public function getLinkToMaintainer($login, $name)
  {
    if ($login == "nobody")
    {
      return $name;
    }
    return "<a href='https://people.mageia.org/u/$login.html'>$name</a>";
  }
}
