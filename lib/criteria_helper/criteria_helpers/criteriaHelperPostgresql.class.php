<?php

class criteriaHelperPostgresql implements criteriaHelperInterface
{

  /**
   * substringIndex
   * 
   * @param string $text
   * @param string $delimiter
   * @param string $count
   *
   * @return void
   */
  public function substringIndex($text, $delimiter, $count)
  {
    if ($count<1)
    {
      throw new madbException("\$count must me strictly positive in " . __METHOD__);
    }
    $result = sprintf("split_part(%s, '%s', %s)", $text, $delimiter, 1);
    for ($i=2 ; $i<=$count; $i++)
    {
      $result .= " || '/' || " . sprintf("split_part(%s, '%s', %s)", $text, $delimiter, $i);
    }
    return $result;
  }
}
