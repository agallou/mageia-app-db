<?php

/**
 * Base class that represents a row from the 'subscription' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseSubscription extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        SubscriptionPeer
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
	 * The value for the update field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $update;

	/**
	 * The value for the new_version field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $new_version;

	/**
	 * The value for the update_candidate field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $update_candidate;

	/**
	 * The value for the new_version_candidate field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $new_version_candidate;

	/**
	 * The value for the comments field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $comments;

	/**
	 * The value for the mail_notification field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $mail_notification;

	/**
	 * The value for the mail_prefix field.
	 * @var        string
	 */
	protected $mail_prefix;

	/**
	 * The value for the rss_feed_id field.
	 * @var        int
	 */
	protected $rss_feed_id;

	/**
	 * @var        User
	 */
	protected $aUser;

	/**
	 * @var        RssFeed
	 */
	protected $aRssFeed;

	/**
	 * @var        array SubscriptionElement[] Collection to store aggregation of SubscriptionElement objects.
	 */
	protected $collSubscriptionElements;

	/**
	 * @var        Criteria The criteria used to select the current contents of collSubscriptionElements.
	 */
	private $lastSubscriptionElementCriteria = null;

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
	
	const PEER = 'SubscriptionPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->update = false;
		$this->new_version = false;
		$this->update_candidate = false;
		$this->new_version_candidate = false;
		$this->comments = false;
		$this->mail_notification = false;
	}

	/**
	 * Initializes internal state of BaseSubscription object.
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
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * Get the [update] column value.
	 * 
	 * @return     boolean
	 */
	public function getUpdate()
	{
		return $this->update;
	}

	/**
	 * Get the [new_version] column value.
	 * 
	 * @return     boolean
	 */
	public function getNewVersion()
	{
		return $this->new_version;
	}

	/**
	 * Get the [update_candidate] column value.
	 * 
	 * @return     boolean
	 */
	public function getUpdateCandidate()
	{
		return $this->update_candidate;
	}

	/**
	 * Get the [new_version_candidate] column value.
	 * 
	 * @return     boolean
	 */
	public function getNewVersionCandidate()
	{
		return $this->new_version_candidate;
	}

	/**
	 * Get the [comments] column value.
	 * 
	 * @return     boolean
	 */
	public function getComments()
	{
		return $this->comments;
	}

	/**
	 * Get the [mail_notification] column value.
	 * 
	 * @return     boolean
	 */
	public function getMailNotification()
	{
		return $this->mail_notification;
	}

	/**
	 * Get the [mail_prefix] column value.
	 * 
	 * @return     string
	 */
	public function getMailPrefix()
	{
		return $this->mail_prefix;
	}

	/**
	 * Get the [rss_feed_id] column value.
	 * 
	 * @return     int
	 */
	public function getRssFeedId()
	{
		return $this->rss_feed_id;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SubscriptionPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = SubscriptionPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [update] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setUpdate($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->update !== $v || $this->isNew()) {
			$this->update = $v;
			$this->modifiedColumns[] = SubscriptionPeer::UPDATE;
		}

		return $this;
	} // setUpdate()

	/**
	 * Set the value of [new_version] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setNewVersion($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->new_version !== $v || $this->isNew()) {
			$this->new_version = $v;
			$this->modifiedColumns[] = SubscriptionPeer::NEW_VERSION;
		}

		return $this;
	} // setNewVersion()

	/**
	 * Set the value of [update_candidate] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setUpdateCandidate($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->update_candidate !== $v || $this->isNew()) {
			$this->update_candidate = $v;
			$this->modifiedColumns[] = SubscriptionPeer::UPDATE_CANDIDATE;
		}

		return $this;
	} // setUpdateCandidate()

	/**
	 * Set the value of [new_version_candidate] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setNewVersionCandidate($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->new_version_candidate !== $v || $this->isNew()) {
			$this->new_version_candidate = $v;
			$this->modifiedColumns[] = SubscriptionPeer::NEW_VERSION_CANDIDATE;
		}

		return $this;
	} // setNewVersionCandidate()

	/**
	 * Set the value of [comments] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setComments($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->comments !== $v || $this->isNew()) {
			$this->comments = $v;
			$this->modifiedColumns[] = SubscriptionPeer::COMMENTS;
		}

		return $this;
	} // setComments()

	/**
	 * Set the value of [mail_notification] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setMailNotification($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->mail_notification !== $v || $this->isNew()) {
			$this->mail_notification = $v;
			$this->modifiedColumns[] = SubscriptionPeer::MAIL_NOTIFICATION;
		}

		return $this;
	} // setMailNotification()

	/**
	 * Set the value of [mail_prefix] column.
	 * 
	 * @param      string $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setMailPrefix($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mail_prefix !== $v) {
			$this->mail_prefix = $v;
			$this->modifiedColumns[] = SubscriptionPeer::MAIL_PREFIX;
		}

		return $this;
	} // setMailPrefix()

	/**
	 * Set the value of [rss_feed_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Subscription The current object (for fluent API support)
	 */
	public function setRssFeedId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->rss_feed_id !== $v) {
			$this->rss_feed_id = $v;
			$this->modifiedColumns[] = SubscriptionPeer::RSS_FEED_ID;
		}

		if ($this->aRssFeed !== null && $this->aRssFeed->getId() !== $v) {
			$this->aRssFeed = null;
		}

		return $this;
	} // setRssFeedId()

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
			if ($this->update !== false) {
				return false;
			}

			if ($this->new_version !== false) {
				return false;
			}

			if ($this->update_candidate !== false) {
				return false;
			}

			if ($this->new_version_candidate !== false) {
				return false;
			}

			if ($this->comments !== false) {
				return false;
			}

			if ($this->mail_notification !== false) {
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
			$this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->update = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
			$this->new_version = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
			$this->update_candidate = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
			$this->new_version_candidate = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->comments = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
			$this->mail_notification = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->mail_prefix = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->rss_feed_id = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 10; // 10 = SubscriptionPeer::NUM_COLUMNS - SubscriptionPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Subscription object", $e);
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
		if ($this->aRssFeed !== null && $this->rss_feed_id !== $this->aRssFeed->getId()) {
			$this->aRssFeed = null;
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
			$con = Propel::getConnection(SubscriptionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = SubscriptionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUser = null;
			$this->aRssFeed = null;
			$this->collSubscriptionElements = null;
			$this->lastSubscriptionElementCriteria = null;

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
			$con = Propel::getConnection(SubscriptionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseSubscription:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				SubscriptionPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseSubscription:delete:post') as $callable)
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
			$con = Propel::getConnection(SubscriptionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseSubscription:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseSubscription:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				SubscriptionPeer::addInstanceToPool($this);
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

			if ($this->aRssFeed !== null) {
				if ($this->aRssFeed->isModified() || $this->aRssFeed->isNew()) {
					$affectedRows += $this->aRssFeed->save($con);
				}
				$this->setRssFeed($this->aRssFeed);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = SubscriptionPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SubscriptionPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += SubscriptionPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collSubscriptionElements !== null) {
				foreach ($this->collSubscriptionElements as $referrerFK) {
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}

			if ($this->aRssFeed !== null) {
				if (!$this->aRssFeed->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRssFeed->getValidationFailures());
				}
			}


			if (($retval = SubscriptionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSubscriptionElements !== null) {
					foreach ($this->collSubscriptionElements as $referrerFK) {
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
		$pos = SubscriptionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getUpdate();
				break;
			case 3:
				return $this->getNewVersion();
				break;
			case 4:
				return $this->getUpdateCandidate();
				break;
			case 5:
				return $this->getNewVersionCandidate();
				break;
			case 6:
				return $this->getComments();
				break;
			case 7:
				return $this->getMailNotification();
				break;
			case 8:
				return $this->getMailPrefix();
				break;
			case 9:
				return $this->getRssFeedId();
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
		$keys = SubscriptionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getUpdate(),
			$keys[3] => $this->getNewVersion(),
			$keys[4] => $this->getUpdateCandidate(),
			$keys[5] => $this->getNewVersionCandidate(),
			$keys[6] => $this->getComments(),
			$keys[7] => $this->getMailNotification(),
			$keys[8] => $this->getMailPrefix(),
			$keys[9] => $this->getRssFeedId(),
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
		$pos = SubscriptionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUpdate($value);
				break;
			case 3:
				$this->setNewVersion($value);
				break;
			case 4:
				$this->setUpdateCandidate($value);
				break;
			case 5:
				$this->setNewVersionCandidate($value);
				break;
			case 6:
				$this->setComments($value);
				break;
			case 7:
				$this->setMailNotification($value);
				break;
			case 8:
				$this->setMailPrefix($value);
				break;
			case 9:
				$this->setRssFeedId($value);
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
		$keys = SubscriptionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUpdate($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setNewVersion($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUpdateCandidate($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setNewVersionCandidate($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setComments($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMailNotification($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setMailPrefix($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRssFeedId($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);

		if ($this->isColumnModified(SubscriptionPeer::ID)) $criteria->add(SubscriptionPeer::ID, $this->id);
		if ($this->isColumnModified(SubscriptionPeer::USER_ID)) $criteria->add(SubscriptionPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(SubscriptionPeer::UPDATE)) $criteria->add(SubscriptionPeer::UPDATE, $this->update);
		if ($this->isColumnModified(SubscriptionPeer::NEW_VERSION)) $criteria->add(SubscriptionPeer::NEW_VERSION, $this->new_version);
		if ($this->isColumnModified(SubscriptionPeer::UPDATE_CANDIDATE)) $criteria->add(SubscriptionPeer::UPDATE_CANDIDATE, $this->update_candidate);
		if ($this->isColumnModified(SubscriptionPeer::NEW_VERSION_CANDIDATE)) $criteria->add(SubscriptionPeer::NEW_VERSION_CANDIDATE, $this->new_version_candidate);
		if ($this->isColumnModified(SubscriptionPeer::COMMENTS)) $criteria->add(SubscriptionPeer::COMMENTS, $this->comments);
		if ($this->isColumnModified(SubscriptionPeer::MAIL_NOTIFICATION)) $criteria->add(SubscriptionPeer::MAIL_NOTIFICATION, $this->mail_notification);
		if ($this->isColumnModified(SubscriptionPeer::MAIL_PREFIX)) $criteria->add(SubscriptionPeer::MAIL_PREFIX, $this->mail_prefix);
		if ($this->isColumnModified(SubscriptionPeer::RSS_FEED_ID)) $criteria->add(SubscriptionPeer::RSS_FEED_ID, $this->rss_feed_id);

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
		$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);

		$criteria->add(SubscriptionPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Subscription (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setUpdate($this->update);

		$copyObj->setNewVersion($this->new_version);

		$copyObj->setUpdateCandidate($this->update_candidate);

		$copyObj->setNewVersionCandidate($this->new_version_candidate);

		$copyObj->setComments($this->comments);

		$copyObj->setMailNotification($this->mail_notification);

		$copyObj->setMailPrefix($this->mail_prefix);

		$copyObj->setRssFeedId($this->rss_feed_id);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getSubscriptionElements() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addSubscriptionElement($relObj->copy($deepCopy));
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
	 * @return     Subscription Clone of current object.
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
	 * @return     SubscriptionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new SubscriptionPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Subscription The current object (for fluent API support)
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
			$v->addSubscription($this);
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
			   $this->aUser->addSubscriptions($this);
			 */
		}
		return $this->aUser;
	}

	/**
	 * Declares an association between this object and a RssFeed object.
	 *
	 * @param      RssFeed $v
	 * @return     Subscription The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setRssFeed(RssFeed $v = null)
	{
		if ($v === null) {
			$this->setRssFeedId(NULL);
		} else {
			$this->setRssFeedId($v->getId());
		}

		$this->aRssFeed = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the RssFeed object, it will not be re-added.
		if ($v !== null) {
			$v->addSubscription($this);
		}

		return $this;
	}


	/**
	 * Get the associated RssFeed object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     RssFeed The associated RssFeed object.
	 * @throws     PropelException
	 */
	public function getRssFeed(PropelPDO $con = null)
	{
		if ($this->aRssFeed === null && ($this->rss_feed_id !== null)) {
			$this->aRssFeed = RssFeedPeer::retrieveByPk($this->rss_feed_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aRssFeed->addSubscriptions($this);
			 */
		}
		return $this->aRssFeed;
	}

	/**
	 * Clears out the collSubscriptionElements collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addSubscriptionElements()
	 */
	public function clearSubscriptionElements()
	{
		$this->collSubscriptionElements = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collSubscriptionElements collection (array).
	 *
	 * By default this just sets the collSubscriptionElements collection to an empty array (like clearcollSubscriptionElements());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initSubscriptionElements()
	{
		$this->collSubscriptionElements = array();
	}

	/**
	 * Gets an array of SubscriptionElement objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Subscription has previously been saved, it will retrieve
	 * related SubscriptionElements from storage. If this Subscription is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array SubscriptionElement[]
	 * @throws     PropelException
	 */
	public function getSubscriptionElements($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionElements === null) {
			if ($this->isNew()) {
			   $this->collSubscriptionElements = array();
			} else {

				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				SubscriptionElementPeer::addSelectColumns($criteria);
				$this->collSubscriptionElements = SubscriptionElementPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				SubscriptionElementPeer::addSelectColumns($criteria);
				if (!isset($this->lastSubscriptionElementCriteria) || !$this->lastSubscriptionElementCriteria->equals($criteria)) {
					$this->collSubscriptionElements = SubscriptionElementPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSubscriptionElementCriteria = $criteria;
		return $this->collSubscriptionElements;
	}

	/**
	 * Returns the number of related SubscriptionElement objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related SubscriptionElement objects.
	 * @throws     PropelException
	 */
	public function countSubscriptionElements(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collSubscriptionElements === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				$count = SubscriptionElementPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				if (!isset($this->lastSubscriptionElementCriteria) || !$this->lastSubscriptionElementCriteria->equals($criteria)) {
					$count = SubscriptionElementPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collSubscriptionElements);
				}
			} else {
				$count = count($this->collSubscriptionElements);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a SubscriptionElement object to this object
	 * through the SubscriptionElement foreign key attribute.
	 *
	 * @param      SubscriptionElement $l SubscriptionElement
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSubscriptionElement(SubscriptionElement $l)
	{
		if ($this->collSubscriptionElements === null) {
			$this->initSubscriptionElements();
		}
		if (!in_array($l, $this->collSubscriptionElements, true)) { // only add it if the **same** object is not already associated
			array_push($this->collSubscriptionElements, $l);
			$l->setSubscription($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Subscription is new, it will return
	 * an empty collection; or if this Subscription has previously
	 * been saved, it will retrieve related SubscriptionElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Subscription.
	 */
	public function getSubscriptionElementsJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionElements === null) {
			if ($this->isNew()) {
				$this->collSubscriptionElements = array();
			} else {

				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

			if (!isset($this->lastSubscriptionElementCriteria) || !$this->lastSubscriptionElementCriteria->equals($criteria)) {
				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastSubscriptionElementCriteria = $criteria;

		return $this->collSubscriptionElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Subscription is new, it will return
	 * an empty collection; or if this Subscription has previously
	 * been saved, it will retrieve related SubscriptionElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Subscription.
	 */
	public function getSubscriptionElementsJoinRpmGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionElements === null) {
			if ($this->isNew()) {
				$this->collSubscriptionElements = array();
			} else {

				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

			if (!isset($this->lastSubscriptionElementCriteria) || !$this->lastSubscriptionElementCriteria->equals($criteria)) {
				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		}
		$this->lastSubscriptionElementCriteria = $criteria;

		return $this->collSubscriptionElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Subscription is new, it will return
	 * an empty collection; or if this Subscription has previously
	 * been saved, it will retrieve related SubscriptionElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Subscription.
	 */
	public function getSubscriptionElementsJoinDistrelease($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionElements === null) {
			if ($this->isNew()) {
				$this->collSubscriptionElements = array();
			} else {

				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinDistrelease($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

			if (!isset($this->lastSubscriptionElementCriteria) || !$this->lastSubscriptionElementCriteria->equals($criteria)) {
				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinDistrelease($criteria, $con, $join_behavior);
			}
		}
		$this->lastSubscriptionElementCriteria = $criteria;

		return $this->collSubscriptionElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Subscription is new, it will return
	 * an empty collection; or if this Subscription has previously
	 * been saved, it will retrieve related SubscriptionElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Subscription.
	 */
	public function getSubscriptionElementsJoinArch($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionElements === null) {
			if ($this->isNew()) {
				$this->collSubscriptionElements = array();
			} else {

				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

			if (!isset($this->lastSubscriptionElementCriteria) || !$this->lastSubscriptionElementCriteria->equals($criteria)) {
				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		}
		$this->lastSubscriptionElementCriteria = $criteria;

		return $this->collSubscriptionElements;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Subscription is new, it will return
	 * an empty collection; or if this Subscription has previously
	 * been saved, it will retrieve related SubscriptionElements from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Subscription.
	 */
	public function getSubscriptionElementsJoinMedia($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubscriptionElements === null) {
			if ($this->isNew()) {
				$this->collSubscriptionElements = array();
			} else {

				$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(SubscriptionElementPeer::SUBSCRIPTION_ID, $this->id);

			if (!isset($this->lastSubscriptionElementCriteria) || !$this->lastSubscriptionElementCriteria->equals($criteria)) {
				$this->collSubscriptionElements = SubscriptionElementPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		}
		$this->lastSubscriptionElementCriteria = $criteria;

		return $this->collSubscriptionElements;
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
	 * Otherwise if this Subscription has previously been saved, it will retrieve
	 * related Notifications from storage. If this Subscription is new, it will return
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
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotifications === null) {
			if ($this->isNew()) {
			   $this->collNotifications = array();
			} else {

				$criteria->add(NotificationPeer::SUBSCRIPTION_ID, $this->id);

				NotificationPeer::addSelectColumns($criteria);
				$this->collNotifications = NotificationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NotificationPeer::SUBSCRIPTION_ID, $this->id);

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
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
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

				$criteria->add(NotificationPeer::SUBSCRIPTION_ID, $this->id);

				$count = NotificationPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(NotificationPeer::SUBSCRIPTION_ID, $this->id);

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
			$l->setSubscription($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Subscription is new, it will return
	 * an empty collection; or if this Subscription has previously
	 * been saved, it will retrieve related Notifications from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Subscription.
	 */
	public function getNotificationsJoinRpm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(SubscriptionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotifications === null) {
			if ($this->isNew()) {
				$this->collNotifications = array();
			} else {

				$criteria->add(NotificationPeer::SUBSCRIPTION_ID, $this->id);

				$this->collNotifications = NotificationPeer::doSelectJoinRpm($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationPeer::SUBSCRIPTION_ID, $this->id);

			if (!isset($this->lastNotificationCriteria) || !$this->lastNotificationCriteria->equals($criteria)) {
				$this->collNotifications = NotificationPeer::doSelectJoinRpm($criteria, $con, $join_behavior);
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
			if ($this->collSubscriptionElements) {
				foreach ((array) $this->collSubscriptionElements as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collNotifications) {
				foreach ((array) $this->collNotifications as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collSubscriptionElements = null;
		$this->collNotifications = null;
			$this->aUser = null;
			$this->aRssFeed = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseSubscription:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseSubscription::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseSubscription
