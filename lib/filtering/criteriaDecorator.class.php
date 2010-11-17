<?php
/**
  Methods that can be implemened : 
  getOrderByColumns();
  getGroupByColumns();
  getSelectColumns();
  getAsColumns();
  getJoins();
*/
class criteriaFilter
{
  protected $criteria;

  /**
   * __construct 
   * 
   * @param Criteria             $criteria 
   * @param iMadbParameterHolder $parameterHolder 

   * @return void
   */
  public function __construct(Criteria $criteria, iMadbParameterHolder $parameterHolder)
  {
    $this->setCriteria($criteria);
    $this->setParameterHolder($criteria);
  }

  /**
   * filter 
   * 
   * @param Criteria             $criteria 
   * @param iMadbParameterHolder $parameterHolder 

   * @return Criteria
   */
  protected function filter(Criteria $criteria, iMadbParameterHolder $parameterHolder)
  {
    //TODO liste avec opérandes ????
    foreach ($parameterHolder->getAll() as $value)
    {
      $criteria->addAnd(RpmGroupPeer::NAME, $value);
    }
  }

  /**
   * name 
   * 
   * @return void
   */
  public function name()
  {
    return 'Package Groups'; //Internationalisation ? outside, allways in english here.
  }

  /**
   * getValues 
   * 
   * @return void
   */
  public function getValues()
  {
    return PackagePeer::doSelectStmt(new Criteria());
  }

  /**
   * getCriteria 
   * 
   * @return Criteria
   */
  public function getCriteria()
  {
    return $this->filter($this->getCriteria(), $this->getParameterHolder());
  }

}
