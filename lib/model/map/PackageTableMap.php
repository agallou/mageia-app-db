<?php


/**
 * This class defines the structure of the 'package' table.
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
class PackageTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PackageTableMap';

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
		$this->setName('package');
		$this->setPhpName('Package');
		$this->setClassname('Package');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 1024, null);
		$this->addColumn('IS_APPLICATION', 'IsApplication', 'BOOLEAN', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Rpm', 'Rpm', RelationMap::ONE_TO_MANY, array('id' => 'package_id', ), null, null);
    $this->addRelation('UserFollowsPackage', 'UserFollowsPackage', RelationMap::ONE_TO_MANY, array('id' => 'package_id', ), null, null);
    $this->addRelation('UserCommentsPackage', 'UserCommentsPackage', RelationMap::ONE_TO_MANY, array('id' => 'package_id', ), null, null);
    $this->addRelation('PackageDescription', 'PackageDescription', RelationMap::ONE_TO_MANY, array('id' => 'package_id', ), null, null);
    $this->addRelation('PackageScreenshots', 'PackageScreenshots', RelationMap::ONE_TO_MANY, array('id' => 'package_id', ), null, null);
    $this->addRelation('PackageLinks', 'PackageLinks', RelationMap::ONE_TO_MANY, array('id' => 'package_id', ), null, null);
    $this->addRelation('NewVersionRequest', 'NewVersionRequest', RelationMap::ONE_TO_MANY, array('id' => 'package_id', ), null, null);
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

} // PackageTableMap
