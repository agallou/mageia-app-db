<?php


/**
 * This class defines the structure of the 'rpmfile' table.
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
class RpmfileTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.RpmfileTableMap';

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
		$this->setName('rpmfile');
		$this->setPhpName('Rpmfile');
		$this->setClassname('Rpmfile');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('RPM_PKGID', 'RpmPkgid', 'CHAR', true, 32, null);
		$this->addColumn('BUILD_TIME', 'BuildTime', 'TIMESTAMP', false, null, null);
		$this->addForeignKey('ARCH_ID', 'ArchId', 'INTEGER', 'arch', 'ID', true, null, null);
		$this->addForeignKey('RPM_ID', 'RpmId', 'INTEGER', 'rpm', 'ID', true, null, null);
		$this->addColumn('SIZE', 'Size', 'INTEGER', true, null, null);
		$this->addColumn('ARCH', 'Arch', 'VARCHAR', false, 45, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('ArchRelatedByArchId', 'Arch', RelationMap::MANY_TO_ONE, array('arch_id' => 'id', ), null, null);
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

} // RpmfileTableMap
