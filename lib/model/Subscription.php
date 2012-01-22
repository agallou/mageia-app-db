<?php


/**
 * Skeleton subclass for representing a row from the 'subscription' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Subscription extends BaseSubscription {

	/**
	 * Initializes internal state of Subscription object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}
    
    /**
     * Deletes all SubscriptionElement objects related to the Subscription object
     * Nullifies references to the subscription in related notifications
     * Then deletes itself
     */
    public function deleteFully()
    {
      foreach ($this->getSubscriptionElements() as $subscriptionElement)
      {
        $subscriptionElement->delete();
      }
      foreach ($this->getNotifications() as $notification)
      {
        $notification->setSubscription(null);
        $notification->save();
      }
      $this->delete();
    }

} // Subscription
