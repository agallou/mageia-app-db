<?php
class madbPropelObjectHydratorFactory
{
  public function create(Criteria $criteria, BaseObject $object)
  {
    $stmt = call_user_func_array(array(get_class($object->getPeer()), 'doSelectStmt'), array($criteria));
    return new madbPropelObjectHydrator($stmt, $object);
  }
}
