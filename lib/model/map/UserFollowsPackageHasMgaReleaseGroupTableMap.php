<?php


/**
 * This class defines the structure of the 'user_follows_package_has_mga_release_group' table.
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
class UserFollowsPackageHasMgaReleaseGroupTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UserFollowsPackageHasMgaReleaseGroupTableMap';

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
		$this->setName('user_follows_package_has_mga_release_group');
		$this->setPhpName('UserFollowsPackageHasMgaReleaseGroup');
		$this->setClassname('UserFollowsPackageHasMgaReleaseGroup');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('USER_FOLLOWS_PACKAGE_ID', 'UserFollowsPackageId', 'VARCHAR' , 'user_follows_package', 'ID', true, 45, null);
		$this->addForeignKey('MGA_RELEASE_GROUP_ID', 'MgaReleaseGroupId', 'INTEGER', 'mga_release_group', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('UserFollowsPackage', 'UserFollowsPackage', RelationMap::MANY_TO_ONE, array('user_follows_package_id' => 'id', ), null, null);
    $this->addRelation('MgaReleaseGroup', 'MgaReleaseGroup', RelationMap::MANY_TO_ONE, array('mga_release_group_id' => 'id', ), null, null);
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

} // UserFollowsPackageHasMgaReleaseGroupTableMap
