<?php
class formFactory
{

  public static function create()
  {
    $form = new sfForm();
    $filter =  new applicationCriteriaFilter();
    $form = $filter->configureForm($form);
    $filter = new groupCriteriaFilter();
    $form = $filter->configureForm($form);
    return $form;
  }

}
