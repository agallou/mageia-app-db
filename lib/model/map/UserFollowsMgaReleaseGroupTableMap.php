<?php


/**
 * This class defines the structure of the 'user_follows_mga_release_group' table.
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
class UserFollowsMgaReleaseGroupTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UserFollowsMgaReleaseGroupTableMap';

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
		$this->setName('user_follows_mga_release_group');
		$this->setPhpName('UserFollowsMgaReleaseGroup');
		$this->setClassname('UserFollowsMgaReleaseGroup');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_IDUSER', 'UserIduser', 'INTEGER', 'user', 'ID', true, null, null);
		$this->addForeignKey('MGA_REALEASE_GROUP_ID', 'MgaRealeaseGroupId', 'INTEGER', 'mga_release_group', 'ID', true, null, null);
		$this->addColumn('UPDATE', 'Update', 'BOOLEAN', true, null, false);
		$this->addColumn('NEW_VERSION', 'NewVersion', 'BOOLEAN', true, null, false);
		$this->addColumn('TESTER', 'Tester', 'BOOLEAN', true, null, false);
		$this->addColumn('PACKAGER', 'Packager', 'BOOLEAN', true, null, false);
		$this->addColumn('COMMENTS', 'Comments', 'BOOLEAN', true, null, false);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_iduser' => 'id', ), null, null);
    $this->addRelation('MgaReleaseGroup', 'MgaReleaseGroup', RelationMap::MANY_TO_ONE, array('mga_realease_group_id' => 'id', ), null, null);
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

} // UserFollowsMgaReleaseGroupTableMap
