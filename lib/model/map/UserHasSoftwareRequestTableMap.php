<?php


/**
 * This class defines the structure of the 'user_has_software_request' table.
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
class UserHasSoftwareRequestTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UserHasSoftwareRequestTableMap';

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
		$this->setName('user_has_software_request');
		$this->setPhpName('UserHasSoftwareRequest');
		$this->setClassname('UserHasSoftwareRequest');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('USER_IDUSER', 'UserIduser', 'INTEGER' , 'user', 'ID', true, null, null);
		$this->addForeignPrimaryKey('SOFTWARE_REQUEST_ID', 'SoftwareRequestId', 'INTEGER' , 'software_request', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_iduser' => 'id', ), null, null);
    $this->addRelation('SoftwareRequest', 'SoftwareRequest', RelationMap::MANY_TO_ONE, array('software_request_id' => 'id', ), null, null);
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

} // UserHasSoftwareRequestTableMap
