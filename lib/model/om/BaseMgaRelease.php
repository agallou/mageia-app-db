<?php

/**
 * Base class that represents a row from the 'mga_release' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseMgaRelease extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        MgaReleasePeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the version field.
	 * @var        string
	 */
	protected $version;

	/**
	 * @var        array Rpm[] Collection to store aggregation of Rpm objects.
	 */
	protected $collRpms;

	/**
	 * @var        Criteria The criteria used to select the current contents of collRpms.
	 */
	private $lastRpmCriteria = null;

	/**
	 * @var        array MgaRealeaseGroupHasMgaRelease[] Collection to store aggregation of MgaRealeaseGroupHasMgaRelease objects.
	 */
	protected $collMgaRealeaseGroupHasMgaReleases;

	/**
	 * @var        Criteria The criteria used to select the current contents of collMgaRealeaseGroupHasMgaReleases.
	 */
	private $lastMgaRealeaseGroupHasMgaReleaseCriteria = null;

	/**
	 * @var        array NewVersionRequest[] Collection to store aggregation of NewVersionRequest objects.
	 */
	protected $collNewVersionRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collNewVersionRequests.
	 */
	private $lastNewVersionRequestCriteria = null;

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

	// symfony behavior
	
	const PEER = 'MgaReleasePeer';

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
	 * Get the [version] column value.
	 * 
	 * @return     string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     MgaRelease The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MgaReleasePeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [version] column.
	 * 
	 * @param      string $v new value
	 * @return     MgaRelease The current object (for fluent API support)
	 */
	public function setVersion($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->version !== $v) {
			$this->version = $v;
			$this->modifiedColumns[] = MgaReleasePeer::VERSION;
		}

		return $this;
	} // setVersion()

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
			$this->version = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 2; // 2 = MgaReleasePeer::NUM_COLUMNS - MgaReleasePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating MgaRelease object", $e);
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
			$con = Propel::getConnection(MgaReleasePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = MgaReleasePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collRpms = null;
			$this->lastRpmCriteria = null;

			$this->collMgaRealeaseGroupHasMgaReleases = null;
			$this->lastMgaRealeaseGroupHasMgaReleaseCriteria = null;

			$this->collNewVersionRequests = null;
			$this->lastNewVersionRequestCriteria = null;

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
			$con = Propel::getConnection(MgaReleasePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseMgaRelease:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				MgaReleasePeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseMgaRelease:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

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
			$con = Propel::getConnection(MgaReleasePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseMgaRelease:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

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
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseMgaRelease:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				MgaReleasePeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = MgaReleasePeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MgaReleasePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += MgaReleasePeer::doUpdate($this, $con);
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

			if ($this->collMgaRealeaseGroupHasMgaReleases !== null) {
				foreach ($this->collMgaRealeaseGroupHasMgaReleases as $referrerFK) {
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


			if (($retval = MgaReleasePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collRpms !== null) {
					foreach ($this->collRpms as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMgaRealeaseGroupHasMgaReleases !== null) {
					foreach ($this->collMgaRealeaseGroupHasMgaReleases as $referrerFK) {
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
		$pos = MgaReleasePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getVersion();
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
		$keys = MgaReleasePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getVersion(),
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
		$pos = MgaReleasePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setVersion($value);
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
		$keys = MgaReleasePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setVersion($arr[$keys[1]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);

		if ($this->isColumnModified(MgaReleasePeer::ID)) $criteria->add(MgaReleasePeer::ID, $this->id);
		if ($this->isColumnModified(MgaReleasePeer::VERSION)) $criteria->add(MgaReleasePeer::VERSION, $this->version);

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
		$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);

		$criteria->add(MgaReleasePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of MgaRelease (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setVersion($this->version);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getRpms() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRpm($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getMgaRealeaseGroupHasMgaReleases() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addMgaRealeaseGroupHasMgaRelease($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getNewVersionRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addNewVersionRequest($relObj->copy($deepCopy));
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
	 * @return     MgaRelease Clone of current object.
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
	 * @return     MgaReleasePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MgaReleasePeer();
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
	 * Otherwise if this MgaRelease has previously been saved, it will retrieve
	 * related Rpms from storage. If this MgaRelease is new, it will return
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
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
			   $this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				RpmPeer::addSelectColumns($criteria);
				$this->collRpms = RpmPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

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
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
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

				$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				$count = RpmPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

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
			$l->setMgaRelease($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this MgaRelease is new, it will return
	 * an empty collection; or if this MgaRelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in MgaRelease.
	 */
	public function getRpmsJoinMedia($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

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
	 * Otherwise if this MgaRelease is new, it will return
	 * an empty collection; or if this MgaRelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in MgaRelease.
	 */
	public function getRpmsJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

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
	 * Otherwise if this MgaRelease is new, it will return
	 * an empty collection; or if this MgaRelease has previously
	 * been saved, it will retrieve related Rpms from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in MgaRelease.
	 */
	public function getRpmsJoinRpmGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpms === null) {
			if ($this->isNew()) {
				$this->collRpms = array();
			} else {

				$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				$this->collRpms = RpmPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

			if (!isset($this->lastRpmCriteria) || !$this->lastRpmCriteria->equals($criteria)) {
				$this->collRpms = RpmPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmCriteria = $criteria;

		return $this->collRpms;
	}

	/**
	 * Clears out the collMgaRealeaseGroupHasMgaReleases collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addMgaRealeaseGroupHasMgaReleases()
	 */
	public function clearMgaRealeaseGroupHasMgaReleases()
	{
		$this->collMgaRealeaseGroupHasMgaReleases = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collMgaRealeaseGroupHasMgaReleases collection (array).
	 *
	 * By default this just sets the collMgaRealeaseGroupHasMgaReleases collection to an empty array (like clearcollMgaRealeaseGroupHasMgaReleases());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initMgaRealeaseGroupHasMgaReleases()
	{
		$this->collMgaRealeaseGroupHasMgaReleases = array();
	}

	/**
	 * Gets an array of MgaRealeaseGroupHasMgaRelease objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this MgaRelease has previously been saved, it will retrieve
	 * related MgaRealeaseGroupHasMgaReleases from storage. If this MgaRelease is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array MgaRealeaseGroupHasMgaRelease[]
	 * @throws     PropelException
	 */
	public function getMgaRealeaseGroupHasMgaReleases($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMgaRealeaseGroupHasMgaReleases === null) {
			if ($this->isNew()) {
			   $this->collMgaRealeaseGroupHasMgaReleases = array();
			} else {

				$criteria->add(MgaRealeaseGroupHasMgaReleasePeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				MgaRealeaseGroupHasMgaReleasePeer::addSelectColumns($criteria);
				$this->collMgaRealeaseGroupHasMgaReleases = MgaRealeaseGroupHasMgaReleasePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(MgaRealeaseGroupHasMgaReleasePeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				MgaRealeaseGroupHasMgaReleasePeer::addSelectColumns($criteria);
				if (!isset($this->lastMgaRealeaseGroupHasMgaReleaseCriteria) || !$this->lastMgaRealeaseGroupHasMgaReleaseCriteria->equals($criteria)) {
					$this->collMgaRealeaseGroupHasMgaReleases = MgaRealeaseGroupHasMgaReleasePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMgaRealeaseGroupHasMgaReleaseCriteria = $criteria;
		return $this->collMgaRealeaseGroupHasMgaReleases;
	}

	/**
	 * Returns the number of related MgaRealeaseGroupHasMgaRelease objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related MgaRealeaseGroupHasMgaRelease objects.
	 * @throws     PropelException
	 */
	public function countMgaRealeaseGroupHasMgaReleases(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collMgaRealeaseGroupHasMgaReleases === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(MgaRealeaseGroupHasMgaReleasePeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				$count = MgaRealeaseGroupHasMgaReleasePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(MgaRealeaseGroupHasMgaReleasePeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				if (!isset($this->lastMgaRealeaseGroupHasMgaReleaseCriteria) || !$this->lastMgaRealeaseGroupHasMgaReleaseCriteria->equals($criteria)) {
					$count = MgaRealeaseGroupHasMgaReleasePeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collMgaRealeaseGroupHasMgaReleases);
				}
			} else {
				$count = count($this->collMgaRealeaseGroupHasMgaReleases);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a MgaRealeaseGroupHasMgaRelease object to this object
	 * through the MgaRealeaseGroupHasMgaRelease foreign key attribute.
	 *
	 * @param      MgaRealeaseGroupHasMgaRelease $l MgaRealeaseGroupHasMgaRelease
	 * @return     void
	 * @throws     PropelException
	 */
	public function addMgaRealeaseGroupHasMgaRelease(MgaRealeaseGroupHasMgaRelease $l)
	{
		if ($this->collMgaRealeaseGroupHasMgaReleases === null) {
			$this->initMgaRealeaseGroupHasMgaReleases();
		}
		if (!in_array($l, $this->collMgaRealeaseGroupHasMgaReleases, true)) { // only add it if the **same** object is not already associated
			array_push($this->collMgaRealeaseGroupHasMgaReleases, $l);
			$l->setMgaRelease($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this MgaRelease is new, it will return
	 * an empty collection; or if this MgaRelease has previously
	 * been saved, it will retrieve related MgaRealeaseGroupHasMgaReleases from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in MgaRelease.
	 */
	public function getMgaRealeaseGroupHasMgaReleasesJoinMgaReleaseGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMgaRealeaseGroupHasMgaReleases === null) {
			if ($this->isNew()) {
				$this->collMgaRealeaseGroupHasMgaReleases = array();
			} else {

				$criteria->add(MgaRealeaseGroupHasMgaReleasePeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

				$this->collMgaRealeaseGroupHasMgaReleases = MgaRealeaseGroupHasMgaReleasePeer::doSelectJoinMgaReleaseGroup($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(MgaRealeaseGroupHasMgaReleasePeer::MGA_RELEASE_IDMGA_RELEASE, $this->id);

			if (!isset($this->lastMgaRealeaseGroupHasMgaReleaseCriteria) || !$this->lastMgaRealeaseGroupHasMgaReleaseCriteria->equals($criteria)) {
				$this->collMgaRealeaseGroupHasMgaReleases = MgaRealeaseGroupHasMgaReleasePeer::doSelectJoinMgaReleaseGroup($criteria, $con, $join_behavior);
			}
		}
		$this->lastMgaRealeaseGroupHasMgaReleaseCriteria = $criteria;

		return $this->collMgaRealeaseGroupHasMgaReleases;
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
	 * Otherwise if this MgaRelease has previously been saved, it will retrieve
	 * related NewVersionRequests from storage. If this MgaRelease is new, it will return
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
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
			   $this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

				NewVersionRequestPeer::addSelectColumns($criteria);
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

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
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
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

				$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

				$count = NewVersionRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

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
			$l->setMgaRelease($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this MgaRelease is new, it will return
	 * an empty collection; or if this MgaRelease has previously
	 * been saved, it will retrieve related NewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in MgaRelease.
	 */
	public function getNewVersionRequestsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

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
	 * Otherwise if this MgaRelease is new, it will return
	 * an empty collection; or if this MgaRelease has previously
	 * been saved, it will retrieve related NewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in MgaRelease.
	 */
	public function getNewVersionRequestsJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MgaReleasePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewVersionRequestPeer::MGA_RELEASE_ID, $this->id);

			if (!isset($this->lastNewVersionRequestCriteria) || !$this->lastNewVersionRequestCriteria->equals($criteria)) {
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastNewVersionRequestCriteria = $criteria;

		return $this->collNewVersionRequests;
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
			if ($this->collMgaRealeaseGroupHasMgaReleases) {
				foreach ((array) $this->collMgaRealeaseGroupHasMgaReleases as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collNewVersionRequests) {
				foreach ((array) $this->collNewVersionRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collRpms = null;
		$this->collMgaRealeaseGroupHasMgaReleases = null;
		$this->collNewVersionRequests = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseMgaRelease:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseMgaRelease::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseMgaRelease
