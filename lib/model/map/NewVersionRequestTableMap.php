<?php


/**
 * This class defines the structure of the 'new_version_request' table.
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
class NewVersionRequestTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.NewVersionRequestTableMap';

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
		$this->setName('new_version_request');
		$this->setPhpName('NewVersionRequest');
		$this->setClassname('NewVersionRequest');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		$this->setPrimaryKeyMethodInfo('new_version_request_id_seq');
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null, null);
		$this->addForeignKey('PACKAGE_ID', 'PackageId', 'INTEGER', 'package', 'ID', true, null, null);
		$this->addForeignPrimaryKey('DISTRELEASE_ID', 'DistreleaseId', 'INTEGER' , 'distrelease', 'ID', true, null, null);
		$this->addColumn('VERSION_NEEDED', 'VersionNeeded', 'VARCHAR', true, 45, null);
		$this->addColumn('STATUS', 'Status', 'VARCHAR', true, 45, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('Package', 'Package', RelationMap::MANY_TO_ONE, array('package_id' => 'id', ), null, null);
    $this->addRelation('Distrelease', 'Distrelease', RelationMap::MANY_TO_ONE, array('distrelease_id' => 'id', ), null, null);
    $this->addRelation('UserCommentsNewVersionRequest', 'UserCommentsNewVersionRequest', RelationMap::ONE_TO_MANY, array('id' => 'new_version_request_id', ), null, null);
    $this->addRelation('UserHasNewVersionRequest', 'UserHasNewVersionRequest', RelationMap::ONE_TO_MANY, array('id' => 'new_version_request_id', ), null, null);
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

} // NewVersionRequestTableMap
