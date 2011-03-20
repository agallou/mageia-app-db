<?php


/**
 * This class defines the structure of the 'user_has_new_version_request' table.
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
class UserHasNewVersionRequestTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UserHasNewVersionRequestTableMap';

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
		$this->setName('user_has_new_version_request');
		$this->setPhpName('UserHasNewVersionRequest');
		$this->setClassname('UserHasNewVersionRequest');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'user', 'ID', true, null, null);
		$this->addForeignPrimaryKey('NEW_VERSION_REQUEST_ID', 'NewVersionRequestId', 'INTEGER' , 'new_version_request', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('NewVersionRequest', 'NewVersionRequest', RelationMap::MANY_TO_ONE, array('new_version_request_id' => 'id', ), null, null);
	} // buildRelations()

} // UserHasNewVersionRequestTableMap
