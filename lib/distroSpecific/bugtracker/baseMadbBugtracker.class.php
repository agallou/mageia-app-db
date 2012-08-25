<?php
abstract class baseMadbBugtracker implements madbBugtrackerInterface
{
  abstract public function findBugForUpdateCandidate($name);
  abstract public function getUrlForBug($number);
}