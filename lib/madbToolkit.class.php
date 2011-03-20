<?php
class madbToolkit
{
  public static function filterArrayKeepOnly($values = array(), $regexps = array(), $empty_means_no_filter = false)
  {
    if (!is_array($regexps))
    {
      throw new madbException('$regexps must be an array of values.');
    }
    
    if (!$empty_means_no_filter or !empty($regexps))
    {
      $unfiltered_values = $values;
      $values = array();
      foreach($regexps as $regexp)
      {
        if (strpos($regexp, '/') !== false)
        {
          throw new madbException('$regexp must not contain slashes (value found : ' . $regexp . ')');
        }
        $grepped = preg_grep("/$regexp/", $unfiltered_values);
        $values = $values + $grepped;
      }
    }
    return $values;
  }
  
  public static function filterArrayExclude($values = array(), $regexps = array())
  {
    if (!is_array($regexps))
    {
      throw new madbException('$regexps must be an array of values.');
    }
    
    foreach($regexps as $regexp)
    {
      if (strpos($regexp, '/') !== false)
      {
        throw new madbException('$regexp must not contain slashes (value found : ' . $regexp . ')');
      }
      $values = preg_grep("/$regexp/", $values, PREG_GREP_INVERT);
    }    
    return $values;
  }
}