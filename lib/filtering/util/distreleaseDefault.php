<?php

class distreleaseDefault
{

  /**
   * @return int|null
   */
  public function getDefault()
  {
    if ($latest = DistreleasePeer::getLatest())
    {
      return $latest->getId();
    }
    elseif ($devels = DistreleasePeer::getDevels())
    {
      return $devels[0]->getId();
    }
    return null;
  }

}
