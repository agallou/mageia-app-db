<?php

class releaseDefault
{

  /**
   * @return int|null
   */
  public function getDefault()
  {
    if ($latest = DistreleasePeer::getLatest())
    {
      return $latest->getName();
    }
    elseif ($devels = DistreleasePeer::getDevels())
    {
      return $devels[0]->getName();
    }
    return null;
  }

}
