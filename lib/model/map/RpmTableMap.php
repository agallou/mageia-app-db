<?php


/**
 * This class defines the structure of the 'rpm' table.
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
class RpmTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.RpmTableMap';

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
		$this->setName('rpm');
		$this->setPhpName('Rpm');
		$this->setClassname('Rpm');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('IDRPM', 'Idrpm', 'INTEGER', true, null, null);
		$this->addColumn('PACKAGE_IDPACKAGE', 'PackageIdpackage', 'INTEGER', false, null, null);
		$this->addForeignKey('MGA_RELEASE_IDMGA_RELEASE', 'MgaReleaseIdmgaRelease', 'INTEGER', 'mga_release', 'ID', false, null, null);
		$this->addForeignKey('MEDIA_IDMEDIA', 'MediaIdmedia', 'INTEGER', 'media', 'IDMEDIA', false, null, null);
		$this->addForeignKey('PACKAGE_ID', 'PackageId', 'INTEGER', 'package', 'ID', false, null, null);
		$this->addForeignKey('RPM_GROUP_ID', 'RpmGroupId', 'INTEGER', 'rpm_group', 'ID', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('MgaRelease', 'MgaRelease', RelationMap::MANY_TO_ONE, array('mga_release_idmga_release' => 'id', ), null, null);
    $this->addRelation('Media', 'Media', RelationMap::MANY_TO_ONE, array('media_idmedia' => 'idmedia', ), null, null);
    $this->addRelation('Package', 'Package', RelationMap::MANY_TO_ONE, array('package_id' => 'id', ), null, null);
    $this->addRelation('RpmGroup', 'RpmGroup', RelationMap::MANY_TO_ONE, array('rpm_group_id' => 'id', ), null, null);
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

} // RpmTableMap
