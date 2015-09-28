<?php
class madbUrlHelperMageia extends baseMadbUrlHelper
{
  public function getLinkToMaintainer($login, $name)
  {
    return "<a href='https://people.mageia.org/u/$login.html'>$name</a>";
  }
}
