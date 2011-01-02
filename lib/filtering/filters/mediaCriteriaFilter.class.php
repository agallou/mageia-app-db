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
   * doFilterChoice 
   * 
   * @param Criteria             $criteria 
   * @param                      $value 
   * @return Criteria
   */
  protected function doFilterChoice(Criteria $criteria, $value)
  {
    $criteria->addAnd(RpmPeer::MEDIA_ID, $value, Criteria::IN);
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
