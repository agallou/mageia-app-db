<?php

/**
 * Base class that represents a row from the 'new_version_request' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseNewVersionRequest extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        NewVersionRequestPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;

	/**
	 * The value for the package_id field.
	 * @var        int
	 */
	protected $package_id;

	/**
	 * The value for the distrelease_id field.
	 * @var        int
	 */
	protected $distrelease_id;

	/**
	 * The value for the version_needed field.
	 * @var        string
	 */
	protected $version_needed;

	/**
	 * The value for the status field.
	 * @var        string
	 */
	protected $status;

	/**
	 * @var        User
	 */
	protected $aUser;

	/**
	 * @var        Package
	 */
	protected $aPackage;

	/**
	 * @var        Distrelease
	 */
	protected $aDistrelease;

	/**
	 * @var        array UserCommentsNewVersionRequest[] Collection to store aggregation of UserCommentsNewVersionRequest objects.
	 */
	protected $collUserCommentsNewVersionRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserCommentsNewVersionRequests.
	 */
	private $lastUserCommentsNewVersionRequestCriteria = null;

	/**
	 * @var        array UserHasNewVersionRequest[] Collection to store aggregation of UserHasNewVersionRequest objects.
	 */
	protected $collUserHasNewVersionRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserHasNewVersionRequests.
	 */
	private $lastUserHasNewVersionRequestCriteria = null;

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
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * Get the [package_id] column value.
	 * 
	 * @return     int
	 */
	public function getPackageId()
	{
		return $this->package_id;
	}

	/**
	 * Get the [distrelease_id] column value.
	 * 
	 * @return     int
	 */
	public function getDistreleaseId()
	{
		return $this->distrelease_id;
	}

	/**
	 * Get the [version_needed] column value.
	 * 
	 * @return     string
	 */
	public function getVersionNeeded()
	{
		return $this->version_needed;
	}

	/**
	 * Get the [status] column value.
	 * 
	 * @return     string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     NewVersionRequest The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = NewVersionRequestPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NewVersionRequest The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = NewVersionRequestPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [package_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NewVersionRequest The current object (for fluent API support)
	 */
	public function setPackageId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->package_id !== $v) {
			$this->package_id = $v;
			$this->modifiedColumns[] = NewVersionRequestPeer::PACKAGE_ID;
		}

		if ($this->aPackage !== null && $this->aPackage->getId() !== $v) {
			$this->aPackage = null;
		}

		return $this;
	} // setPackageId()

	/**
	 * Set the value of [distrelease_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NewVersionRequest The current object (for fluent API support)
	 */
	public function setDistreleaseId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->distrelease_id !== $v) {
			$this->distrelease_id = $v;
			$this->modifiedColumns[] = NewVersionRequestPeer::DISTRELEASE_ID;
		}

		if ($this->aDistrelease !== null && $this->aDistrelease->getId() !== $v) {
			$this->aDistrelease = null;
		}

		return $this;
	} // setDistreleaseId()

	/**
	 * Set the value of [version_needed] column.
	 * 
	 * @param      string $v new value
	 * @return     NewVersionRequest The current object (for fluent API support)
	 */
	public function setVersionNeeded($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->version_needed !== $v) {
			$this->version_needed = $v;
			$this->modifiedColumns[] = NewVersionRequestPeer::VERSION_NEEDED;
		}

		return $this;
	} // setVersionNeeded()

	/**
	 * Set the value of [status] column.
	 * 
	 * @param      string $v new value
	 * @return     NewVersionRequest The current object (for fluent API support)
	 */
	public function setStatus($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = NewVersionRequestPeer::STATUS;
		}

		return $this;
	} // setStatus()

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
			$this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->package_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->distrelease_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->version_needed = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->status = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = NewVersionRequestPeer::NUM_COLUMNS - NewVersionRequestPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating NewVersionRequest object", $e);
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

		if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
			$this->aUser = null;
		}
		if ($this->aPackage !== null && $this->package_id !== $this->aPackage->getId()) {
			$this->aPackage = null;
		}
		if ($this->aDistrelease !== null && $this->distrelease_id !== $this->aDistrelease->getId()) {
			$this->aDistrelease = null;
		}
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
			$con = Propel::getConnection(NewVersionRequestPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = NewVersionRequestPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUser = null;
			$this->aPackage = null;
			$this->aDistrelease = null;
			$this->collUserCommentsNewVersionRequests = null;
			$this->lastUserCommentsNewVersionRequestCriteria = null;

			$this->collUserHasNewVersionRequests = null;
			$this->lastUserHasNewVersionRequestCriteria = null;

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
			$con = Propel::getConnection(NewVersionRequestPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			if ($ret) {
				NewVersionRequestPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(NewVersionRequestPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
				NewVersionRequestPeer::addInstanceToPool($this);
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

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if ($this->aUser->isModified() || $this->aUser->isNew()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}

			if ($this->aPackage !== null) {
				if ($this->aPackage->isModified() || $this->aPackage->isNew()) {
					$affectedRows += $this->aPackage->save($con);
				}
				$this->setPackage($this->aPackage);
			}

			if ($this->aDistrelease !== null) {
				if ($this->aDistrelease->isModified() || $this->aDistrelease->isNew()) {
					$affectedRows += $this->aDistrelease->save($con);
				}
				$this->setDistrelease($this->aDistrelease);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = NewVersionRequestPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = NewVersionRequestPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += NewVersionRequestPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collUserCommentsNewVersionRequests !== null) {
				foreach ($this->collUserCommentsNewVersionRequests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserHasNewVersionRequests !== null) {
				foreach ($this->collUserHasNewVersionRequests as $referrerFK) {
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}

			if ($this->aPackage !== null) {
				if (!$this->aPackage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPackage->getValidationFailures());
				}
			}

			if ($this->aDistrelease !== null) {
				if (!$this->aDistrelease->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDistrelease->getValidationFailures());
				}
			}


			if (($retval = NewVersionRequestPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserCommentsNewVersionRequests !== null) {
					foreach ($this->collUserCommentsNewVersionRequests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserHasNewVersionRequests !== null) {
					foreach ($this->collUserHasNewVersionRequests as $referrerFK) {
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
		$pos = NewVersionRequestPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getUserId();
				break;
			case 2:
				return $this->getPackageId();
				break;
			case 3:
				return $this->getDistreleaseId();
				break;
			case 4:
				return $this->getVersionNeeded();
				break;
			case 5:
				return $this->getStatus();
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
		$keys = NewVersionRequestPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getPackageId(),
			$keys[3] => $this->getDistreleaseId(),
			$keys[4] => $this->getVersionNeeded(),
			$keys[5] => $this->getStatus(),
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
		$pos = NewVersionRequestPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUserId($value);
				break;
			case 2:
				$this->setPackageId($value);
				break;
			case 3:
				$this->setDistreleaseId($value);
				break;
			case 4:
				$this->setVersionNeeded($value);
				break;
			case 5:
				$this->setStatus($value);
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
		$keys = NewVersionRequestPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPackageId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDistreleaseId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setVersionNeeded($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setStatus($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);

		if ($this->isColumnModified(NewVersionRequestPeer::ID)) $criteria->add(NewVersionRequestPeer::ID, $this->id);
		if ($this->isColumnModified(NewVersionRequestPeer::USER_ID)) $criteria->add(NewVersionRequestPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(NewVersionRequestPeer::PACKAGE_ID)) $criteria->add(NewVersionRequestPeer::PACKAGE_ID, $this->package_id);
		if ($this->isColumnModified(NewVersionRequestPeer::DISTRELEASE_ID)) $criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->distrelease_id);
		if ($this->isColumnModified(NewVersionRequestPeer::VERSION_NEEDED)) $criteria->add(NewVersionRequestPeer::VERSION_NEEDED, $this->version_needed);
		if ($this->isColumnModified(NewVersionRequestPeer::STATUS)) $criteria->add(NewVersionRequestPeer::STATUS, $this->status);

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
		$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);

		$criteria->add(NewVersionRequestPeer::ID, $this->id);
		$criteria->add(NewVersionRequestPeer::DISTRELEASE_ID, $this->distrelease_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getDistreleaseId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setDistreleaseId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of NewVersionRequest (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setPackageId($this->package_id);

		$copyObj->setDistreleaseId($this->distrelease_id);

		$copyObj->setVersionNeeded($this->version_needed);

		$copyObj->setStatus($this->status);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getUserCommentsNewVersionRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserCommentsNewVersionRequest($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserHasNewVersionRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserHasNewVersionRequest($relObj->copy($deepCopy));
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
	 * @return     NewVersionRequest Clone of current object.
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
	 * @return     NewVersionRequestPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new NewVersionRequestPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     NewVersionRequest The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUser(User $v = null)
	{
		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}

		$this->aUser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addNewVersionRequest($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUser(PropelPDO $con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
			$this->aUser = UserPeer::retrieveByPk($this->user_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUser->addNewVersionRequests($this);
			 */
		}
		return $this->aUser;
	}

	/**
	 * Declares an association between this object and a Package object.
	 *
	 * @param      Package $v
	 * @return     NewVersionRequest The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPackage(Package $v = null)
	{
		if ($v === null) {
			$this->setPackageId(NULL);
		} else {
			$this->setPackageId($v->getId());
		}

		$this->aPackage = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Package object, it will not be re-added.
		if ($v !== null) {
			$v->addNewVersionRequest($this);
		}

		return $this;
	}


	/**
	 * Get the associated Package object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Package The associated Package object.
	 * @throws     PropelException
	 */
	public function getPackage(PropelPDO $con = null)
	{
		if ($this->aPackage === null && ($this->package_id !== null)) {
			$this->aPackage = PackagePeer::retrieveByPk($this->package_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPackage->addNewVersionRequests($this);
			 */
		}
		return $this->aPackage;
	}

	/**
	 * Declares an association between this object and a Distrelease object.
	 *
	 * @param      Distrelease $v
	 * @return     NewVersionRequest The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setDistrelease(Distrelease $v = null)
	{
		if ($v === null) {
			$this->setDistreleaseId(NULL);
		} else {
			$this->setDistreleaseId($v->getId());
		}

		$this->aDistrelease = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Distrelease object, it will not be re-added.
		if ($v !== null) {
			$v->addNewVersionRequest($this);
		}

		return $this;
	}


	/**
	 * Get the associated Distrelease object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Distrelease The associated Distrelease object.
	 * @throws     PropelException
	 */
	public function getDistrelease(PropelPDO $con = null)
	{
		if ($this->aDistrelease === null && ($this->distrelease_id !== null)) {
			$this->aDistrelease = DistreleasePeer::retrieveByPk($this->distrelease_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aDistrelease->addNewVersionRequests($this);
			 */
		}
		return $this->aDistrelease;
	}

	/**
	 * Clears out the collUserCommentsNewVersionRequests collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserCommentsNewVersionRequests()
	 */
	public function clearUserCommentsNewVersionRequests()
	{
		$this->collUserCommentsNewVersionRequests = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserCommentsNewVersionRequests collection (array).
	 *
	 * By default this just sets the collUserCommentsNewVersionRequests collection to an empty array (like clearcollUserCommentsNewVersionRequests());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserCommentsNewVersionRequests()
	{
		$this->collUserCommentsNewVersionRequests = array();
	}

	/**
	 * Gets an array of UserCommentsNewVersionRequest objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this NewVersionRequest has previously been saved, it will retrieve
	 * related UserCommentsNewVersionRequests from storage. If this NewVersionRequest is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserCommentsNewVersionRequest[]
	 * @throws     PropelException
	 */
	public function getUserCommentsNewVersionRequests($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsNewVersionRequests === null) {
			if ($this->isNew()) {
			   $this->collUserCommentsNewVersionRequests = array();
			} else {

				$criteria->add(UserCommentsNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				UserCommentsNewVersionRequestPeer::addSelectColumns($criteria);
				$this->collUserCommentsNewVersionRequests = UserCommentsNewVersionRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserCommentsNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				UserCommentsNewVersionRequestPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserCommentsNewVersionRequestCriteria) || !$this->lastUserCommentsNewVersionRequestCriteria->equals($criteria)) {
					$this->collUserCommentsNewVersionRequests = UserCommentsNewVersionRequestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserCommentsNewVersionRequestCriteria = $criteria;
		return $this->collUserCommentsNewVersionRequests;
	}

	/**
	 * Returns the number of related UserCommentsNewVersionRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserCommentsNewVersionRequest objects.
	 * @throws     PropelException
	 */
	public function countUserCommentsNewVersionRequests(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserCommentsNewVersionRequests === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserCommentsNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				$count = UserCommentsNewVersionRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserCommentsNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				if (!isset($this->lastUserCommentsNewVersionRequestCriteria) || !$this->lastUserCommentsNewVersionRequestCriteria->equals($criteria)) {
					$count = UserCommentsNewVersionRequestPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collUserCommentsNewVersionRequests);
				}
			} else {
				$count = count($this->collUserCommentsNewVersionRequests);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserCommentsNewVersionRequest object to this object
	 * through the UserCommentsNewVersionRequest foreign key attribute.
	 *
	 * @param      UserCommentsNewVersionRequest $l UserCommentsNewVersionRequest
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserCommentsNewVersionRequest(UserCommentsNewVersionRequest $l)
	{
		if ($this->collUserCommentsNewVersionRequests === null) {
			$this->initUserCommentsNewVersionRequests();
		}
		if (!in_array($l, $this->collUserCommentsNewVersionRequests, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserCommentsNewVersionRequests, $l);
			$l->setNewVersionRequest($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this NewVersionRequest is new, it will return
	 * an empty collection; or if this NewVersionRequest has previously
	 * been saved, it will retrieve related UserCommentsNewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in NewVersionRequest.
	 */
	public function getUserCommentsNewVersionRequestsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collUserCommentsNewVersionRequests = array();
			} else {

				$criteria->add(UserCommentsNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				$this->collUserCommentsNewVersionRequests = UserCommentsNewVersionRequestPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserCommentsNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

			if (!isset($this->lastUserCommentsNewVersionRequestCriteria) || !$this->lastUserCommentsNewVersionRequestCriteria->equals($criteria)) {
				$this->collUserCommentsNewVersionRequests = UserCommentsNewVersionRequestPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserCommentsNewVersionRequestCriteria = $criteria;

		return $this->collUserCommentsNewVersionRequests;
	}

	/**
	 * Clears out the collUserHasNewVersionRequests collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserHasNewVersionRequests()
	 */
	public function clearUserHasNewVersionRequests()
	{
		$this->collUserHasNewVersionRequests = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserHasNewVersionRequests collection (array).
	 *
	 * By default this just sets the collUserHasNewVersionRequests collection to an empty array (like clearcollUserHasNewVersionRequests());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserHasNewVersionRequests()
	{
		$this->collUserHasNewVersionRequests = array();
	}

	/**
	 * Gets an array of UserHasNewVersionRequest objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this NewVersionRequest has previously been saved, it will retrieve
	 * related UserHasNewVersionRequests from storage. If this NewVersionRequest is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserHasNewVersionRequest[]
	 * @throws     PropelException
	 */
	public function getUserHasNewVersionRequests($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasNewVersionRequests === null) {
			if ($this->isNew()) {
			   $this->collUserHasNewVersionRequests = array();
			} else {

				$criteria->add(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				UserHasNewVersionRequestPeer::addSelectColumns($criteria);
				$this->collUserHasNewVersionRequests = UserHasNewVersionRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				UserHasNewVersionRequestPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserHasNewVersionRequestCriteria) || !$this->lastUserHasNewVersionRequestCriteria->equals($criteria)) {
					$this->collUserHasNewVersionRequests = UserHasNewVersionRequestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserHasNewVersionRequestCriteria = $criteria;
		return $this->collUserHasNewVersionRequests;
	}

	/**
	 * Returns the number of related UserHasNewVersionRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserHasNewVersionRequest objects.
	 * @throws     PropelException
	 */
	public function countUserHasNewVersionRequests(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserHasNewVersionRequests === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				$count = UserHasNewVersionRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				if (!isset($this->lastUserHasNewVersionRequestCriteria) || !$this->lastUserHasNewVersionRequestCriteria->equals($criteria)) {
					$count = UserHasNewVersionRequestPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collUserHasNewVersionRequests);
				}
			} else {
				$count = count($this->collUserHasNewVersionRequests);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserHasNewVersionRequest object to this object
	 * through the UserHasNewVersionRequest foreign key attribute.
	 *
	 * @param      UserHasNewVersionRequest $l UserHasNewVersionRequest
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserHasNewVersionRequest(UserHasNewVersionRequest $l)
	{
		if ($this->collUserHasNewVersionRequests === null) {
			$this->initUserHasNewVersionRequests();
		}
		if (!in_array($l, $this->collUserHasNewVersionRequests, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserHasNewVersionRequests, $l);
			$l->setNewVersionRequest($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this NewVersionRequest is new, it will return
	 * an empty collection; or if this NewVersionRequest has previously
	 * been saved, it will retrieve related UserHasNewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in NewVersionRequest.
	 */
	public function getUserHasNewVersionRequestsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(NewVersionRequestPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collUserHasNewVersionRequests = array();
			} else {

				$criteria->add(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

				$this->collUserHasNewVersionRequests = UserHasNewVersionRequestPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->id);

			if (!isset($this->lastUserHasNewVersionRequestCriteria) || !$this->lastUserHasNewVersionRequestCriteria->equals($criteria)) {
				$this->collUserHasNewVersionRequests = UserHasNewVersionRequestPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserHasNewVersionRequestCriteria = $criteria;

		return $this->collUserHasNewVersionRequests;
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
			if ($this->collUserCommentsNewVersionRequests) {
				foreach ((array) $this->collUserCommentsNewVersionRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserHasNewVersionRequests) {
				foreach ((array) $this->collUserHasNewVersionRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collUserCommentsNewVersionRequests = null;
		$this->collUserHasNewVersionRequests = null;
			$this->aUser = null;
			$this->aPackage = null;
			$this->aDistrelease = null;
	}

} // BaseNewVersionRequest
