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
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null, null);
		$this->addColumn('UPDATE', 'Update', 'BOOLEAN', true, null, false);
		$this->addColumn('NEW_VERSION', 'NewVersion', 'BOOLEAN', true, null, false);
		$this->addColumn('UPDATE_CANDIDATE', 'UpdateCandidate', 'BOOLEAN', true, null, false);
		$this->addColumn('NEW_VERSION_CANDIDATE', 'NewVersionCandidate', 'BOOLEAN', true, null, false);
		$this->addColumn('COMMENTS', 'Comments', 'BOOLEAN', true, null, false);
		$this->addColumn('MAIL_NOTIFICATION', 'MailNotification', 'BOOLEAN', true, null, false);
		$this->addColumn('MAIL_PREFIX', 'MailPrefix', 'VARCHAR', false, 45, null);
		$this->addForeignKey('RSS_FEED_ID', 'RssFeedId', 'INTEGER', 'rss_feed', 'ID', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('RssFeed', 'RssFeed', RelationMap::MANY_TO_ONE, array('rss_feed_id' => 'id', ), null, null);
    $this->addRelation('NotificationElement', 'NotificationElement', RelationMap::ONE_TO_MANY, array('id' => 'notification_id', ), null, null);
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
