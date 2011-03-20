<?php


/**
 * This class defines the structure of the 'software_request' table.
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
class SoftwareRequestTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.SoftwareRequestTableMap';

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
		$this->setName('software_request');
		$this->setPhpName('SoftwareRequest');
		$this->setClassname('SoftwareRequest');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
		$this->addColumn('URL', 'Url', 'VARCHAR', true, 2048, null);
		$this->addColumn('TEXT', 'Text', 'LONGVARCHAR', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null, null);
		$this->addColumn('BACKPORT_TO', 'BackportTo', 'LONGVARCHAR', false, null, null);
		$this->addColumn('STATUS', 'Status', 'VARCHAR', true, 45, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('UserHasSoftwareRequest', 'UserHasSoftwareRequest', RelationMap::ONE_TO_MANY, array('id' => 'software_request_id', ), null, null);
    $this->addRelation('UserCommentsSoftwareRequest', 'UserCommentsSoftwareRequest', RelationMap::ONE_TO_MANY, array('id' => 'software_request_id', ), null, null);
	} // buildRelations()

} // SoftwareRequestTableMap
