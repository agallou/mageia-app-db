<?php
class madbPropelObjectHydrator implements Iterator
{

  /**
   * @var PdoStatement
   */
  protected $stmt   = null;

  /**
   * @var BaseObject
   */
  protected $object = null;

  /**
   * @var array
   */
  protected $lastRow = null;

  /**
   * @var int
   */
  protected $position = 0;

  /**
   * @param PdoStatement $stmt
   * @param BaseObject   $object
   *
   * @return void
   */
  public function __construct(PdoStatement $stmt, BaseObject $object)
  {
    $this->stmt     = $stmt;
    $this->object   = $object;
    $this->lastRow  = $this->stmt->fetch();
  }

  /**
   * @return BaseObject
   */
  public function current()
  {
    $object = clone $this->object;
    $object->hydrate($this->lastRow);
    return $object;
  }

  /**
   * @return void
   */
  public function next()
  {
    $this->lastRow = $this->stmt->fetch();
    $this->position++;
  }

  /**
   * @return int
   */
  public function key()
  {
    return $this->position;
  }

  /**
   * @return bool
   */
  public function valid()
  {
    return $this->position < $this->stmt->rowCount();
  }

  /**
   * @return void
   */
  public function rewind()
  {
    $this->position = 0;
  }
}
