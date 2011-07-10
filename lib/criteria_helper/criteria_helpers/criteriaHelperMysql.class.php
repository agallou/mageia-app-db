<?php

class criteriaHelperMysql implements criteriaHelperInterface
{

  /**
   * splitPart
   * 
   * @param string $text
   * @param string $delimiter
   * @param string $count
   *
   * @return void
   */
  public function splitPart($text, $delimiter, $count)
  {
    return sprintf('SUBSTRING_INDEX(%s, \'%s\', %s)', $text, $delimiter, $count);
  }

}
