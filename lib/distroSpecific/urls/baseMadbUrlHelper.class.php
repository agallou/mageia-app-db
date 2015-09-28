<?php
abstract class baseMadbUrlHelper implements madbUrlHelperInterface
{
  abstract public function getLinkToMaintainer($login, $name);
}