<?php

class madbPager extends PropelPager
{

    public function getNumberBeginOnPage()
    {
      return (($this->getPage() - 1) * $this->max) + 1;
    }

    public function getNumberEndOnPage()
    {
      return (($this->getPage() - 1) * $this->max) + count($this);
    }


}
