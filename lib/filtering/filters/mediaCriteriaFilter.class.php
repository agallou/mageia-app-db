<?php 
class mediaCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getValues()
  {
    $values = array();
    $medias = MediaPeer::doSelect(new Criteria);
    //TODO some callback to a statement.
    foreach ($medias as $media)
    {
      $values[$media->getId()] = $media->getName();
    }
    return $values;
  }

  /**
   * filter 
   * 
   * @param Criteria             $criteria 
   * @param iMadbParameterHolder $parameterHolder 

   * @return Criteria
   */
  protected function filter(Criteria $criteria, madbContext $context)
  {
    //TODO liste avec opérandes ????
    //plusieurs fois le même parameterHolder ??? pas de context ???
    $value = $context->getParameter('media');
    if (null !== $value)
    { 
      $value = explode(',', $value);
      $criteria->addAnd(RpmPeer::MEDIA_ID, $value, Criteria::IN);
    }
    return $criteria;
  }

  public function getCode()
  {
    return 'media';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Media'; //Internationalisation ? outside, allways in english here.
  }

}
