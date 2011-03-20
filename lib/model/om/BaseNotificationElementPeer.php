<?php

/**
 * Base static class for performing query and update operations on the 'notification_element' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseNotificationElementPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'notification_element';

	/** the related Propel class for this table */
	const OM_CLASS = 'NotificationElement';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.NotificationElement';

	/** the related TableMap class for this table */
	const TM_CLASS = 'NotificationElementTableMap';
	
	/** The total number of columns. */
	const NUM_COLUMNS = 7;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the ID field */
	const ID = 'notification_element.ID';

	/** the column name for the NOTIFICATION_ID field */
	const NOTIFICATION_ID = 'notification_element.NOTIFICATION_ID';

	/** the column name for the PACKAGE_ID field */
	const PACKAGE_ID = 'notification_element.PACKAGE_ID';

	/** the column name for the RPM_GROUP_ID field */
	const RPM_GROUP_ID = 'notification_element.RPM_GROUP_ID';

	/** the column name for the DISTRELEASE_ID field */
	const DISTRELEASE_ID = 'notification_element.DISTRELEASE_ID';

	/** the column name for the ARCH_ID field */
	const ARCH_ID = 'notification_element.ARCH_ID';

	/** the column name for the MEDIA_ID field */
	const MEDIA_ID = 'notification_element.MEDIA_ID';

	/**
	 * An identiy map to hold any loaded instances of NotificationElement objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array NotificationElement[]
	 */
	public static $instances = array();


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'NotificationId', 'PackageId', 'RpmGroupId', 'DistreleaseId', 'ArchId', 'MediaId', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'notificationId', 'packageId', 'rpmGroupId', 'distreleaseId', 'archId', 'mediaId', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::NOTIFICATION_ID, self::PACKAGE_ID, self::RPM_GROUP_ID, self::DISTRELEASE_ID, self::ARCH_ID, self::MEDIA_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'notification_id', 'package_id', 'rpm_group_id', 'distrelease_id', 'arch_id', 'media_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'NotificationId' => 1, 'PackageId' => 2, 'RpmGroupId' => 3, 'DistreleaseId' => 4, 'ArchId' => 5, 'MediaId' => 6, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'notificationId' => 1, 'packageId' => 2, 'rpmGroupId' => 3, 'distreleaseId' => 4, 'archId' => 5, 'mediaId' => 6, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::NOTIFICATION_ID => 1, self::PACKAGE_ID => 2, self::RPM_GROUP_ID => 3, self::DISTRELEASE_ID => 4, self::ARCH_ID => 5, self::MEDIA_ID => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'notification_id' => 1, 'package_id' => 2, 'rpm_group_id' => 3, 'distrelease_id' => 4, 'arch_id' => 5, 'media_id' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. NotificationElementPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(NotificationElementPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{
		$criteria->addSelectColumn(NotificationElementPeer::ID);
		$criteria->addSelectColumn(NotificationElementPeer::NOTIFICATION_ID);
		$criteria->addSelectColumn(NotificationElementPeer::PACKAGE_ID);
		$criteria->addSelectColumn(NotificationElementPeer::RPM_GROUP_ID);
		$criteria->addSelectColumn(NotificationElementPeer::DISTRELEASE_ID);
		$criteria->addSelectColumn(NotificationElementPeer::ARCH_ID);
		$criteria->addSelectColumn(NotificationElementPeer::MEDIA_ID);
	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     NotificationElement
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = NotificationElementPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return NotificationElementPeer::populateObjects(NotificationElementPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			NotificationElementPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      NotificationElement $value A NotificationElement object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(NotificationElement $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A NotificationElement object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof NotificationElement) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or NotificationElement object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     NotificationElement Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Method to invalidate the instance pool of all tables related to notification_element
	 * by a foreign key with ON DELETE CASCADE
	 */
	public static function clearRelatedInstancePool()
	{
	}

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol] === null) {
			return null;
		}
		return (string) $row[$startcol];
	}

	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = NotificationElementPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = NotificationElementPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				NotificationElementPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining the related Notification table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinNotification(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Package table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinPackage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related RpmGroup table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinRpmGroup(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Distrelease table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDistrelease(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Arch table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinArch(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Media table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinMedia(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with their Notification objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinNotification(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);
		NotificationPeer::addSelectColumns($criteria);

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = NotificationPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = NotificationPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = NotificationPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					NotificationPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded
				
				// Add the $obj1 (NotificationElement) to $obj2 (Notification)
				$obj2->addNotificationElement($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with their Package objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinPackage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);
		PackagePeer::addSelectColumns($criteria);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = PackagePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = PackagePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = PackagePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					PackagePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded
				
				// Add the $obj1 (NotificationElement) to $obj2 (Package)
				$obj2->addNotificationElement($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with their RpmGroup objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinRpmGroup(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);
		RpmGroupPeer::addSelectColumns($criteria);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = RpmGroupPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = RpmGroupPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = RpmGroupPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					RpmGroupPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded
				
				// Add the $obj1 (NotificationElement) to $obj2 (RpmGroup)
				$obj2->addNotificationElement($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with their Distrelease objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDistrelease(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);
		DistreleasePeer::addSelectColumns($criteria);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = DistreleasePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = DistreleasePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = DistreleasePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					DistreleasePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded
				
				// Add the $obj1 (NotificationElement) to $obj2 (Distrelease)
				$obj2->addNotificationElement($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with their Arch objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinArch(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);
		ArchPeer::addSelectColumns($criteria);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = ArchPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = ArchPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = ArchPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					ArchPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded
				
				// Add the $obj1 (NotificationElement) to $obj2 (Arch)
				$obj2->addNotificationElement($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with their Media objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinMedia(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);
		MediaPeer::addSelectColumns($criteria);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = MediaPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = MediaPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = MediaPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					MediaPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded
				
				// Add the $obj1 (NotificationElement) to $obj2 (Media)
				$obj2->addNotificationElement($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}

	/**
	 * Selects a collection of NotificationElement objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol2 = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);

		NotificationPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (NotificationPeer::NUM_COLUMNS - NotificationPeer::NUM_LAZY_LOAD_COLUMNS);

		PackagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + (PackagePeer::NUM_COLUMNS - PackagePeer::NUM_LAZY_LOAD_COLUMNS);

		RpmGroupPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + (RpmGroupPeer::NUM_COLUMNS - RpmGroupPeer::NUM_LAZY_LOAD_COLUMNS);

		DistreleasePeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + (DistreleasePeer::NUM_COLUMNS - DistreleasePeer::NUM_LAZY_LOAD_COLUMNS);

		ArchPeer::addSelectColumns($criteria);
		$startcol7 = $startcol6 + (ArchPeer::NUM_COLUMNS - ArchPeer::NUM_LAZY_LOAD_COLUMNS);

		MediaPeer::addSelectColumns($criteria);
		$startcol8 = $startcol7 + (MediaPeer::NUM_COLUMNS - MediaPeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

			// Add objects for joined Notification rows

			$key2 = NotificationPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = NotificationPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = NotificationPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					NotificationPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj2 (Notification)
				$obj2->addNotificationElement($obj1);
			} // if joined row not null

			// Add objects for joined Package rows

			$key3 = PackagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = PackagePeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$cls = PackagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PackagePeer::addInstanceToPool($obj3, $key3);
				} // if obj3 loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj3 (Package)
				$obj3->addNotificationElement($obj1);
			} // if joined row not null

			// Add objects for joined RpmGroup rows

			$key4 = RpmGroupPeer::getPrimaryKeyHashFromRow($row, $startcol4);
			if ($key4 !== null) {
				$obj4 = RpmGroupPeer::getInstanceFromPool($key4);
				if (!$obj4) {

					$cls = RpmGroupPeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					RpmGroupPeer::addInstanceToPool($obj4, $key4);
				} // if obj4 loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj4 (RpmGroup)
				$obj4->addNotificationElement($obj1);
			} // if joined row not null

			// Add objects for joined Distrelease rows

			$key5 = DistreleasePeer::getPrimaryKeyHashFromRow($row, $startcol5);
			if ($key5 !== null) {
				$obj5 = DistreleasePeer::getInstanceFromPool($key5);
				if (!$obj5) {

					$cls = DistreleasePeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					DistreleasePeer::addInstanceToPool($obj5, $key5);
				} // if obj5 loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj5 (Distrelease)
				$obj5->addNotificationElement($obj1);
			} // if joined row not null

			// Add objects for joined Arch rows

			$key6 = ArchPeer::getPrimaryKeyHashFromRow($row, $startcol6);
			if ($key6 !== null) {
				$obj6 = ArchPeer::getInstanceFromPool($key6);
				if (!$obj6) {

					$cls = ArchPeer::getOMClass(false);

					$obj6 = new $cls();
					$obj6->hydrate($row, $startcol6);
					ArchPeer::addInstanceToPool($obj6, $key6);
				} // if obj6 loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj6 (Arch)
				$obj6->addNotificationElement($obj1);
			} // if joined row not null

			// Add objects for joined Media rows

			$key7 = MediaPeer::getPrimaryKeyHashFromRow($row, $startcol7);
			if ($key7 !== null) {
				$obj7 = MediaPeer::getInstanceFromPool($key7);
				if (!$obj7) {

					$cls = MediaPeer::getOMClass(false);

					$obj7 = new $cls();
					$obj7->hydrate($row, $startcol7);
					MediaPeer::addInstanceToPool($obj7, $key7);
				} // if obj7 loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj7 (Media)
				$obj7->addNotificationElement($obj1);
			} // if joined row not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Notification table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptNotification(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Package table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptPackage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related RpmGroup table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptRpmGroup(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Distrelease table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDistrelease(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Arch table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptArch(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Media table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptMedia(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(NotificationElementPeer::TABLE_NAME);
		
		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			NotificationElementPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY should not affect count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with all related objects except Notification.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptNotification(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol2 = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);

		PackagePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (PackagePeer::NUM_COLUMNS - PackagePeer::NUM_LAZY_LOAD_COLUMNS);

		RpmGroupPeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + (RpmGroupPeer::NUM_COLUMNS - RpmGroupPeer::NUM_LAZY_LOAD_COLUMNS);

		DistreleasePeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + (DistreleasePeer::NUM_COLUMNS - DistreleasePeer::NUM_LAZY_LOAD_COLUMNS);

		ArchPeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + (ArchPeer::NUM_COLUMNS - ArchPeer::NUM_LAZY_LOAD_COLUMNS);

		MediaPeer::addSelectColumns($criteria);
		$startcol7 = $startcol6 + (MediaPeer::NUM_COLUMNS - MediaPeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Package rows

				$key2 = PackagePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = PackagePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = PackagePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					PackagePeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj2 (Package)
				$obj2->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined RpmGroup rows

				$key3 = RpmGroupPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = RpmGroupPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = RpmGroupPeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					RpmGroupPeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj3 (RpmGroup)
				$obj3->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Distrelease rows

				$key4 = DistreleasePeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = DistreleasePeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = DistreleasePeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					DistreleasePeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj4 (Distrelease)
				$obj4->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Arch rows

				$key5 = ArchPeer::getPrimaryKeyHashFromRow($row, $startcol5);
				if ($key5 !== null) {
					$obj5 = ArchPeer::getInstanceFromPool($key5);
					if (!$obj5) {
	
						$cls = ArchPeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					ArchPeer::addInstanceToPool($obj5, $key5);
				} // if $obj5 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj5 (Arch)
				$obj5->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Media rows

				$key6 = MediaPeer::getPrimaryKeyHashFromRow($row, $startcol6);
				if ($key6 !== null) {
					$obj6 = MediaPeer::getInstanceFromPool($key6);
					if (!$obj6) {
	
						$cls = MediaPeer::getOMClass(false);

					$obj6 = new $cls();
					$obj6->hydrate($row, $startcol6);
					MediaPeer::addInstanceToPool($obj6, $key6);
				} // if $obj6 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj6 (Media)
				$obj6->addNotificationElement($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with all related objects except Package.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptPackage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol2 = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);

		NotificationPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (NotificationPeer::NUM_COLUMNS - NotificationPeer::NUM_LAZY_LOAD_COLUMNS);

		RpmGroupPeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + (RpmGroupPeer::NUM_COLUMNS - RpmGroupPeer::NUM_LAZY_LOAD_COLUMNS);

		DistreleasePeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + (DistreleasePeer::NUM_COLUMNS - DistreleasePeer::NUM_LAZY_LOAD_COLUMNS);

		ArchPeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + (ArchPeer::NUM_COLUMNS - ArchPeer::NUM_LAZY_LOAD_COLUMNS);

		MediaPeer::addSelectColumns($criteria);
		$startcol7 = $startcol6 + (MediaPeer::NUM_COLUMNS - MediaPeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Notification rows

				$key2 = NotificationPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = NotificationPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = NotificationPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					NotificationPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj2 (Notification)
				$obj2->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined RpmGroup rows

				$key3 = RpmGroupPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = RpmGroupPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = RpmGroupPeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					RpmGroupPeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj3 (RpmGroup)
				$obj3->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Distrelease rows

				$key4 = DistreleasePeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = DistreleasePeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = DistreleasePeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					DistreleasePeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj4 (Distrelease)
				$obj4->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Arch rows

				$key5 = ArchPeer::getPrimaryKeyHashFromRow($row, $startcol5);
				if ($key5 !== null) {
					$obj5 = ArchPeer::getInstanceFromPool($key5);
					if (!$obj5) {
	
						$cls = ArchPeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					ArchPeer::addInstanceToPool($obj5, $key5);
				} // if $obj5 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj5 (Arch)
				$obj5->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Media rows

				$key6 = MediaPeer::getPrimaryKeyHashFromRow($row, $startcol6);
				if ($key6 !== null) {
					$obj6 = MediaPeer::getInstanceFromPool($key6);
					if (!$obj6) {
	
						$cls = MediaPeer::getOMClass(false);

					$obj6 = new $cls();
					$obj6->hydrate($row, $startcol6);
					MediaPeer::addInstanceToPool($obj6, $key6);
				} // if $obj6 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj6 (Media)
				$obj6->addNotificationElement($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with all related objects except RpmGroup.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptRpmGroup(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol2 = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);

		NotificationPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (NotificationPeer::NUM_COLUMNS - NotificationPeer::NUM_LAZY_LOAD_COLUMNS);

		PackagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + (PackagePeer::NUM_COLUMNS - PackagePeer::NUM_LAZY_LOAD_COLUMNS);

		DistreleasePeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + (DistreleasePeer::NUM_COLUMNS - DistreleasePeer::NUM_LAZY_LOAD_COLUMNS);

		ArchPeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + (ArchPeer::NUM_COLUMNS - ArchPeer::NUM_LAZY_LOAD_COLUMNS);

		MediaPeer::addSelectColumns($criteria);
		$startcol7 = $startcol6 + (MediaPeer::NUM_COLUMNS - MediaPeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Notification rows

				$key2 = NotificationPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = NotificationPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = NotificationPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					NotificationPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj2 (Notification)
				$obj2->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Package rows

				$key3 = PackagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = PackagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = PackagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PackagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj3 (Package)
				$obj3->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Distrelease rows

				$key4 = DistreleasePeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = DistreleasePeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = DistreleasePeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					DistreleasePeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj4 (Distrelease)
				$obj4->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Arch rows

				$key5 = ArchPeer::getPrimaryKeyHashFromRow($row, $startcol5);
				if ($key5 !== null) {
					$obj5 = ArchPeer::getInstanceFromPool($key5);
					if (!$obj5) {
	
						$cls = ArchPeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					ArchPeer::addInstanceToPool($obj5, $key5);
				} // if $obj5 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj5 (Arch)
				$obj5->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Media rows

				$key6 = MediaPeer::getPrimaryKeyHashFromRow($row, $startcol6);
				if ($key6 !== null) {
					$obj6 = MediaPeer::getInstanceFromPool($key6);
					if (!$obj6) {
	
						$cls = MediaPeer::getOMClass(false);

					$obj6 = new $cls();
					$obj6->hydrate($row, $startcol6);
					MediaPeer::addInstanceToPool($obj6, $key6);
				} // if $obj6 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj6 (Media)
				$obj6->addNotificationElement($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with all related objects except Distrelease.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDistrelease(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol2 = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);

		NotificationPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (NotificationPeer::NUM_COLUMNS - NotificationPeer::NUM_LAZY_LOAD_COLUMNS);

		PackagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + (PackagePeer::NUM_COLUMNS - PackagePeer::NUM_LAZY_LOAD_COLUMNS);

		RpmGroupPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + (RpmGroupPeer::NUM_COLUMNS - RpmGroupPeer::NUM_LAZY_LOAD_COLUMNS);

		ArchPeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + (ArchPeer::NUM_COLUMNS - ArchPeer::NUM_LAZY_LOAD_COLUMNS);

		MediaPeer::addSelectColumns($criteria);
		$startcol7 = $startcol6 + (MediaPeer::NUM_COLUMNS - MediaPeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Notification rows

				$key2 = NotificationPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = NotificationPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = NotificationPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					NotificationPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj2 (Notification)
				$obj2->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Package rows

				$key3 = PackagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = PackagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = PackagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PackagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj3 (Package)
				$obj3->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined RpmGroup rows

				$key4 = RpmGroupPeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = RpmGroupPeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = RpmGroupPeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					RpmGroupPeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj4 (RpmGroup)
				$obj4->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Arch rows

				$key5 = ArchPeer::getPrimaryKeyHashFromRow($row, $startcol5);
				if ($key5 !== null) {
					$obj5 = ArchPeer::getInstanceFromPool($key5);
					if (!$obj5) {
	
						$cls = ArchPeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					ArchPeer::addInstanceToPool($obj5, $key5);
				} // if $obj5 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj5 (Arch)
				$obj5->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Media rows

				$key6 = MediaPeer::getPrimaryKeyHashFromRow($row, $startcol6);
				if ($key6 !== null) {
					$obj6 = MediaPeer::getInstanceFromPool($key6);
					if (!$obj6) {
	
						$cls = MediaPeer::getOMClass(false);

					$obj6 = new $cls();
					$obj6->hydrate($row, $startcol6);
					MediaPeer::addInstanceToPool($obj6, $key6);
				} // if $obj6 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj6 (Media)
				$obj6->addNotificationElement($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with all related objects except Arch.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptArch(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol2 = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);

		NotificationPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (NotificationPeer::NUM_COLUMNS - NotificationPeer::NUM_LAZY_LOAD_COLUMNS);

		PackagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + (PackagePeer::NUM_COLUMNS - PackagePeer::NUM_LAZY_LOAD_COLUMNS);

		RpmGroupPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + (RpmGroupPeer::NUM_COLUMNS - RpmGroupPeer::NUM_LAZY_LOAD_COLUMNS);

		DistreleasePeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + (DistreleasePeer::NUM_COLUMNS - DistreleasePeer::NUM_LAZY_LOAD_COLUMNS);

		MediaPeer::addSelectColumns($criteria);
		$startcol7 = $startcol6 + (MediaPeer::NUM_COLUMNS - MediaPeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::MEDIA_ID, MediaPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Notification rows

				$key2 = NotificationPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = NotificationPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = NotificationPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					NotificationPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj2 (Notification)
				$obj2->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Package rows

				$key3 = PackagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = PackagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = PackagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PackagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj3 (Package)
				$obj3->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined RpmGroup rows

				$key4 = RpmGroupPeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = RpmGroupPeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = RpmGroupPeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					RpmGroupPeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj4 (RpmGroup)
				$obj4->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Distrelease rows

				$key5 = DistreleasePeer::getPrimaryKeyHashFromRow($row, $startcol5);
				if ($key5 !== null) {
					$obj5 = DistreleasePeer::getInstanceFromPool($key5);
					if (!$obj5) {
	
						$cls = DistreleasePeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					DistreleasePeer::addInstanceToPool($obj5, $key5);
				} // if $obj5 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj5 (Distrelease)
				$obj5->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Media rows

				$key6 = MediaPeer::getPrimaryKeyHashFromRow($row, $startcol6);
				if ($key6 !== null) {
					$obj6 = MediaPeer::getInstanceFromPool($key6);
					if (!$obj6) {
	
						$cls = MediaPeer::getOMClass(false);

					$obj6 = new $cls();
					$obj6->hydrate($row, $startcol6);
					MediaPeer::addInstanceToPool($obj6, $key6);
				} // if $obj6 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj6 (Media)
				$obj6->addNotificationElement($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of NotificationElement objects pre-filled with all related objects except Media.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of NotificationElement objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptMedia(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		NotificationElementPeer::addSelectColumns($criteria);
		$startcol2 = (NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS);

		NotificationPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (NotificationPeer::NUM_COLUMNS - NotificationPeer::NUM_LAZY_LOAD_COLUMNS);

		PackagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + (PackagePeer::NUM_COLUMNS - PackagePeer::NUM_LAZY_LOAD_COLUMNS);

		RpmGroupPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + (RpmGroupPeer::NUM_COLUMNS - RpmGroupPeer::NUM_LAZY_LOAD_COLUMNS);

		DistreleasePeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + (DistreleasePeer::NUM_COLUMNS - DistreleasePeer::NUM_LAZY_LOAD_COLUMNS);

		ArchPeer::addSelectColumns($criteria);
		$startcol7 = $startcol6 + (ArchPeer::NUM_COLUMNS - ArchPeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(NotificationElementPeer::NOTIFICATION_ID, NotificationPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::PACKAGE_ID, PackagePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::RPM_GROUP_ID, RpmGroupPeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::DISTRELEASE_ID, DistreleasePeer::ID, $join_behavior);

		$criteria->addJoin(NotificationElementPeer::ARCH_ID, ArchPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = NotificationElementPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = NotificationElementPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = NotificationElementPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				NotificationElementPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Notification rows

				$key2 = NotificationPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = NotificationPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = NotificationPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					NotificationPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj2 (Notification)
				$obj2->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Package rows

				$key3 = PackagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = PackagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = PackagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PackagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj3 (Package)
				$obj3->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined RpmGroup rows

				$key4 = RpmGroupPeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = RpmGroupPeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = RpmGroupPeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					RpmGroupPeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj4 (RpmGroup)
				$obj4->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Distrelease rows

				$key5 = DistreleasePeer::getPrimaryKeyHashFromRow($row, $startcol5);
				if ($key5 !== null) {
					$obj5 = DistreleasePeer::getInstanceFromPool($key5);
					if (!$obj5) {
	
						$cls = DistreleasePeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					DistreleasePeer::addInstanceToPool($obj5, $key5);
				} // if $obj5 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj5 (Distrelease)
				$obj5->addNotificationElement($obj1);

			} // if joined row is not null

				// Add objects for joined Arch rows

				$key6 = ArchPeer::getPrimaryKeyHashFromRow($row, $startcol6);
				if ($key6 !== null) {
					$obj6 = ArchPeer::getInstanceFromPool($key6);
					if (!$obj6) {
	
						$cls = ArchPeer::getOMClass(false);

					$obj6 = new $cls();
					$obj6->hydrate($row, $startcol6);
					ArchPeer::addInstanceToPool($obj6, $key6);
				} // if $obj6 already loaded

				// Add the $obj1 (NotificationElement) to the collection in $obj6 (Arch)
				$obj6->addNotificationElement($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}

	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * Add a TableMap instance to the database for this peer class.
	 */
	public static function buildTableMap()
	{
	  $dbMap = Propel::getDatabaseMap(BaseNotificationElementPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BaseNotificationElementPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new NotificationElementTableMap());
	  }
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * If $withPrefix is true, the returned path
	 * uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @param      boolean  Whether or not to return the path wit hthe class name 
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass($withPrefix = true)
	{
		return $withPrefix ? NotificationElementPeer::CLASS_DEFAULT : NotificationElementPeer::OM_CLASS;
	}

	/**
	 * Method perform an INSERT on the database, given a NotificationElement or Criteria object.
	 *
	 * @param      mixed $values Criteria or NotificationElement object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from NotificationElement object
		}

		if ($criteria->containsKey(NotificationElementPeer::ID) && $criteria->keyContainsValue(NotificationElementPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.NotificationElementPeer::ID.')');
		}


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a NotificationElement or Criteria object.
	 *
	 * @param      mixed $values Criteria or NotificationElement object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(NotificationElementPeer::ID);
			$selectCriteria->add(NotificationElementPeer::ID, $criteria->remove(NotificationElementPeer::ID), $comparison);

		} else { // $values is NotificationElement object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Method to DELETE all rows from the notification_element table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(NotificationElementPeer::TABLE_NAME, $con);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			NotificationElementPeer::clearInstancePool();
			NotificationElementPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a NotificationElement or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or NotificationElement object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			NotificationElementPeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof NotificationElement) { // it's a model object
			// invalidate the cache for this single object
			NotificationElementPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(NotificationElementPeer::ID, (array) $values, Criteria::IN);
			// invalidate the cache for this object(s)
			foreach ((array) $values as $singleval) {
				NotificationElementPeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			NotificationElementPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given NotificationElement object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      NotificationElement $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(NotificationElement $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(NotificationElementPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(NotificationElementPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(NotificationElementPeer::DATABASE_NAME, NotificationElementPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     NotificationElement
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = NotificationElementPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(NotificationElementPeer::DATABASE_NAME);
		$criteria->add(NotificationElementPeer::ID, $pk);

		$v = NotificationElementPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(NotificationElementPeer::DATABASE_NAME);
			$criteria->add(NotificationElementPeer::ID, $pks, Criteria::IN);
			$objs = NotificationElementPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseNotificationElementPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseNotificationElementPeer::buildTableMap();

