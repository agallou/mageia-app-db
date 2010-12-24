<?php
class filtersIterator extends ArrayIterator
{

  public function getByPerimeter($perimeter)
  {
    $filters = array();
    foreach ($this as $filter)
    {
      if ($filter->getPerimeter() != $perimeter)
      {
        continue;
      }
      $filters[] = $filter;
    }
    return new filtersIterator($filters);
  }

}
