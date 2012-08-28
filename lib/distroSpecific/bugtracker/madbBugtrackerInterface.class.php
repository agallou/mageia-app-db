<?php
interface madbBugtrackerInterface
{
  public function getLabelForMatchType($type);
  public function findBugForUpdateCandidate($name, $full=false);
  public function getUrlForBug($number);
}
