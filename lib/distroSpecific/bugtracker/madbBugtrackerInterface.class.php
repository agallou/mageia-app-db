<?php
interface madbBugtrackerInterface
{
  public function findBugForUpdateCandidate($name);
  public function getUrlForBug($number);
}
