<?php

/**
 * Base class that represents a row from the 'distrelease' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseDistrelease extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DistreleasePeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the is_meta field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_meta;

	/**
	 * The value for the is_latest field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_latest;

	/**
	 * The value for the is_dev_version field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_dev_version;

	/**
	 * @var        array Rpm[] Collection to store aggregation of Rpm objects.
	 */
	protected $collRpms;

	/**
	 * @var        Criteria The criteria used to select the current contents of collRpms.
	 */
	private $lastRpmCriteria = null;

	/**
	 * @var        array NewVersionRequest[] Collection to store aggregation of NewVersionRequest objects.
	 */
	protected $collNewVersionRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collNewVersionRequests.
	 */
	private $lastNewVersionRequestCriteria = null;

	/**
	 * @var        array NotificationElement[] Collection to store aggregation of NotificationElement objects.
	 */
	protected $collNotificationElements;

	/**
	 * @var        Criteria The criteria used to select the current contents of collNotificationElements.
	 */
	private $lastNotificationElementCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_meta = false;
		$this->is_latest = false;
		$this->is_dev_version = false;
	}

	/**
	 * Initializes internal state of BaseDistrelease object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [is_meta] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsMeta()
	{
		return $this->is_meta;
	}

	/**
	 * Get the [is_latest] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsLatest()
	{
		return $this->is_latest;
	}

	/**
	 * Get the [is_dev_version] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsDevVersion()
	{
		return $this->is_dev_version;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Distrelease The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = DistreleasePeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     Distrelease The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = DistreleasePeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [is_meta] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Distrelease The current object (for fluent API support)
	 */
	public function setIsMeta($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_meta !== $v || $this->isNew()) {
			$this->is_meta = $v;
			$this->modifiedColumns[] = DistreleasePeer::IS_META;
		}

		return $this;
	} // setIsMeta()

	/**
	 * Set the value of [is_latest] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Distrelease The current object (for fluent API support)
	 */
	public function setIsLatest($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_latest !== $v || $this->isNew()) {
			$this->is_latest = $v;
			$this->modifiedColumns[] = DistreleasePeer::IS_LATEST;
		}

		return $this;
	} // setIsLatest()

	/**
	 * Set the value of [is_dev_version] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Distrelease The current object (for fluent API support)
	 */
	public function setIsDevVersion($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_dev_version !== $v || $this->isNew()) {
			$this->is_dev_version = $v;
			$this->modifiedColumns[] = DistreleasePeer::IS_DEV_VERSION;
		}

		return $this;
	} // setIsDevVersion()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->is_meta !== false) {
				return false;
			}

			if ($this->is_latest !== false) {
				return false;
			}

			if ($this->is_dev_version !== false) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->is_meta = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
			$this->is_latest = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
			$this->is_dev_version = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 5; // 5 = DistreleasePeer::NUM_COLUMNS - DistreleasePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Distrelease object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DistreleasePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = DistreleasePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collRpms = null;
			$this->lastRpmCriteria = null;

			$this->collNewVersionRequests = null;
			$this->lastNewVersionRequestCriteria = null;

			$this->collNotificationElements = null;
			$this->lastNotificationElementCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DistreleasePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			if ($ret) {
				DistreleasePeer::doDelete($this, $con);
				$this->postDelete($con);
				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DistreleasePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				DistreleasePeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			if ($this->isNew() ) {
				$this->modifiedColumns[] = DistreleasePeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DistreleasePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DistreleasePeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collRpms !== null) {
				foreach ($this->collRpms as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collNewVersionRequests !== null) {
				foreach ($this->collNewVersionRequests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collNotificationElements !== null) {
				foreach ($this->collNotificationElements as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = DistreleasePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collRpms !== null) {
					foreach ($this->collRpms as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collNewVersionRequests !== null) {
					foreach ($this->collNewVersionRequests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collNotificationElements !== null) {
					foreach ($this->collNotificationElements as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DistreleasePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getIsMeta();
				break;
			case 3:
				return $this->getIsLatest();
				break;
			case 4:
				return $this->getIsDevVersion();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = DistreleasePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getIsMeta(),
			$keys[3] => $this->getIsLatest(),
			$keys[4] => $this->getIsDevVersion(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DistreleasePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setIsMeta($value);
				break;
			case 3:
				$this->setIsLatest($value);
				break;
			case 4:
				$this->setIsDevVersion($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DistreleasePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsMeta($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsLatest($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIsDevVersion($arr[$keys[4]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);

		if ($this->isColumnModified(DistreleasePeer::ID)) $criteria->add(DistreleasePeer::ID, $this->id);
		if ($this->isColumnModified(DistreleasePeer::NAME)) $criteria->add(DistreleasePeer::NAME, $this->name);
		if ($this->isColumnModified(DistreleasePeer::IS_META)) $criteria->add(DistreleasePeer::IS_META, $this->is_meta);
		if ($this->isColumnModified(DistreleasePeer::IS_LATEST)) $criteria->add(DistreleasePeer::IS_LATEST, $this->is_latest);
		if ($this->isColumnModified(DistreleasePeer::IS_DEV_VERSION)) $criteria->add(DistreleasePeer::IS_DEV_VERSION, $this->is_dev_version);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);

		$criteria->add(DistreleasePeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Distrelease (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setIsMeta($this->is_meta);

		$copyObj->setIsLatest($this->is_latest);

		$copyObj->setIsDevVersion($this->is_dev_version);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getRpms() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRpm($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getNewVersionRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addNewVersionRequest($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getNotificationElements() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addNotificationElement($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Distrelease Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     DistreleasePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DistreleasePeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collRpms collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRpms()
	 */
	public function clearRpms()
	{
		$this->collRpms = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRpms collection (array).
	 *
	 * By default this just sets the collRpms collection to an empty array (like clearcollRpms());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initRpms()
	{
		$this->collRpms = array();
	}

	/**
	 * Gets an array of Rpm objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Distrelease has previously been saved, it will retrieve
	 * related Rpms from storage. If this Distrelease is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Rpm[]
	 * @throws     PropelException
	 */
	public function getRpms($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
			   $this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				RpmPeer::addSelectColumns($criteria);
				$this->collRpms = RpmPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				RpmPeer::addSelectColumns($criteria);
				if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
					$this->collRpms = RpmPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRpmCriteria = $criteria;
		return $this->collRpms;
	}

	/**
	 * Returns the number of related Rpm objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Rpm objects.
	 * @throws     PropelException
	 */
	public function countRpms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				$count = RpmPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
					$count = RpmPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collRpms);
				}
			} else {
				$count = count($this->collRpms);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Rpm object to this object
	 * through the Rpm foreign key attribute.
	 *
	 * @param      Rpm $l Rpm
	 * @return     void
	 * @throws     PropelException
	 */
	public function addRpm(Rpm $l)
	{
		if ($this->collRpms === null) {
			$this->initRpms();
		}
		if (!in_array($l, $this->collRpms, true)) { // only add it if the **same** object is not already associated
			array_push($this->collRpms, $l);
			$l->setDistrelease($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getRpmsJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
				$this->collRpms = RpmPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmCriteria = $criteria;

		return $this->collRpms;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getRpmsJoinMedia($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
				$this->collRpms = RpmPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmCriteria = $criteria;

		return $this->collRpms;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getRpmsJoinRpmGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
				$this->collRpms = RpmPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmCriteria = $criteria;

		return $this->collRpms;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getRpmsJoinArch($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
				$this->collRpms = RpmPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmCriteria = $criteria;

		return $this->collRpms;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getRpmsJoinRpmRelatedBySourceRpmId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinRpmRelatedBySourceRpmId($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
				$this->collRpms = RpmPeer::doSelectJoinRpmRelatedBySourceRpmId($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmCriteria = $criteria;

		return $this->collRpms;
	}

	/**
	 * Clears out the collNewVersionRequests collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addNewVersionRequests()
	 */
	public function clearNewVersionRequests()
	{
		$this->collNewVersionRequests = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collNewVersionRequests collection (array).
	 *
	 * By default this just sets the collNewVersionRequests collection to an empty array (like clearcollNewVersionRequests());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initNewVersionRequests()
	{
		$this->collNewVersionRequests = array();
	}

	/**
	 * Gets an array of NewVersionRequest objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Distrelease has previously been saved, it will retrieve
	 * related NewVersionRequests from storage. If this Distrelease is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array NewVersionRequest[]
	 * @throws     PropelException
	 */
	public function getNewVersionRequests($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
			   $this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

				NewVersionRequestPeer::addSelectColumns($criteria);
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

				NewVersionRequestPeer::addSelectColumns($criteria);
				if (!isset($this->lastNewVersionRequestCriteria) || !$this->lastNewVersionRequestCriteria->equals($criteria)) {
					$this->collNewVersionRequests = NewVersionRequestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNewVersionRequestCriteria = $criteria;
		return $this->collNewVersionRequests;
	}

	/**
	 * Returns the number of related NewVersionRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related NewVersionRequest objects.
	 * @throws     PropelException
	 */
	public function countNewVersionRequests(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

				$count = NewVersionRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

				if (!isset($this->lastNewVersionRequestCriteria) || !$this->lastNewVersionRequestCriteria->equals($criteria)) {
					$count = NewVersionRequestPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collNewVersionRequests);
				}
			} else {
				$count = count($this->collNewVersionRequests);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a NewVersionRequest object to this object
	 * through the NewVersionRequest foreign key attribute.
	 *
	 * @param      NewVersionRequest $l NewVersionRequest
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNewVersionRequest(NewVersionRequest $l)
	{
		if ($this->collNewVersionRequests === null) {
			$this->initNewVersionRequests();
		}
		if (!in_array($l, $this->collNewVersionRequests, true)) { // only add it if the **same** object is not already associated
			array_push($this->collNewVersionRequests, $l);
			$l->setDistrelease($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related NewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getNewVersionRequestsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastNewVersionRequestCriteria) || !$this->lastNewVersionRequestCriteria->equals($criteria)) {
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastNewVersionRequestCriteria = $criteria;

		return $this->collNewVersionRequests;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related NewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getNewVersionRequestsJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastNewVersionRequestCriteria) || !$this->lastNewVersionRequestCriteria->equals($criteria)) {
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastNewVersionRequestCriteria = $criteria;

		return $this->collNewVersionRequests;
	}

	/**
	 * Clears out the collNotificationElements collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addNotificationElements()
	 */
	public function clearNotificationElements()
	{
		$this->collNotificationElements = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collNotificationElements collection (array).
	 *
	 * By default this just sets the collNotificationElements collection to an empty array (like clearcollNotificationElements());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initNotificationElements()
	{
		$this->collNotificationElements = array();
	}

	/**
	 * Gets an array of NotificationElement objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Distrelease has previously been saved, it will retrieve
	 * related NotificationElements from storage. If this Distrelease is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array NotificationElement[]
	 * @throws     PropelException
	 */
	public function getNotificationElements($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotificationElements === null) {
			if ($this->isNew()) {
			   $this->collNotificationElements = array();
			} else {

				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				NotificationElementPeer::addSelectColumns($criteria);
				$this->collNotificationElements = NotificationElementPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				NotificationElementPeer::addSelectColumns($criteria);
				if (!isset($this->lastNotificationElementCriteria) || !$this->lastNotificationElementCriteria->equals($criteria)) {
					$this->collNotificationElements = NotificationElementPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNotificationElementCriteria = $criteria;
		return $this->collNotificationElements;
	}

	/**
	 * Returns the number of related NotificationElement objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related NotificationElement objects.
	 * @throws     PropelException
	 */
	public function countNotificationElements(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collNotificationElements === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				$count = NotificationElementPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				if (!isset($this->lastNotificationElementCriteria) || !$this->lastNotificationElementCriteria->equals($criteria)) {
					$count = NotificationElementPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collNotificationElements);
				}
			} else {
				$count = count($this->collNotificationElements);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a NotificationElement object to this object
	 * through the NotificationElement foreign key attribute.
	 *
	 * @param      NotificationElement $l NotificationElement
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNotificationElement(NotificationElement $l)
	{
		if ($this->collNotificationElements === null) {
			$this->initNotificationElements();
		}
		if (!in_array($l, $this->collNotificationElements, true)) { // only add it if the **same** object is not already associated
			array_push($this->collNotificationElements, $l);
			$l->setDistrelease($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related NotificationElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getNotificationElementsJoinNotification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotificationElements === null) {
			if ($this->isNew()) {
				$this->collNotificationElements = array();
			} else {

				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				$this->collNotificationElements = NotificationElementPeer::doSelectJoinNotification($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastNotificationElementCriteria) || !$this->lastNotificationElementCriteria->equals($criteria)) {
				$this->collNotificationElements = NotificationElementPeer::doSelectJoinNotification($criteria, $con, $join_behavior);
			}
		}
		$this->lastNotificationElementCriteria = $criteria;

		return $this->collNotificationElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related NotificationElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getNotificationElementsJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotificationElements === null) {
			if ($this->isNew()) {
				$this->collNotificationElements = array();
			} else {

				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				$this->collNotificationElements = NotificationElementPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastNotificationElementCriteria) || !$this->lastNotificationElementCriteria->equals($criteria)) {
				$this->collNotificationElements = NotificationElementPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastNotificationElementCriteria = $criteria;

		return $this->collNotificationElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related NotificationElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getNotificationElementsJoinRpmGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotificationElements === null) {
			if ($this->isNew()) {
				$this->collNotificationElements = array();
			} else {

				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				$this->collNotificationElements = NotificationElementPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastNotificationElementCriteria) || !$this->lastNotificationElementCriteria->equals($criteria)) {
				$this->collNotificationElements = NotificationElementPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		}
		$this->lastNotificationElementCriteria = $criteria;

		return $this->collNotificationElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related NotificationElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getNotificationElementsJoinArch($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotificationElements === null) {
			if ($this->isNew()) {
				$this->collNotificationElements = array();
			} else {

				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				$this->collNotificationElements = NotificationElementPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastNotificationElementCriteria) || !$this->lastNotificationElementCriteria->equals($criteria)) {
				$this->collNotificationElements = NotificationElementPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		}
		$this->lastNotificationElementCriteria = $criteria;

		return $this->collNotificationElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Distrelease is new, it will return
	 * an empty collection; or if this Distrelease has previously
	 * been saved, it will retrieve related NotificationElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Distrelease.
	 */
	public function getNotificationElementsJoinMedia($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DistreleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotificationElements === null) {
			if ($this->isNew()) {
				$this->collNotificationElements = array();
			} else {

				$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

				$this->collNotificationElements = NotificationElementPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->id);

			if (!isset($this->lastNotificationElementCriteria) || !$this->lastNotificationElementCriteria->equals($criteria)) {
				$this->collNotificationElements = NotificationElementPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		}
		$this->lastNotificationElementCriteria = $criteria;

		return $this->collNotificationElements;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collRpms) {
				foreach ((array) $this->collRpms as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collNewVersionRequests) {
				foreach ((array) $this->collNewVersionRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collNotificationElements) {
				foreach ((array) $this->collNotificationElements as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collRpms = null;
		$this->collNewVersionRequests = null;
		$this->collNotificationElements = null;
	}

} // BaseDistrelease
