<?php
abstract class baseMadbBugtracker implements madbBugtrackerInterface
{
  abstract public function getLabelForMatchType($type);
  abstract public function findBugForUpdateCandidate($name, $full=false);
  abstract public function getUrlForBug($number);
}