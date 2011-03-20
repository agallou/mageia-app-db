<?php

/**
 * Base class that represents a row from the 'notification_element' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseNotificationElement extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        NotificationElementPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the notification_id field.
	 * @var        int
	 */
	protected $notification_id;

	/**
	 * The value for the package_id field.
	 * @var        int
	 */
	protected $package_id;

	/**
	 * The value for the rpm_group_id field.
	 * @var        int
	 */
	protected $rpm_group_id;

	/**
	 * The value for the distrelease_id field.
	 * @var        int
	 */
	protected $distrelease_id;

	/**
	 * The value for the arch_id field.
	 * @var        int
	 */
	protected $arch_id;

	/**
	 * The value for the media_id field.
	 * @var        int
	 */
	protected $media_id;

	/**
	 * @var        Notification
	 */
	protected $aNotification;

	/**
	 * @var        Package
	 */
	protected $aPackage;

	/**
	 * @var        RpmGroup
	 */
	protected $aRpmGroup;

	/**
	 * @var        Distrelease
	 */
	protected $aDistrelease;

	/**
	 * @var        Arch
	 */
	protected $aArch;

	/**
	 * @var        Media
	 */
	protected $aMedia;

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
	 * Get the [notification_id] column value.
	 * 
	 * @return     int
	 */
	public function getNotificationId()
	{
		return $this->notification_id;
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
	 * Get the [rpm_group_id] column value.
	 * 
	 * @return     int
	 */
	public function getRpmGroupId()
	{
		return $this->rpm_group_id;
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
	 * Get the [arch_id] column value.
	 * 
	 * @return     int
	 */
	public function getArchId()
	{
		return $this->arch_id;
	}

	/**
	 * Get the [media_id] column value.
	 * 
	 * @return     int
	 */
	public function getMediaId()
	{
		return $this->media_id;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     NotificationElement The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = NotificationElementPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [notification_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NotificationElement The current object (for fluent API support)
	 */
	public function setNotificationId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->notification_id !== $v) {
			$this->notification_id = $v;
			$this->modifiedColumns[] = NotificationElementPeer::NOTIFICATION_ID;
		}

		if ($this->aNotification !== null && $this->aNotification->getId() !== $v) {
			$this->aNotification = null;
		}

		return $this;
	} // setNotificationId()

	/**
	 * Set the value of [package_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NotificationElement The current object (for fluent API support)
	 */
	public function setPackageId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->package_id !== $v) {
			$this->package_id = $v;
			$this->modifiedColumns[] = NotificationElementPeer::PACKAGE_ID;
		}

		if ($this->aPackage !== null && $this->aPackage->getId() !== $v) {
			$this->aPackage = null;
		}

		return $this;
	} // setPackageId()

	/**
	 * Set the value of [rpm_group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NotificationElement The current object (for fluent API support)
	 */
	public function setRpmGroupId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->rpm_group_id !== $v) {
			$this->rpm_group_id = $v;
			$this->modifiedColumns[] = NotificationElementPeer::RPM_GROUP_ID;
		}

		if ($this->aRpmGroup !== null && $this->aRpmGroup->getId() !== $v) {
			$this->aRpmGroup = null;
		}

		return $this;
	} // setRpmGroupId()

	/**
	 * Set the value of [distrelease_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NotificationElement The current object (for fluent API support)
	 */
	public function setDistreleaseId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->distrelease_id !== $v) {
			$this->distrelease_id = $v;
			$this->modifiedColumns[] = NotificationElementPeer::DISTRELEASE_ID;
		}

		if ($this->aDistrelease !== null && $this->aDistrelease->getId() !== $v) {
			$this->aDistrelease = null;
		}

		return $this;
	} // setDistreleaseId()

	/**
	 * Set the value of [arch_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NotificationElement The current object (for fluent API support)
	 */
	public function setArchId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->arch_id !== $v) {
			$this->arch_id = $v;
			$this->modifiedColumns[] = NotificationElementPeer::ARCH_ID;
		}

		if ($this->aArch !== null && $this->aArch->getId() !== $v) {
			$this->aArch = null;
		}

		return $this;
	} // setArchId()

	/**
	 * Set the value of [media_id] column.
	 * 
	 * @param      int $v new value
	 * @return     NotificationElement The current object (for fluent API support)
	 */
	public function setMediaId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->media_id !== $v) {
			$this->media_id = $v;
			$this->modifiedColumns[] = NotificationElementPeer::MEDIA_ID;
		}

		if ($this->aMedia !== null && $this->aMedia->getId() !== $v) {
			$this->aMedia = null;
		}

		return $this;
	} // setMediaId()

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
			$this->notification_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->package_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->rpm_group_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->distrelease_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->arch_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->media_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 7; // 7 = NotificationElementPeer::NUM_COLUMNS - NotificationElementPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating NotificationElement object", $e);
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

		if ($this->aNotification !== null && $this->notification_id !== $this->aNotification->getId()) {
			$this->aNotification = null;
		}
		if ($this->aPackage !== null && $this->package_id !== $this->aPackage->getId()) {
			$this->aPackage = null;
		}
		if ($this->aRpmGroup !== null && $this->rpm_group_id !== $this->aRpmGroup->getId()) {
			$this->aRpmGroup = null;
		}
		if ($this->aDistrelease !== null && $this->distrelease_id !== $this->aDistrelease->getId()) {
			$this->aDistrelease = null;
		}
		if ($this->aArch !== null && $this->arch_id !== $this->aArch->getId()) {
			$this->aArch = null;
		}
		if ($this->aMedia !== null && $this->media_id !== $this->aMedia->getId()) {
			$this->aMedia = null;
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
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = NotificationElementPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aNotification = null;
			$this->aPackage = null;
			$this->aRpmGroup = null;
			$this->aDistrelease = null;
			$this->aArch = null;
			$this->aMedia = null;
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
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			if ($ret) {
				NotificationElementPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(NotificationElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
				NotificationElementPeer::addInstanceToPool($this);
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

			if ($this->aNotification !== null) {
				if ($this->aNotification->isModified() || $this->aNotification->isNew()) {
					$affectedRows += $this->aNotification->save($con);
				}
				$this->setNotification($this->aNotification);
			}

			if ($this->aPackage !== null) {
				if ($this->aPackage->isModified() || $this->aPackage->isNew()) {
					$affectedRows += $this->aPackage->save($con);
				}
				$this->setPackage($this->aPackage);
			}

			if ($this->aRpmGroup !== null) {
				if ($this->aRpmGroup->isModified() || $this->aRpmGroup->isNew()) {
					$affectedRows += $this->aRpmGroup->save($con);
				}
				$this->setRpmGroup($this->aRpmGroup);
			}

			if ($this->aDistrelease !== null) {
				if ($this->aDistrelease->isModified() || $this->aDistrelease->isNew()) {
					$affectedRows += $this->aDistrelease->save($con);
				}
				$this->setDistrelease($this->aDistrelease);
			}

			if ($this->aArch !== null) {
				if ($this->aArch->isModified() || $this->aArch->isNew()) {
					$affectedRows += $this->aArch->save($con);
				}
				$this->setArch($this->aArch);
			}

			if ($this->aMedia !== null) {
				if ($this->aMedia->isModified() || $this->aMedia->isNew()) {
					$affectedRows += $this->aMedia->save($con);
				}
				$this->setMedia($this->aMedia);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = NotificationElementPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = NotificationElementPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += NotificationElementPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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

			if ($this->aNotification !== null) {
				if (!$this->aNotification->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aNotification->getValidationFailures());
				}
			}

			if ($this->aPackage !== null) {
				if (!$this->aPackage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPackage->getValidationFailures());
				}
			}

			if ($this->aRpmGroup !== null) {
				if (!$this->aRpmGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRpmGroup->getValidationFailures());
				}
			}

			if ($this->aDistrelease !== null) {
				if (!$this->aDistrelease->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDistrelease->getValidationFailures());
				}
			}

			if ($this->aArch !== null) {
				if (!$this->aArch->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArch->getValidationFailures());
				}
			}

			if ($this->aMedia !== null) {
				if (!$this->aMedia->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMedia->getValidationFailures());
				}
			}


			if (($retval = NotificationElementPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = NotificationElementPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getNotificationId();
				break;
			case 2:
				return $this->getPackageId();
				break;
			case 3:
				return $this->getRpmGroupId();
				break;
			case 4:
				return $this->getDistreleaseId();
				break;
			case 5:
				return $this->getArchId();
				break;
			case 6:
				return $this->getMediaId();
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
		$keys = NotificationElementPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getNotificationId(),
			$keys[2] => $this->getPackageId(),
			$keys[3] => $this->getRpmGroupId(),
			$keys[4] => $this->getDistreleaseId(),
			$keys[5] => $this->getArchId(),
			$keys[6] => $this->getMediaId(),
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
		$pos = NotificationElementPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setNotificationId($value);
				break;
			case 2:
				$this->setPackageId($value);
				break;
			case 3:
				$this->setRpmGroupId($value);
				break;
			case 4:
				$this->setDistreleaseId($value);
				break;
			case 5:
				$this->setArchId($value);
				break;
			case 6:
				$this->setMediaId($value);
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
		$keys = NotificationElementPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNotificationId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPackageId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRpmGroupId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDistreleaseId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setArchId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMediaId($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(NotificationElementPeer::DATABASE_NAME);

		if ($this->isColumnModified(NotificationElementPeer::ID)) $criteria->add(NotificationElementPeer::ID, $this->id);
		if ($this->isColumnModified(NotificationElementPeer::NOTIFICATION_ID)) $criteria->add(NotificationElementPeer::NOTIFICATION_ID, $this->notification_id);
		if ($this->isColumnModified(NotificationElementPeer::PACKAGE_ID)) $criteria->add(NotificationElementPeer::PACKAGE_ID, $this->package_id);
		if ($this->isColumnModified(NotificationElementPeer::RPM_GROUP_ID)) $criteria->add(NotificationElementPeer::RPM_GROUP_ID, $this->rpm_group_id);
		if ($this->isColumnModified(NotificationElementPeer::DISTRELEASE_ID)) $criteria->add(NotificationElementPeer::DISTRELEASE_ID, $this->distrelease_id);
		if ($this->isColumnModified(NotificationElementPeer::ARCH_ID)) $criteria->add(NotificationElementPeer::ARCH_ID, $this->arch_id);
		if ($this->isColumnModified(NotificationElementPeer::MEDIA_ID)) $criteria->add(NotificationElementPeer::MEDIA_ID, $this->media_id);

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
		$criteria = new Criteria(NotificationElementPeer::DATABASE_NAME);

		$criteria->add(NotificationElementPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of NotificationElement (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNotificationId($this->notification_id);

		$copyObj->setPackageId($this->package_id);

		$copyObj->setRpmGroupId($this->rpm_group_id);

		$copyObj->setDistreleaseId($this->distrelease_id);

		$copyObj->setArchId($this->arch_id);

		$copyObj->setMediaId($this->media_id);


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
	 * @return     NotificationElement Clone of current object.
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
	 * @return     NotificationElementPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new NotificationElementPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Notification object.
	 *
	 * @param      Notification $v
	 * @return     NotificationElement The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setNotification(Notification $v = null)
	{
		if ($v === null) {
			$this->setNotificationId(NULL);
		} else {
			$this->setNotificationId($v->getId());
		}

		$this->aNotification = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Notification object, it will not be re-added.
		if ($v !== null) {
			$v->addNotificationElement($this);
		}

		return $this;
	}


	/**
	 * Get the associated Notification object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Notification The associated Notification object.
	 * @throws     PropelException
	 */
	public function getNotification(PropelPDO $con = null)
	{
		if ($this->aNotification === null && ($this->notification_id !== null)) {
			$this->aNotification = NotificationPeer::retrieveByPk($this->notification_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aNotification->addNotificationElements($this);
			 */
		}
		return $this->aNotification;
	}

	/**
	 * Declares an association between this object and a Package object.
	 *
	 * @param      Package $v
	 * @return     NotificationElement The current object (for fluent API support)
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
			$v->addNotificationElement($this);
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
			   $this->aPackage->addNotificationElements($this);
			 */
		}
		return $this->aPackage;
	}

	/**
	 * Declares an association between this object and a RpmGroup object.
	 *
	 * @param      RpmGroup $v
	 * @return     NotificationElement The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setRpmGroup(RpmGroup $v = null)
	{
		if ($v === null) {
			$this->setRpmGroupId(NULL);
		} else {
			$this->setRpmGroupId($v->getId());
		}

		$this->aRpmGroup = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the RpmGroup object, it will not be re-added.
		if ($v !== null) {
			$v->addNotificationElement($this);
		}

		return $this;
	}


	/**
	 * Get the associated RpmGroup object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     RpmGroup The associated RpmGroup object.
	 * @throws     PropelException
	 */
	public function getRpmGroup(PropelPDO $con = null)
	{
		if ($this->aRpmGroup === null && ($this->rpm_group_id !== null)) {
			$this->aRpmGroup = RpmGroupPeer::retrieveByPk($this->rpm_group_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aRpmGroup->addNotificationElements($this);
			 */
		}
		return $this->aRpmGroup;
	}

	/**
	 * Declares an association between this object and a Distrelease object.
	 *
	 * @param      Distrelease $v
	 * @return     NotificationElement The current object (for fluent API support)
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
			$v->addNotificationElement($this);
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
			   $this->aDistrelease->addNotificationElements($this);
			 */
		}
		return $this->aDistrelease;
	}

	/**
	 * Declares an association between this object and a Arch object.
	 *
	 * @param      Arch $v
	 * @return     NotificationElement The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setArch(Arch $v = null)
	{
		if ($v === null) {
			$this->setArchId(NULL);
		} else {
			$this->setArchId($v->getId());
		}

		$this->aArch = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Arch object, it will not be re-added.
		if ($v !== null) {
			$v->addNotificationElement($this);
		}

		return $this;
	}


	/**
	 * Get the associated Arch object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Arch The associated Arch object.
	 * @throws     PropelException
	 */
	public function getArch(PropelPDO $con = null)
	{
		if ($this->aArch === null && ($this->arch_id !== null)) {
			$this->aArch = ArchPeer::retrieveByPk($this->arch_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aArch->addNotificationElements($this);
			 */
		}
		return $this->aArch;
	}

	/**
	 * Declares an association between this object and a Media object.
	 *
	 * @param      Media $v
	 * @return     NotificationElement The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setMedia(Media $v = null)
	{
		if ($v === null) {
			$this->setMediaId(NULL);
		} else {
			$this->setMediaId($v->getId());
		}

		$this->aMedia = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Media object, it will not be re-added.
		if ($v !== null) {
			$v->addNotificationElement($this);
		}

		return $this;
	}


	/**
	 * Get the associated Media object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Media The associated Media object.
	 * @throws     PropelException
	 */
	public function getMedia(PropelPDO $con = null)
	{
		if ($this->aMedia === null && ($this->media_id !== null)) {
			$this->aMedia = MediaPeer::retrieveByPk($this->media_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aMedia->addNotificationElements($this);
			 */
		}
		return $this->aMedia;
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
		} // if ($deep)

			$this->aNotification = null;
			$this->aPackage = null;
			$this->aRpmGroup = null;
			$this->aDistrelease = null;
			$this->aArch = null;
			$this->aMedia = null;
	}

} // BaseNotificationElement
