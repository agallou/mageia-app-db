<?php


/**
 * Skeleton subclass for representing a row from the 'distrelease' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Distrelease extends BaseDistrelease {

	/**
	 * Initializes internal state of Distrelease object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}
    
    public function getDisplayedName()
    {
      if ($this->getIsMeta())
      {
        switch ($this->getName())
        {
          case DistreleasePeer::META_LATEST:
            $latest = $this->getRealDistrelease();
            return "Latest stable" . (($latest) ? " (" . $latest->getDisplayedName() . ")" : " (none)");
            
          case DistreleasePeer::META_PREVIOUS:
            $previous = $this->getRealDistrelease();
            return "Previous stable" . (($previous) ? " (" . $previous->getDisplayedName() . ")" : " (none)");
          
          default:
            throw new madbException('Unknown meta distrelease: ' . $this->getName());
        }
      }
      else
      {
        return $this->getName();
      }
    }
    
    public function getRealDistrelease()
    {
      if ($this->getIsMeta())
      {
        switch ($this->getName())
        {
          case DistreleasePeer::META_LATEST:
            return DistreleasePeer::getLatest();
            
          case DistreleasePeer::META_PREVIOUS:
            return DistreleasePeer::getPrevious();
          
          default:
            throw new madbException('Unknown meta distrelease: ' . $this->getName());
        }
      }
      else
      {
        return $this;
      }
    }

    public function getMetaDistrelease()
    {
      if ($this->getIsLatest())
      {
        return DistreleasePeer::getMetaLatest();
      }
      elseif ($this->getIsPrevious())
      {
        return DistreleasePeer::getMetaPrevious();
      }
      else return null;
    }

} // Distrelease
