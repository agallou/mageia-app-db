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
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('PACKAGE_ID', 'PackageId', 'INTEGER', 'package', 'ID', true, null, null);
		$this->addForeignKey('DISTRELEASE_ID', 'DistreleaseId', 'INTEGER', 'distrelease', 'ID', true, null, null);
		$this->addForeignKey('MEDIA_ID', 'MediaId', 'INTEGER', 'media', 'ID', true, null, null);
		$this->addForeignKey('RPM_GROUP_ID', 'RpmGroupId', 'INTEGER', 'rpm_group', 'ID', true, null, null);
		$this->addColumn('LICENCE', 'Licence', 'VARCHAR', true, 255, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 900, null);
		$this->addColumn('MD5_NAME', 'Md5Name', 'VARCHAR', true, 32, null);
		$this->addColumn('FILENAME', 'Filename', 'VARCHAR', true, 900, null);
		$this->addColumn('SHORT_NAME', 'ShortName', 'VARCHAR', true, 255, null);
		$this->addColumn('EVR', 'Evr', 'VARCHAR', true, 255, null);
		$this->addColumn('VERSION', 'Version', 'VARCHAR', true, 255, null);
		$this->addColumn('RELEASE', 'Release', 'VARCHAR', true, 255, null);
		$this->addColumn('SUMMARY', 'Summary', 'VARCHAR', true, 255, null);
		$this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', true, null, null);
		$this->addColumn('URL', 'Url', 'LONGVARCHAR', true, null, null);
		$this->addColumn('RPM_PKGID', 'RpmPkgid', 'CHAR', true, 32, null);
		$this->addColumn('BUILD_TIME', 'BuildTime', 'TIMESTAMP', true, null, null);
		$this->addColumn('SIZE', 'Size', 'INTEGER', true, null, null);
		$this->addColumn('REALARCH', 'Realarch', 'VARCHAR', true, 45, null);
		$this->addForeignKey('ARCH_ID', 'ArchId', 'INTEGER', 'arch', 'ID', true, null, null);
		$this->addColumn('IS_SOURCE', 'IsSource', 'BOOLEAN', true, null, null);
		$this->addForeignKey('SOURCE_RPM_ID', 'SourceRpmId', 'INTEGER', 'rpm', 'ID', false, null, null);
		$this->addColumn('SOURCE_RPM_NAME', 'SourceRpmName', 'VARCHAR', false, 900, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Package', 'Package', RelationMap::MANY_TO_ONE, array('package_id' => 'id', ), null, null);
    $this->addRelation('Distrelease', 'Distrelease', RelationMap::MANY_TO_ONE, array('distrelease_id' => 'id', ), null, null);
    $this->addRelation('Media', 'Media', RelationMap::MANY_TO_ONE, array('media_id' => 'id', ), null, null);
    $this->addRelation('RpmGroup', 'RpmGroup', RelationMap::MANY_TO_ONE, array('rpm_group_id' => 'id', ), null, null);
    $this->addRelation('Arch', 'Arch', RelationMap::MANY_TO_ONE, array('arch_id' => 'id', ), null, null);
    $this->addRelation('RpmRelatedBySourceRpmId', 'Rpm', RelationMap::MANY_TO_ONE, array('source_rpm_id' => 'id', ), null, null);
    $this->addRelation('RpmRelatedBySourceRpmId', 'Rpm', RelationMap::ONE_TO_MANY, array('id' => 'source_rpm_id', ), null, null);
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
