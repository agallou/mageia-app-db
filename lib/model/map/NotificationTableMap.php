<?php


/**
 * This class defines the structure of the 'notification' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class NotificationTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.NotificationTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('notification');
		$this->setPhpName('Notification');
		$this->setClassname('Notification');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('SUBSCRIPTION_ID', 'SubscriptionId', 'INTEGER', 'subscription', 'ID', true, null, null);
		$this->addForeignKey('RPM_ID', 'RpmId', 'INTEGER', 'rpm', 'ID', true, null, null);
		$this->addColumn('EVENT_TYPE', 'EventType', 'INTEGER', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Subscription', 'Subscription', RelationMap::MANY_TO_ONE, array('subscription_id' => 'id', ), null, null);
    $this->addRelation('Rpm', 'Rpm', RelationMap::MANY_TO_ONE, array('rpm_id' => 'id', ), null, null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // NotificationTableMap
