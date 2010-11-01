<?php

/**
 * Base class that represents a row from the 'user' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseUser extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        UserPeer
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
	 * The value for the login field.
	 * @var        string
	 */
	protected $login;

	/**
	 * @var        array UserCommentsPackage[] Collection to store aggregation of UserCommentsPackage objects.
	 */
	protected $collUserCommentsPackages;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserCommentsPackages.
	 */
	private $lastUserCommentsPackageCriteria = null;

	/**
	 * @var        array NewVersionRequest[] Collection to store aggregation of NewVersionRequest objects.
	 */
	protected $collNewVersionRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collNewVersionRequests.
	 */
	private $lastNewVersionRequestCriteria = null;

	/**
	 * @var        array SoftwareRequest[] Collection to store aggregation of SoftwareRequest objects.
	 */
	protected $collSoftwareRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collSoftwareRequests.
	 */
	private $lastSoftwareRequestCriteria = null;

	/**
	 * @var        array UserHasSoftwareRequest[] Collection to store aggregation of UserHasSoftwareRequest objects.
	 */
	protected $collUserHasSoftwareRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserHasSoftwareRequests.
	 */
	private $lastUserHasSoftwareRequestCriteria = null;

	/**
	 * @var        array UserCommentsSoftwareRequest[] Collection to store aggregation of UserCommentsSoftwareRequest objects.
	 */
	protected $collUserCommentsSoftwareRequests;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserCommentsSoftwareRequests.
	 */
	private $lastUserCommentsSoftwareRequestCriteria = null;

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
	 * @var        array Notification[] Collection to store aggregation of Notification objects.
	 */
	protected $collNotifications;

	/**
	 * @var        Criteria The criteria used to select the current contents of collNotifications.
	 */
	private $lastNotificationCriteria = null;

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
	
	const PEER = 'UserPeer';

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
	 * Get the [login] column value.
	 * 
	 * @return     string
	 */
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = UserPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = UserPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [login] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setLogin($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->login !== $v) {
			$this->login = $v;
			$this->modifiedColumns[] = UserPeer::LOGIN;
		}

		return $this;
	} // setLogin()

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
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->login = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 3; // 3 = UserPeer::NUM_COLUMNS - UserPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collUserCommentsPackages = null;
			$this->lastUserCommentsPackageCriteria = null;

			$this->collNewVersionRequests = null;
			$this->lastNewVersionRequestCriteria = null;

			$this->collSoftwareRequests = null;
			$this->lastSoftwareRequestCriteria = null;

			$this->collUserHasSoftwareRequests = null;
			$this->lastUserHasSoftwareRequestCriteria = null;

			$this->collUserCommentsSoftwareRequests = null;
			$this->lastUserCommentsSoftwareRequestCriteria = null;

			$this->collUserCommentsNewVersionRequests = null;
			$this->lastUserCommentsNewVersionRequestCriteria = null;

			$this->collUserHasNewVersionRequests = null;
			$this->lastUserHasNewVersionRequestCriteria = null;

			$this->collNotifications = null;
			$this->lastNotificationCriteria = null;

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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseUser:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				UserPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseUser:delete:post') as $callable)
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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseUser:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseUser:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				UserPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = UserPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = UserPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += UserPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collUserCommentsPackages !== null) {
				foreach ($this->collUserCommentsPackages as $referrerFK) {
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

			if ($this->collSoftwareRequests !== null) {
				foreach ($this->collSoftwareRequests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserHasSoftwareRequests !== null) {
				foreach ($this->collUserHasSoftwareRequests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserCommentsSoftwareRequests !== null) {
				foreach ($this->collUserCommentsSoftwareRequests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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

			if ($this->collNotifications !== null) {
				foreach ($this->collNotifications as $referrerFK) {
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


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserCommentsPackages !== null) {
					foreach ($this->collUserCommentsPackages as $referrerFK) {
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

				if ($this->collSoftwareRequests !== null) {
					foreach ($this->collSoftwareRequests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserHasSoftwareRequests !== null) {
					foreach ($this->collUserHasSoftwareRequests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserCommentsSoftwareRequests !== null) {
					foreach ($this->collUserCommentsSoftwareRequests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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

				if ($this->collNotifications !== null) {
					foreach ($this->collNotifications as $referrerFK) {
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
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getLogin();
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
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getLogin(),
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
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setLogin($value);
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
		$keys = UserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setLogin($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
		if ($this->isColumnModified(UserPeer::NAME)) $criteria->add(UserPeer::NAME, $this->name);
		if ($this->isColumnModified(UserPeer::LOGIN)) $criteria->add(UserPeer::LOGIN, $this->login);

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
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of User (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setLogin($this->login);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getUserCommentsPackages() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserCommentsPackage($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getNewVersionRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addNewVersionRequest($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getSoftwareRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addSoftwareRequest($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserHasSoftwareRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserHasSoftwareRequest($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserCommentsSoftwareRequests() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserCommentsSoftwareRequest($relObj->copy($deepCopy));
				}
			}

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

			foreach ($this->getNotifications() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addNotification($relObj->copy($deepCopy));
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
	 * @return     User Clone of current object.
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
	 * @return     UserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new UserPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collUserCommentsPackages collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserCommentsPackages()
	 */
	public function clearUserCommentsPackages()
	{
		$this->collUserCommentsPackages = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserCommentsPackages collection (array).
	 *
	 * By default this just sets the collUserCommentsPackages collection to an empty array (like clearcollUserCommentsPackages());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserCommentsPackages()
	{
		$this->collUserCommentsPackages = array();
	}

	/**
	 * Gets an array of UserCommentsPackage objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserCommentsPackages from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserCommentsPackage[]
	 * @throws     PropelException
	 */
	public function getUserCommentsPackages($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsPackages === null) {
			if ($this->isNew()) {
			   $this->collUserCommentsPackages = array();
			} else {

				$criteria->add(UserCommentsPackagePeer::USER_ID, $this->id);

				UserCommentsPackagePeer::addSelectColumns($criteria);
				$this->collUserCommentsPackages = UserCommentsPackagePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserCommentsPackagePeer::USER_ID, $this->id);

				UserCommentsPackagePeer::addSelectColumns($criteria);
				if (!isset($this->lastUserCommentsPackageCriteria) || !$this->lastUserCommentsPackageCriteria->equals($criteria)) {
					$this->collUserCommentsPackages = UserCommentsPackagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserCommentsPackageCriteria = $criteria;
		return $this->collUserCommentsPackages;
	}

	/**
	 * Returns the number of related UserCommentsPackage objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserCommentsPackage objects.
	 * @throws     PropelException
	 */
	public function countUserCommentsPackages(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserCommentsPackages === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserCommentsPackagePeer::USER_ID, $this->id);

				$count = UserCommentsPackagePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserCommentsPackagePeer::USER_ID, $this->id);

				if (!isset($this->lastUserCommentsPackageCriteria) || !$this->lastUserCommentsPackageCriteria->equals($criteria)) {
					$count = UserCommentsPackagePeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collUserCommentsPackages);
				}
			} else {
				$count = count($this->collUserCommentsPackages);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserCommentsPackage object to this object
	 * through the UserCommentsPackage foreign key attribute.
	 *
	 * @param      UserCommentsPackage $l UserCommentsPackage
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserCommentsPackage(UserCommentsPackage $l)
	{
		if ($this->collUserCommentsPackages === null) {
			$this->initUserCommentsPackages();
		}
		if (!in_array($l, $this->collUserCommentsPackages, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserCommentsPackages, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserCommentsPackages from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserCommentsPackagesJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsPackages === null) {
			if ($this->isNew()) {
				$this->collUserCommentsPackages = array();
			} else {

				$criteria->add(UserCommentsPackagePeer::USER_ID, $this->id);

				$this->collUserCommentsPackages = UserCommentsPackagePeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserCommentsPackagePeer::USER_ID, $this->id);

			if (!isset($this->lastUserCommentsPackageCriteria) || !$this->lastUserCommentsPackageCriteria->equals($criteria)) {
				$this->collUserCommentsPackages = UserCommentsPackagePeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserCommentsPackageCriteria = $criteria;

		return $this->collUserCommentsPackages;
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
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related NewVersionRequests from storage. If this User is new, it will return
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
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
			   $this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

				NewVersionRequestPeer::addSelectColumns($criteria);
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

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
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
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

				$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

				$count = NewVersionRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

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
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related NewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getNewVersionRequestsJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

			if (!isset($this->lastNewVersionRequestCriteria) || !$this->lastNewVersionRequestCriteria->equals($criteria)) {
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastNewVersionRequestCriteria = $criteria;

		return $this->collNewVersionRequests;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related NewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getNewVersionRequestsJoinDistrelease($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collNewVersionRequests = array();
			} else {

				$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinDistrelease($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewVersionRequestPeer::USER_ID, $this->id);

			if (!isset($this->lastNewVersionRequestCriteria) || !$this->lastNewVersionRequestCriteria->equals($criteria)) {
				$this->collNewVersionRequests = NewVersionRequestPeer::doSelectJoinDistrelease($criteria, $con, $join_behavior);
			}
		}
		$this->lastNewVersionRequestCriteria = $criteria;

		return $this->collNewVersionRequests;
	}

	/**
	 * Clears out the collSoftwareRequests collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addSoftwareRequests()
	 */
	public function clearSoftwareRequests()
	{
		$this->collSoftwareRequests = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collSoftwareRequests collection (array).
	 *
	 * By default this just sets the collSoftwareRequests collection to an empty array (like clearcollSoftwareRequests());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initSoftwareRequests()
	{
		$this->collSoftwareRequests = array();
	}

	/**
	 * Gets an array of SoftwareRequest objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related SoftwareRequests from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array SoftwareRequest[]
	 * @throws     PropelException
	 */
	public function getSoftwareRequests($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSoftwareRequests === null) {
			if ($this->isNew()) {
			   $this->collSoftwareRequests = array();
			} else {

				$criteria->add(SoftwareRequestPeer::USER_ID, $this->id);

				SoftwareRequestPeer::addSelectColumns($criteria);
				$this->collSoftwareRequests = SoftwareRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(SoftwareRequestPeer::USER_ID, $this->id);

				SoftwareRequestPeer::addSelectColumns($criteria);
				if (!isset($this->lastSoftwareRequestCriteria) || !$this->lastSoftwareRequestCriteria->equals($criteria)) {
					$this->collSoftwareRequests = SoftwareRequestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSoftwareRequestCriteria = $criteria;
		return $this->collSoftwareRequests;
	}

	/**
	 * Returns the number of related SoftwareRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related SoftwareRequest objects.
	 * @throws     PropelException
	 */
	public function countSoftwareRequests(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collSoftwareRequests === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(SoftwareRequestPeer::USER_ID, $this->id);

				$count = SoftwareRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(SoftwareRequestPeer::USER_ID, $this->id);

				if (!isset($this->lastSoftwareRequestCriteria) || !$this->lastSoftwareRequestCriteria->equals($criteria)) {
					$count = SoftwareRequestPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collSoftwareRequests);
				}
			} else {
				$count = count($this->collSoftwareRequests);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a SoftwareRequest object to this object
	 * through the SoftwareRequest foreign key attribute.
	 *
	 * @param      SoftwareRequest $l SoftwareRequest
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSoftwareRequest(SoftwareRequest $l)
	{
		if ($this->collSoftwareRequests === null) {
			$this->initSoftwareRequests();
		}
		if (!in_array($l, $this->collSoftwareRequests, true)) { // only add it if the **same** object is not already associated
			array_push($this->collSoftwareRequests, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Clears out the collUserHasSoftwareRequests collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserHasSoftwareRequests()
	 */
	public function clearUserHasSoftwareRequests()
	{
		$this->collUserHasSoftwareRequests = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserHasSoftwareRequests collection (array).
	 *
	 * By default this just sets the collUserHasSoftwareRequests collection to an empty array (like clearcollUserHasSoftwareRequests());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserHasSoftwareRequests()
	{
		$this->collUserHasSoftwareRequests = array();
	}

	/**
	 * Gets an array of UserHasSoftwareRequest objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserHasSoftwareRequests from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserHasSoftwareRequest[]
	 * @throws     PropelException
	 */
	public function getUserHasSoftwareRequests($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasSoftwareRequests === null) {
			if ($this->isNew()) {
			   $this->collUserHasSoftwareRequests = array();
			} else {

				$criteria->add(UserHasSoftwareRequestPeer::USER_ID, $this->id);

				UserHasSoftwareRequestPeer::addSelectColumns($criteria);
				$this->collUserHasSoftwareRequests = UserHasSoftwareRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserHasSoftwareRequestPeer::USER_ID, $this->id);

				UserHasSoftwareRequestPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserHasSoftwareRequestCriteria) || !$this->lastUserHasSoftwareRequestCriteria->equals($criteria)) {
					$this->collUserHasSoftwareRequests = UserHasSoftwareRequestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserHasSoftwareRequestCriteria = $criteria;
		return $this->collUserHasSoftwareRequests;
	}

	/**
	 * Returns the number of related UserHasSoftwareRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserHasSoftwareRequest objects.
	 * @throws     PropelException
	 */
	public function countUserHasSoftwareRequests(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserHasSoftwareRequests === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserHasSoftwareRequestPeer::USER_ID, $this->id);

				$count = UserHasSoftwareRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserHasSoftwareRequestPeer::USER_ID, $this->id);

				if (!isset($this->lastUserHasSoftwareRequestCriteria) || !$this->lastUserHasSoftwareRequestCriteria->equals($criteria)) {
					$count = UserHasSoftwareRequestPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collUserHasSoftwareRequests);
				}
			} else {
				$count = count($this->collUserHasSoftwareRequests);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserHasSoftwareRequest object to this object
	 * through the UserHasSoftwareRequest foreign key attribute.
	 *
	 * @param      UserHasSoftwareRequest $l UserHasSoftwareRequest
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserHasSoftwareRequest(UserHasSoftwareRequest $l)
	{
		if ($this->collUserHasSoftwareRequests === null) {
			$this->initUserHasSoftwareRequests();
		}
		if (!in_array($l, $this->collUserHasSoftwareRequests, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserHasSoftwareRequests, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserHasSoftwareRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserHasSoftwareRequestsJoinSoftwareRequest($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasSoftwareRequests === null) {
			if ($this->isNew()) {
				$this->collUserHasSoftwareRequests = array();
			} else {

				$criteria->add(UserHasSoftwareRequestPeer::USER_ID, $this->id);

				$this->collUserHasSoftwareRequests = UserHasSoftwareRequestPeer::doSelectJoinSoftwareRequest($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserHasSoftwareRequestPeer::USER_ID, $this->id);

			if (!isset($this->lastUserHasSoftwareRequestCriteria) || !$this->lastUserHasSoftwareRequestCriteria->equals($criteria)) {
				$this->collUserHasSoftwareRequests = UserHasSoftwareRequestPeer::doSelectJoinSoftwareRequest($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserHasSoftwareRequestCriteria = $criteria;

		return $this->collUserHasSoftwareRequests;
	}

	/**
	 * Clears out the collUserCommentsSoftwareRequests collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserCommentsSoftwareRequests()
	 */
	public function clearUserCommentsSoftwareRequests()
	{
		$this->collUserCommentsSoftwareRequests = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserCommentsSoftwareRequests collection (array).
	 *
	 * By default this just sets the collUserCommentsSoftwareRequests collection to an empty array (like clearcollUserCommentsSoftwareRequests());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserCommentsSoftwareRequests()
	{
		$this->collUserCommentsSoftwareRequests = array();
	}

	/**
	 * Gets an array of UserCommentsSoftwareRequest objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserCommentsSoftwareRequests from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserCommentsSoftwareRequest[]
	 * @throws     PropelException
	 */
	public function getUserCommentsSoftwareRequests($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsSoftwareRequests === null) {
			if ($this->isNew()) {
			   $this->collUserCommentsSoftwareRequests = array();
			} else {

				$criteria->add(UserCommentsSoftwareRequestPeer::USER_ID, $this->id);

				UserCommentsSoftwareRequestPeer::addSelectColumns($criteria);
				$this->collUserCommentsSoftwareRequests = UserCommentsSoftwareRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserCommentsSoftwareRequestPeer::USER_ID, $this->id);

				UserCommentsSoftwareRequestPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserCommentsSoftwareRequestCriteria) || !$this->lastUserCommentsSoftwareRequestCriteria->equals($criteria)) {
					$this->collUserCommentsSoftwareRequests = UserCommentsSoftwareRequestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserCommentsSoftwareRequestCriteria = $criteria;
		return $this->collUserCommentsSoftwareRequests;
	}

	/**
	 * Returns the number of related UserCommentsSoftwareRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserCommentsSoftwareRequest objects.
	 * @throws     PropelException
	 */
	public function countUserCommentsSoftwareRequests(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserCommentsSoftwareRequests === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserCommentsSoftwareRequestPeer::USER_ID, $this->id);

				$count = UserCommentsSoftwareRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserCommentsSoftwareRequestPeer::USER_ID, $this->id);

				if (!isset($this->lastUserCommentsSoftwareRequestCriteria) || !$this->lastUserCommentsSoftwareRequestCriteria->equals($criteria)) {
					$count = UserCommentsSoftwareRequestPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collUserCommentsSoftwareRequests);
				}
			} else {
				$count = count($this->collUserCommentsSoftwareRequests);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserCommentsSoftwareRequest object to this object
	 * through the UserCommentsSoftwareRequest foreign key attribute.
	 *
	 * @param      UserCommentsSoftwareRequest $l UserCommentsSoftwareRequest
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserCommentsSoftwareRequest(UserCommentsSoftwareRequest $l)
	{
		if ($this->collUserCommentsSoftwareRequests === null) {
			$this->initUserCommentsSoftwareRequests();
		}
		if (!in_array($l, $this->collUserCommentsSoftwareRequests, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserCommentsSoftwareRequests, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserCommentsSoftwareRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserCommentsSoftwareRequestsJoinSoftwareRequest($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsSoftwareRequests === null) {
			if ($this->isNew()) {
				$this->collUserCommentsSoftwareRequests = array();
			} else {

				$criteria->add(UserCommentsSoftwareRequestPeer::USER_ID, $this->id);

				$this->collUserCommentsSoftwareRequests = UserCommentsSoftwareRequestPeer::doSelectJoinSoftwareRequest($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserCommentsSoftwareRequestPeer::USER_ID, $this->id);

			if (!isset($this->lastUserCommentsSoftwareRequestCriteria) || !$this->lastUserCommentsSoftwareRequestCriteria->equals($criteria)) {
				$this->collUserCommentsSoftwareRequests = UserCommentsSoftwareRequestPeer::doSelectJoinSoftwareRequest($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserCommentsSoftwareRequestCriteria = $criteria;

		return $this->collUserCommentsSoftwareRequests;
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
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserCommentsNewVersionRequests from storage. If this User is new, it will return
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
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsNewVersionRequests === null) {
			if ($this->isNew()) {
			   $this->collUserCommentsNewVersionRequests = array();
			} else {

				$criteria->add(UserCommentsNewVersionRequestPeer::USER_ID, $this->id);

				UserCommentsNewVersionRequestPeer::addSelectColumns($criteria);
				$this->collUserCommentsNewVersionRequests = UserCommentsNewVersionRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserCommentsNewVersionRequestPeer::USER_ID, $this->id);

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
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
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

				$criteria->add(UserCommentsNewVersionRequestPeer::USER_ID, $this->id);

				$count = UserCommentsNewVersionRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserCommentsNewVersionRequestPeer::USER_ID, $this->id);

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
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserCommentsNewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserCommentsNewVersionRequestsJoinNewVersionRequest($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserCommentsNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collUserCommentsNewVersionRequests = array();
			} else {

				$criteria->add(UserCommentsNewVersionRequestPeer::USER_ID, $this->id);

				$this->collUserCommentsNewVersionRequests = UserCommentsNewVersionRequestPeer::doSelectJoinNewVersionRequest($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserCommentsNewVersionRequestPeer::USER_ID, $this->id);

			if (!isset($this->lastUserCommentsNewVersionRequestCriteria) || !$this->lastUserCommentsNewVersionRequestCriteria->equals($criteria)) {
				$this->collUserCommentsNewVersionRequests = UserCommentsNewVersionRequestPeer::doSelectJoinNewVersionRequest($criteria, $con, $join_behavior);
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
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserHasNewVersionRequests from storage. If this User is new, it will return
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
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasNewVersionRequests === null) {
			if ($this->isNew()) {
			   $this->collUserHasNewVersionRequests = array();
			} else {

				$criteria->add(UserHasNewVersionRequestPeer::USER_ID, $this->id);

				UserHasNewVersionRequestPeer::addSelectColumns($criteria);
				$this->collUserHasNewVersionRequests = UserHasNewVersionRequestPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserHasNewVersionRequestPeer::USER_ID, $this->id);

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
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
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

				$criteria->add(UserHasNewVersionRequestPeer::USER_ID, $this->id);

				$count = UserHasNewVersionRequestPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserHasNewVersionRequestPeer::USER_ID, $this->id);

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
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserHasNewVersionRequests from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserHasNewVersionRequestsJoinNewVersionRequest($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasNewVersionRequests === null) {
			if ($this->isNew()) {
				$this->collUserHasNewVersionRequests = array();
			} else {

				$criteria->add(UserHasNewVersionRequestPeer::USER_ID, $this->id);

				$this->collUserHasNewVersionRequests = UserHasNewVersionRequestPeer::doSelectJoinNewVersionRequest($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserHasNewVersionRequestPeer::USER_ID, $this->id);

			if (!isset($this->lastUserHasNewVersionRequestCriteria) || !$this->lastUserHasNewVersionRequestCriteria->equals($criteria)) {
				$this->collUserHasNewVersionRequests = UserHasNewVersionRequestPeer::doSelectJoinNewVersionRequest($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserHasNewVersionRequestCriteria = $criteria;

		return $this->collUserHasNewVersionRequests;
	}

	/**
	 * Clears out the collNotifications collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addNotifications()
	 */
	public function clearNotifications()
	{
		$this->collNotifications = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collNotifications collection (array).
	 *
	 * By default this just sets the collNotifications collection to an empty array (like clearcollNotifications());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initNotifications()
	{
		$this->collNotifications = array();
	}

	/**
	 * Gets an array of Notification objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related Notifications from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Notification[]
	 * @throws     PropelException
	 */
	public function getNotifications($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotifications === null) {
			if ($this->isNew()) {
			   $this->collNotifications = array();
			} else {

				$criteria->add(NotificationPeer::USER_ID, $this->id);

				NotificationPeer::addSelectColumns($criteria);
				$this->collNotifications = NotificationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NotificationPeer::USER_ID, $this->id);

				NotificationPeer::addSelectColumns($criteria);
				if (!isset($this->lastNotificationCriteria) || !$this->lastNotificationCriteria->equals($criteria)) {
					$this->collNotifications = NotificationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNotificationCriteria = $criteria;
		return $this->collNotifications;
	}

	/**
	 * Returns the number of related Notification objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Notification objects.
	 * @throws     PropelException
	 */
	public function countNotifications(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collNotifications === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(NotificationPeer::USER_ID, $this->id);

				$count = NotificationPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(NotificationPeer::USER_ID, $this->id);

				if (!isset($this->lastNotificationCriteria) || !$this->lastNotificationCriteria->equals($criteria)) {
					$count = NotificationPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collNotifications);
				}
			} else {
				$count = count($this->collNotifications);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Notification object to this object
	 * through the Notification foreign key attribute.
	 *
	 * @param      Notification $l Notification
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNotification(Notification $l)
	{
		if ($this->collNotifications === null) {
			$this->initNotifications();
		}
		if (!in_array($l, $this->collNotifications, true)) { // only add it if the **same** object is not already associated
			array_push($this->collNotifications, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related Notifications from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getNotificationsJoinRssFeed($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotifications === null) {
			if ($this->isNew()) {
				$this->collNotifications = array();
			} else {

				$criteria->add(NotificationPeer::USER_ID, $this->id);

				$this->collNotifications = NotificationPeer::doSelectJoinRssFeed($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationPeer::USER_ID, $this->id);

			if (!isset($this->lastNotificationCriteria) || !$this->lastNotificationCriteria->equals($criteria)) {
				$this->collNotifications = NotificationPeer::doSelectJoinRssFeed($criteria, $con, $join_behavior);
			}
		}
		$this->lastNotificationCriteria = $criteria;

		return $this->collNotifications;
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
			if ($this->collUserCommentsPackages) {
				foreach ((array) $this->collUserCommentsPackages as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collNewVersionRequests) {
				foreach ((array) $this->collNewVersionRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collSoftwareRequests) {
				foreach ((array) $this->collSoftwareRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserHasSoftwareRequests) {
				foreach ((array) $this->collUserHasSoftwareRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserCommentsSoftwareRequests) {
				foreach ((array) $this->collUserCommentsSoftwareRequests as $o) {
					$o->clearAllReferences($deep);
				}
			}
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
			if ($this->collNotifications) {
				foreach ((array) $this->collNotifications as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collUserCommentsPackages = null;
		$this->collNewVersionRequests = null;
		$this->collSoftwareRequests = null;
		$this->collUserHasSoftwareRequests = null;
		$this->collUserCommentsSoftwareRequests = null;
		$this->collUserCommentsNewVersionRequests = null;
		$this->collUserHasNewVersionRequests = null;
		$this->collNotifications = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseUser:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseUser::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseUser
