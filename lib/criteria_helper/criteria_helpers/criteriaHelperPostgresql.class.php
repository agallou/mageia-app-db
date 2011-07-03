<?php

class criteriaHelperPostgresql implements criteriaHelperInterface
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
    return sprintf("split_part(%s, '%s', %s)", $text, $delimiter, $count);
  }

}
