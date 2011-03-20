<?php


/**
 * This class defines the structure of the 'package_screenshots' table.
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
class PackageScreenshotsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PackageScreenshotsTableMap';

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
		$this->setName('package_screenshots');
		$this->setPhpName('PackageScreenshots');
		$this->setClassname('PackageScreenshots');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('PATH_TO_SCREENSHOT', 'PathToScreenshot', 'VARCHAR', true, 1024, null);
		$this->addColumn('VERSION_FROM', 'VersionFrom', 'VARCHAR', false, 45, null);
		$this->addForeignKey('PACKAGE_ID', 'PackageId', 'INTEGER', 'package', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Package', 'Package', RelationMap::MANY_TO_ONE, array('package_id' => 'id', ), null, null);
	} // buildRelations()

} // PackageScreenshotsTableMap
