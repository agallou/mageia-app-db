<?php

/**
 * Base class that represents a row from the 'rpm' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseRpm extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        RpmPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

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
	 * The value for the media_id field.
	 * @var        int
	 */
	protected $media_id;

	/**
	 * The value for the rpm_group_id field.
	 * @var        int
	 */
	protected $rpm_group_id;

	/**
	 * The value for the licence field.
	 * @var        string
	 */
	protected $licence;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the md5_name field.
	 * @var        string
	 */
	protected $md5_name;

	/**
	 * The value for the filename field.
	 * @var        string
	 */
	protected $filename;

	/**
	 * The value for the short_name field.
	 * @var        string
	 */
	protected $short_name;

	/**
	 * The value for the evr field.
	 * @var        string
	 */
	protected $evr;

	/**
	 * The value for the version field.
	 * @var        string
	 */
	protected $version;

	/**
	 * The value for the release field.
	 * @var        string
	 */
	protected $release;

	/**
	 * The value for the summary field.
	 * @var        string
	 */
	protected $summary;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the url field.
	 * @var        string
	 */
	protected $url;

	/**
	 * The value for the rpm_pkgid field.
	 * @var        string
	 */
	protected $rpm_pkgid;

	/**
	 * The value for the build_time field.
	 * @var        string
	 */
	protected $build_time;

	/**
	 * The value for the size field.
	 * @var        int
	 */
	protected $size;

	/**
	 * The value for the realarch field.
	 * @var        string
	 */
	protected $realarch;

	/**
	 * The value for the arch_id field.
	 * @var        int
	 */
	protected $arch_id;

	/**
	 * The value for the is_source field.
	 * @var        boolean
	 */
	protected $is_source;

	/**
	 * The value for the source_rpm_id field.
	 * @var        int
	 */
	protected $source_rpm_id;

	/**
	 * The value for the source_rpm_name field.
	 * @var        string
	 */
	protected $source_rpm_name;

	/**
	 * @var        Package
	 */
	protected $aPackage;

	/**
	 * @var        Distrelease
	 */
	protected $aDistrelease;

	/**
	 * @var        Media
	 */
	protected $aMedia;

	/**
	 * @var        RpmGroup
	 */
	protected $aRpmGroup;

	/**
	 * @var        Arch
	 */
	protected $aArch;

	/**
	 * @var        Rpm
	 */
	protected $aRpmRelatedBySourceRpmId;

	/**
	 * @var        array Rpm[] Collection to store aggregation of Rpm objects.
	 */
	protected $collRpmsRelatedBySourceRpmId;

	/**
	 * @var        Criteria The criteria used to select the current contents of collRpmsRelatedBySourceRpmId.
	 */
	private $lastRpmRelatedBySourceRpmIdCriteria = null;

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
	
	const PEER = 'RpmPeer';

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
	 * Get the [media_id] column value.
	 * 
	 * @return     int
	 */
	public function getMediaId()
	{
		return $this->media_id;
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
	 * Get the [licence] column value.
	 * 
	 * @return     string
	 */
	public function getLicence()
	{
		return $this->licence;
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
	 * Get the [md5_name] column value.
	 * 
	 * @return     string
	 */
	public function getMd5Name()
	{
		return $this->md5_name;
	}

	/**
	 * Get the [filename] column value.
	 * 
	 * @return     string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * Get the [short_name] column value.
	 * 
	 * @return     string
	 */
	public function getShortName()
	{
		return $this->short_name;
	}

	/**
	 * Get the [evr] column value.
	 * 
	 * @return     string
	 */
	public function getEvr()
	{
		return $this->evr;
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
	 * Get the [release] column value.
	 * 
	 * @return     string
	 */
	public function getRelease()
	{
		return $this->release;
	}

	/**
	 * Get the [summary] column value.
	 * 
	 * @return     string
	 */
	public function getSummary()
	{
		return $this->summary;
	}

	/**
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Get the [url] column value.
	 * 
	 * @return     string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Get the [rpm_pkgid] column value.
	 * 
	 * @return     string
	 */
	public function getRpmPkgid()
	{
		return $this->rpm_pkgid;
	}

	/**
	 * Get the [optionally formatted] temporal [build_time] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getBuildTime($format = 'Y-m-d H:i:s')
	{
		if ($this->build_time === null) {
			return null;
		}



		try {
			$dt = new DateTime($this->build_time);
		} catch (Exception $x) {
			throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->build_time, true), $x);
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [size] column value.
	 * 
	 * @return     int
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * Get the [realarch] column value.
	 * 
	 * @return     string
	 */
	public function getRealarch()
	{
		return $this->realarch;
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
	 * Get the [is_source] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsSource()
	{
		return $this->is_source;
	}

	/**
	 * Get the [source_rpm_id] column value.
	 * 
	 * @return     int
	 */
	public function getSourceRpmId()
	{
		return $this->source_rpm_id;
	}

	/**
	 * Get the [source_rpm_name] column value.
	 * 
	 * @return     string
	 */
	public function getSourceRpmName()
	{
		return $this->source_rpm_name;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RpmPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [package_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setPackageId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->package_id !== $v) {
			$this->package_id = $v;
			$this->modifiedColumns[] = RpmPeer::PACKAGE_ID;
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
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setDistreleaseId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->distrelease_id !== $v) {
			$this->distrelease_id = $v;
			$this->modifiedColumns[] = RpmPeer::DISTRELEASE_ID;
		}

		if ($this->aDistrelease !== null && $this->aDistrelease->getId() !== $v) {
			$this->aDistrelease = null;
		}

		return $this;
	} // setDistreleaseId()

	/**
	 * Set the value of [media_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setMediaId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->media_id !== $v) {
			$this->media_id = $v;
			$this->modifiedColumns[] = RpmPeer::MEDIA_ID;
		}

		if ($this->aMedia !== null && $this->aMedia->getId() !== $v) {
			$this->aMedia = null;
		}

		return $this;
	} // setMediaId()

	/**
	 * Set the value of [rpm_group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setRpmGroupId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->rpm_group_id !== $v) {
			$this->rpm_group_id = $v;
			$this->modifiedColumns[] = RpmPeer::RPM_GROUP_ID;
		}

		if ($this->aRpmGroup !== null && $this->aRpmGroup->getId() !== $v) {
			$this->aRpmGroup = null;
		}

		return $this;
	} // setRpmGroupId()

	/**
	 * Set the value of [licence] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setLicence($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->licence !== $v) {
			$this->licence = $v;
			$this->modifiedColumns[] = RpmPeer::LICENCE;
		}

		return $this;
	} // setLicence()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = RpmPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [md5_name] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setMd5Name($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->md5_name !== $v) {
			$this->md5_name = $v;
			$this->modifiedColumns[] = RpmPeer::MD5_NAME;
		}

		return $this;
	} // setMd5Name()

	/**
	 * Set the value of [filename] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setFilename($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->filename !== $v) {
			$this->filename = $v;
			$this->modifiedColumns[] = RpmPeer::FILENAME;
		}

		return $this;
	} // setFilename()

	/**
	 * Set the value of [short_name] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setShortName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->short_name !== $v) {
			$this->short_name = $v;
			$this->modifiedColumns[] = RpmPeer::SHORT_NAME;
		}

		return $this;
	} // setShortName()

	/**
	 * Set the value of [evr] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setEvr($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->evr !== $v) {
			$this->evr = $v;
			$this->modifiedColumns[] = RpmPeer::EVR;
		}

		return $this;
	} // setEvr()

	/**
	 * Set the value of [version] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setVersion($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->version !== $v) {
			$this->version = $v;
			$this->modifiedColumns[] = RpmPeer::VERSION;
		}

		return $this;
	} // setVersion()

	/**
	 * Set the value of [release] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setRelease($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->release !== $v) {
			$this->release = $v;
			$this->modifiedColumns[] = RpmPeer::RELEASE;
		}

		return $this;
	} // setRelease()

	/**
	 * Set the value of [summary] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setSummary($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->summary !== $v) {
			$this->summary = $v;
			$this->modifiedColumns[] = RpmPeer::SUMMARY;
		}

		return $this;
	} // setSummary()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = RpmPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Set the value of [url] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setUrl($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = RpmPeer::URL;
		}

		return $this;
	} // setUrl()

	/**
	 * Set the value of [rpm_pkgid] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setRpmPkgid($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->rpm_pkgid !== $v) {
			$this->rpm_pkgid = $v;
			$this->modifiedColumns[] = RpmPeer::RPM_PKGID;
		}

		return $this;
	} // setRpmPkgid()

	/**
	 * Sets the value of [build_time] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setBuildTime($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->build_time !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->build_time !== null && $tmpDt = new DateTime($this->build_time)) ? $tmpDt->format('Y-m-d\\TH:i:sO') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d\\TH:i:sO') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->build_time = ($dt ? $dt->format('Y-m-d\\TH:i:sO') : null);
				$this->modifiedColumns[] = RpmPeer::BUILD_TIME;
			}
		} // if either are not null

		return $this;
	} // setBuildTime()

	/**
	 * Set the value of [size] column.
	 * 
	 * @param      int $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setSize($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->size !== $v) {
			$this->size = $v;
			$this->modifiedColumns[] = RpmPeer::SIZE;
		}

		return $this;
	} // setSize()

	/**
	 * Set the value of [realarch] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setRealarch($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->realarch !== $v) {
			$this->realarch = $v;
			$this->modifiedColumns[] = RpmPeer::REALARCH;
		}

		return $this;
	} // setRealarch()

	/**
	 * Set the value of [arch_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setArchId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->arch_id !== $v) {
			$this->arch_id = $v;
			$this->modifiedColumns[] = RpmPeer::ARCH_ID;
		}

		if ($this->aArch !== null && $this->aArch->getId() !== $v) {
			$this->aArch = null;
		}

		return $this;
	} // setArchId()

	/**
	 * Set the value of [is_source] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setIsSource($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_source !== $v) {
			$this->is_source = $v;
			$this->modifiedColumns[] = RpmPeer::IS_SOURCE;
		}

		return $this;
	} // setIsSource()

	/**
	 * Set the value of [source_rpm_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setSourceRpmId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->source_rpm_id !== $v) {
			$this->source_rpm_id = $v;
			$this->modifiedColumns[] = RpmPeer::SOURCE_RPM_ID;
		}

		if ($this->aRpmRelatedBySourceRpmId !== null && $this->aRpmRelatedBySourceRpmId->getId() !== $v) {
			$this->aRpmRelatedBySourceRpmId = null;
		}

		return $this;
	} // setSourceRpmId()

	/**
	 * Set the value of [source_rpm_name] column.
	 * 
	 * @param      string $v new value
	 * @return     Rpm The current object (for fluent API support)
	 */
	public function setSourceRpmName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->source_rpm_name !== $v) {
			$this->source_rpm_name = $v;
			$this->modifiedColumns[] = RpmPeer::SOURCE_RPM_NAME;
		}

		return $this;
	} // setSourceRpmName()

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
			$this->package_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->distrelease_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->media_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->rpm_group_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->licence = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->name = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->md5_name = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->filename = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->short_name = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->evr = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->version = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->release = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->summary = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->description = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
			$this->url = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
			$this->rpm_pkgid = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
			$this->build_time = ($row[$startcol + 17] !== null) ? (string) $row[$startcol + 17] : null;
			$this->size = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
			$this->realarch = ($row[$startcol + 19] !== null) ? (string) $row[$startcol + 19] : null;
			$this->arch_id = ($row[$startcol + 20] !== null) ? (int) $row[$startcol + 20] : null;
			$this->is_source = ($row[$startcol + 21] !== null) ? (boolean) $row[$startcol + 21] : null;
			$this->source_rpm_id = ($row[$startcol + 22] !== null) ? (int) $row[$startcol + 22] : null;
			$this->source_rpm_name = ($row[$startcol + 23] !== null) ? (string) $row[$startcol + 23] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 24; // 24 = RpmPeer::NUM_COLUMNS - RpmPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Rpm object", $e);
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

		if ($this->aPackage !== null && $this->package_id !== $this->aPackage->getId()) {
			$this->aPackage = null;
		}
		if ($this->aDistrelease !== null && $this->distrelease_id !== $this->aDistrelease->getId()) {
			$this->aDistrelease = null;
		}
		if ($this->aMedia !== null && $this->media_id !== $this->aMedia->getId()) {
			$this->aMedia = null;
		}
		if ($this->aRpmGroup !== null && $this->rpm_group_id !== $this->aRpmGroup->getId()) {
			$this->aRpmGroup = null;
		}
		if ($this->aArch !== null && $this->arch_id !== $this->aArch->getId()) {
			$this->aArch = null;
		}
		if ($this->aRpmRelatedBySourceRpmId !== null && $this->source_rpm_id !== $this->aRpmRelatedBySourceRpmId->getId()) {
			$this->aRpmRelatedBySourceRpmId = null;
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
			$con = Propel::getConnection(RpmPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = RpmPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPackage = null;
			$this->aDistrelease = null;
			$this->aMedia = null;
			$this->aRpmGroup = null;
			$this->aArch = null;
			$this->aRpmRelatedBySourceRpmId = null;
			$this->collRpmsRelatedBySourceRpmId = null;
			$this->lastRpmRelatedBySourceRpmIdCriteria = null;

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
			$con = Propel::getConnection(RpmPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseRpm:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				RpmPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseRpm:delete:post') as $callable)
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
			$con = Propel::getConnection(RpmPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseRpm:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseRpm:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				RpmPeer::addInstanceToPool($this);
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

			if ($this->aMedia !== null) {
				if ($this->aMedia->isModified() || $this->aMedia->isNew()) {
					$affectedRows += $this->aMedia->save($con);
				}
				$this->setMedia($this->aMedia);
			}

			if ($this->aRpmGroup !== null) {
				if ($this->aRpmGroup->isModified() || $this->aRpmGroup->isNew()) {
					$affectedRows += $this->aRpmGroup->save($con);
				}
				$this->setRpmGroup($this->aRpmGroup);
			}

			if ($this->aArch !== null) {
				if ($this->aArch->isModified() || $this->aArch->isNew()) {
					$affectedRows += $this->aArch->save($con);
				}
				$this->setArch($this->aArch);
			}

			if ($this->aRpmRelatedBySourceRpmId !== null) {
				if ($this->aRpmRelatedBySourceRpmId->isModified() || $this->aRpmRelatedBySourceRpmId->isNew()) {
					$affectedRows += $this->aRpmRelatedBySourceRpmId->save($con);
				}
				$this->setRpmRelatedBySourceRpmId($this->aRpmRelatedBySourceRpmId);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = RpmPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = RpmPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += RpmPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collRpmsRelatedBySourceRpmId !== null) {
				foreach ($this->collRpmsRelatedBySourceRpmId as $referrerFK) {
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

			if ($this->aMedia !== null) {
				if (!$this->aMedia->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMedia->getValidationFailures());
				}
			}

			if ($this->aRpmGroup !== null) {
				if (!$this->aRpmGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRpmGroup->getValidationFailures());
				}
			}

			if ($this->aArch !== null) {
				if (!$this->aArch->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArch->getValidationFailures());
				}
			}

			if ($this->aRpmRelatedBySourceRpmId !== null) {
				if (!$this->aRpmRelatedBySourceRpmId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRpmRelatedBySourceRpmId->getValidationFailures());
				}
			}


			if (($retval = RpmPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collRpmsRelatedBySourceRpmId !== null) {
					foreach ($this->collRpmsRelatedBySourceRpmId as $referrerFK) {
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
		$pos = RpmPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getPackageId();
				break;
			case 2:
				return $this->getDistreleaseId();
				break;
			case 3:
				return $this->getMediaId();
				break;
			case 4:
				return $this->getRpmGroupId();
				break;
			case 5:
				return $this->getLicence();
				break;
			case 6:
				return $this->getName();
				break;
			case 7:
				return $this->getMd5Name();
				break;
			case 8:
				return $this->getFilename();
				break;
			case 9:
				return $this->getShortName();
				break;
			case 10:
				return $this->getEvr();
				break;
			case 11:
				return $this->getVersion();
				break;
			case 12:
				return $this->getRelease();
				break;
			case 13:
				return $this->getSummary();
				break;
			case 14:
				return $this->getDescription();
				break;
			case 15:
				return $this->getUrl();
				break;
			case 16:
				return $this->getRpmPkgid();
				break;
			case 17:
				return $this->getBuildTime();
				break;
			case 18:
				return $this->getSize();
				break;
			case 19:
				return $this->getRealarch();
				break;
			case 20:
				return $this->getArchId();
				break;
			case 21:
				return $this->getIsSource();
				break;
			case 22:
				return $this->getSourceRpmId();
				break;
			case 23:
				return $this->getSourceRpmName();
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
		$keys = RpmPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getPackageId(),
			$keys[2] => $this->getDistreleaseId(),
			$keys[3] => $this->getMediaId(),
			$keys[4] => $this->getRpmGroupId(),
			$keys[5] => $this->getLicence(),
			$keys[6] => $this->getName(),
			$keys[7] => $this->getMd5Name(),
			$keys[8] => $this->getFilename(),
			$keys[9] => $this->getShortName(),
			$keys[10] => $this->getEvr(),
			$keys[11] => $this->getVersion(),
			$keys[12] => $this->getRelease(),
			$keys[13] => $this->getSummary(),
			$keys[14] => $this->getDescription(),
			$keys[15] => $this->getUrl(),
			$keys[16] => $this->getRpmPkgid(),
			$keys[17] => $this->getBuildTime(),
			$keys[18] => $this->getSize(),
			$keys[19] => $this->getRealarch(),
			$keys[20] => $this->getArchId(),
			$keys[21] => $this->getIsSource(),
			$keys[22] => $this->getSourceRpmId(),
			$keys[23] => $this->getSourceRpmName(),
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
		$pos = RpmPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setPackageId($value);
				break;
			case 2:
				$this->setDistreleaseId($value);
				break;
			case 3:
				$this->setMediaId($value);
				break;
			case 4:
				$this->setRpmGroupId($value);
				break;
			case 5:
				$this->setLicence($value);
				break;
			case 6:
				$this->setName($value);
				break;
			case 7:
				$this->setMd5Name($value);
				break;
			case 8:
				$this->setFilename($value);
				break;
			case 9:
				$this->setShortName($value);
				break;
			case 10:
				$this->setEvr($value);
				break;
			case 11:
				$this->setVersion($value);
				break;
			case 12:
				$this->setRelease($value);
				break;
			case 13:
				$this->setSummary($value);
				break;
			case 14:
				$this->setDescription($value);
				break;
			case 15:
				$this->setUrl($value);
				break;
			case 16:
				$this->setRpmPkgid($value);
				break;
			case 17:
				$this->setBuildTime($value);
				break;
			case 18:
				$this->setSize($value);
				break;
			case 19:
				$this->setRealarch($value);
				break;
			case 20:
				$this->setArchId($value);
				break;
			case 21:
				$this->setIsSource($value);
				break;
			case 22:
				$this->setSourceRpmId($value);
				break;
			case 23:
				$this->setSourceRpmName($value);
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
		$keys = RpmPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPackageId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDistreleaseId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMediaId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRpmGroupId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLicence($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setName($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMd5Name($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setFilename($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setShortName($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setEvr($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setVersion($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setRelease($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setSummary($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setDescription($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUrl($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setRpmPkgid($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setBuildTime($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setSize($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setRealarch($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setArchId($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setIsSource($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setSourceRpmId($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setSourceRpmName($arr[$keys[23]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(RpmPeer::DATABASE_NAME);

		if ($this->isColumnModified(RpmPeer::ID)) $criteria->add(RpmPeer::ID, $this->id);
		if ($this->isColumnModified(RpmPeer::PACKAGE_ID)) $criteria->add(RpmPeer::PACKAGE_ID, $this->package_id);
		if ($this->isColumnModified(RpmPeer::DISTRELEASE_ID)) $criteria->add(RpmPeer::DISTRELEASE_ID, $this->distrelease_id);
		if ($this->isColumnModified(RpmPeer::MEDIA_ID)) $criteria->add(RpmPeer::MEDIA_ID, $this->media_id);
		if ($this->isColumnModified(RpmPeer::RPM_GROUP_ID)) $criteria->add(RpmPeer::RPM_GROUP_ID, $this->rpm_group_id);
		if ($this->isColumnModified(RpmPeer::LICENCE)) $criteria->add(RpmPeer::LICENCE, $this->licence);
		if ($this->isColumnModified(RpmPeer::NAME)) $criteria->add(RpmPeer::NAME, $this->name);
		if ($this->isColumnModified(RpmPeer::MD5_NAME)) $criteria->add(RpmPeer::MD5_NAME, $this->md5_name);
		if ($this->isColumnModified(RpmPeer::FILENAME)) $criteria->add(RpmPeer::FILENAME, $this->filename);
		if ($this->isColumnModified(RpmPeer::SHORT_NAME)) $criteria->add(RpmPeer::SHORT_NAME, $this->short_name);
		if ($this->isColumnModified(RpmPeer::EVR)) $criteria->add(RpmPeer::EVR, $this->evr);
		if ($this->isColumnModified(RpmPeer::VERSION)) $criteria->add(RpmPeer::VERSION, $this->version);
		if ($this->isColumnModified(RpmPeer::RELEASE)) $criteria->add(RpmPeer::RELEASE, $this->release);
		if ($this->isColumnModified(RpmPeer::SUMMARY)) $criteria->add(RpmPeer::SUMMARY, $this->summary);
		if ($this->isColumnModified(RpmPeer::DESCRIPTION)) $criteria->add(RpmPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(RpmPeer::URL)) $criteria->add(RpmPeer::URL, $this->url);
		if ($this->isColumnModified(RpmPeer::RPM_PKGID)) $criteria->add(RpmPeer::RPM_PKGID, $this->rpm_pkgid);
		if ($this->isColumnModified(RpmPeer::BUILD_TIME)) $criteria->add(RpmPeer::BUILD_TIME, $this->build_time);
		if ($this->isColumnModified(RpmPeer::SIZE)) $criteria->add(RpmPeer::SIZE, $this->size);
		if ($this->isColumnModified(RpmPeer::REALARCH)) $criteria->add(RpmPeer::REALARCH, $this->realarch);
		if ($this->isColumnModified(RpmPeer::ARCH_ID)) $criteria->add(RpmPeer::ARCH_ID, $this->arch_id);
		if ($this->isColumnModified(RpmPeer::IS_SOURCE)) $criteria->add(RpmPeer::IS_SOURCE, $this->is_source);
		if ($this->isColumnModified(RpmPeer::SOURCE_RPM_ID)) $criteria->add(RpmPeer::SOURCE_RPM_ID, $this->source_rpm_id);
		if ($this->isColumnModified(RpmPeer::SOURCE_RPM_NAME)) $criteria->add(RpmPeer::SOURCE_RPM_NAME, $this->source_rpm_name);

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
		$criteria = new Criteria(RpmPeer::DATABASE_NAME);

		$criteria->add(RpmPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Rpm (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setPackageId($this->package_id);

		$copyObj->setDistreleaseId($this->distrelease_id);

		$copyObj->setMediaId($this->media_id);

		$copyObj->setRpmGroupId($this->rpm_group_id);

		$copyObj->setLicence($this->licence);

		$copyObj->setName($this->name);

		$copyObj->setMd5Name($this->md5_name);

		$copyObj->setFilename($this->filename);

		$copyObj->setShortName($this->short_name);

		$copyObj->setEvr($this->evr);

		$copyObj->setVersion($this->version);

		$copyObj->setRelease($this->release);

		$copyObj->setSummary($this->summary);

		$copyObj->setDescription($this->description);

		$copyObj->setUrl($this->url);

		$copyObj->setRpmPkgid($this->rpm_pkgid);

		$copyObj->setBuildTime($this->build_time);

		$copyObj->setSize($this->size);

		$copyObj->setRealarch($this->realarch);

		$copyObj->setArchId($this->arch_id);

		$copyObj->setIsSource($this->is_source);

		$copyObj->setSourceRpmId($this->source_rpm_id);

		$copyObj->setSourceRpmName($this->source_rpm_name);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getRpmsRelatedBySourceRpmId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRpmRelatedBySourceRpmId($relObj->copy($deepCopy));
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
	 * @return     Rpm Clone of current object.
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
	 * @return     RpmPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RpmPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Package object.
	 *
	 * @param      Package $v
	 * @return     Rpm The current object (for fluent API support)
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
			$v->addRpm($this);
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
			   $this->aPackage->addRpms($this);
			 */
		}
		return $this->aPackage;
	}

	/**
	 * Declares an association between this object and a Distrelease object.
	 *
	 * @param      Distrelease $v
	 * @return     Rpm The current object (for fluent API support)
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
			$v->addRpm($this);
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
			   $this->aDistrelease->addRpms($this);
			 */
		}
		return $this->aDistrelease;
	}

	/**
	 * Declares an association between this object and a Media object.
	 *
	 * @param      Media $v
	 * @return     Rpm The current object (for fluent API support)
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
			$v->addRpm($this);
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
			   $this->aMedia->addRpms($this);
			 */
		}
		return $this->aMedia;
	}

	/**
	 * Declares an association between this object and a RpmGroup object.
	 *
	 * @param      RpmGroup $v
	 * @return     Rpm The current object (for fluent API support)
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
			$v->addRpm($this);
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
			   $this->aRpmGroup->addRpms($this);
			 */
		}
		return $this->aRpmGroup;
	}

	/**
	 * Declares an association between this object and a Arch object.
	 *
	 * @param      Arch $v
	 * @return     Rpm The current object (for fluent API support)
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
			$v->addRpm($this);
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
			   $this->aArch->addRpms($this);
			 */
		}
		return $this->aArch;
	}

	/**
	 * Declares an association between this object and a Rpm object.
	 *
	 * @param      Rpm $v
	 * @return     Rpm The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setRpmRelatedBySourceRpmId(Rpm $v = null)
	{
		if ($v === null) {
			$this->setSourceRpmId(NULL);
		} else {
			$this->setSourceRpmId($v->getId());
		}

		$this->aRpmRelatedBySourceRpmId = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Rpm object, it will not be re-added.
		if ($v !== null) {
			$v->addRpmRelatedBySourceRpmId($this);
		}

		return $this;
	}


	/**
	 * Get the associated Rpm object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Rpm The associated Rpm object.
	 * @throws     PropelException
	 */
	public function getRpmRelatedBySourceRpmId(PropelPDO $con = null)
	{
		if ($this->aRpmRelatedBySourceRpmId === null && ($this->source_rpm_id !== null)) {
			$this->aRpmRelatedBySourceRpmId = RpmPeer::retrieveByPk($this->source_rpm_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aRpmRelatedBySourceRpmId->addRpmsRelatedBySourceRpmId($this);
			 */
		}
		return $this->aRpmRelatedBySourceRpmId;
	}

	/**
	 * Clears out the collRpmsRelatedBySourceRpmId collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRpmsRelatedBySourceRpmId()
	 */
	public function clearRpmsRelatedBySourceRpmId()
	{
		$this->collRpmsRelatedBySourceRpmId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRpmsRelatedBySourceRpmId collection (array).
	 *
	 * By default this just sets the collRpmsRelatedBySourceRpmId collection to an empty array (like clearcollRpmsRelatedBySourceRpmId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initRpmsRelatedBySourceRpmId()
	{
		$this->collRpmsRelatedBySourceRpmId = array();
	}

	/**
	 * Gets an array of Rpm objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Rpm has previously been saved, it will retrieve
	 * related RpmsRelatedBySourceRpmId from storage. If this Rpm is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Rpm[]
	 * @throws     PropelException
	 */
	public function getRpmsRelatedBySourceRpmId($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpmsRelatedBySourceRpmId === null) {
			if ($this->isNew()) {
			   $this->collRpmsRelatedBySourceRpmId = array();
			} else {

				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				RpmPeer::addSelectColumns($criteria);
				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				RpmPeer::addSelectColumns($criteria);
				if (!isset($this->lastRpmRelatedBySourceRpmIdCriteria) || !$this->lastRpmRelatedBySourceRpmIdCriteria->equals($criteria)) {
					$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRpmRelatedBySourceRpmIdCriteria = $criteria;
		return $this->collRpmsRelatedBySourceRpmId;
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
	public function countRpmsRelatedBySourceRpmId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collRpmsRelatedBySourceRpmId === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				$count = RpmPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				if (!isset($this->lastRpmRelatedBySourceRpmIdCriteria) || !$this->lastRpmRelatedBySourceRpmIdCriteria->equals($criteria)) {
					$count = RpmPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collRpmsRelatedBySourceRpmId);
				}
			} else {
				$count = count($this->collRpmsRelatedBySourceRpmId);
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
	public function addRpmRelatedBySourceRpmId(Rpm $l)
	{
		if ($this->collRpmsRelatedBySourceRpmId === null) {
			$this->initRpmsRelatedBySourceRpmId();
		}
		if (!in_array($l, $this->collRpmsRelatedBySourceRpmId, true)) { // only add it if the **same** object is not already associated
			array_push($this->collRpmsRelatedBySourceRpmId, $l);
			$l->setRpmRelatedBySourceRpmId($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Rpm is new, it will return
	 * an empty collection; or if this Rpm has previously
	 * been saved, it will retrieve related RpmsRelatedBySourceRpmId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Rpm.
	 */
	public function getRpmsRelatedBySourceRpmIdJoinPackage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpmsRelatedBySourceRpmId === null) {
			if ($this->isNew()) {
				$this->collRpmsRelatedBySourceRpmId = array();
			} else {

				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

			if (!isset($this->lastRpmRelatedBySourceRpmIdCriteria) || !$this->lastRpmRelatedBySourceRpmIdCriteria->equals($criteria)) {
				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinPackage($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmRelatedBySourceRpmIdCriteria = $criteria;

		return $this->collRpmsRelatedBySourceRpmId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Rpm is new, it will return
	 * an empty collection; or if this Rpm has previously
	 * been saved, it will retrieve related RpmsRelatedBySourceRpmId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Rpm.
	 */
	public function getRpmsRelatedBySourceRpmIdJoinDistrelease($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpmsRelatedBySourceRpmId === null) {
			if ($this->isNew()) {
				$this->collRpmsRelatedBySourceRpmId = array();
			} else {

				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinDistrelease($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

			if (!isset($this->lastRpmRelatedBySourceRpmIdCriteria) || !$this->lastRpmRelatedBySourceRpmIdCriteria->equals($criteria)) {
				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinDistrelease($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmRelatedBySourceRpmIdCriteria = $criteria;

		return $this->collRpmsRelatedBySourceRpmId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Rpm is new, it will return
	 * an empty collection; or if this Rpm has previously
	 * been saved, it will retrieve related RpmsRelatedBySourceRpmId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Rpm.
	 */
	public function getRpmsRelatedBySourceRpmIdJoinMedia($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpmsRelatedBySourceRpmId === null) {
			if ($this->isNew()) {
				$this->collRpmsRelatedBySourceRpmId = array();
			} else {

				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

			if (!isset($this->lastRpmRelatedBySourceRpmIdCriteria) || !$this->lastRpmRelatedBySourceRpmIdCriteria->equals($criteria)) {
				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinMedia($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmRelatedBySourceRpmIdCriteria = $criteria;

		return $this->collRpmsRelatedBySourceRpmId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Rpm is new, it will return
	 * an empty collection; or if this Rpm has previously
	 * been saved, it will retrieve related RpmsRelatedBySourceRpmId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Rpm.
	 */
	public function getRpmsRelatedBySourceRpmIdJoinRpmGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpmsRelatedBySourceRpmId === null) {
			if ($this->isNew()) {
				$this->collRpmsRelatedBySourceRpmId = array();
			} else {

				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

			if (!isset($this->lastRpmRelatedBySourceRpmIdCriteria) || !$this->lastRpmRelatedBySourceRpmIdCriteria->equals($criteria)) {
				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinRpmGroup($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmRelatedBySourceRpmIdCriteria = $criteria;

		return $this->collRpmsRelatedBySourceRpmId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Rpm is new, it will return
	 * an empty collection; or if this Rpm has previously
	 * been saved, it will retrieve related RpmsRelatedBySourceRpmId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Rpm.
	 */
	public function getRpmsRelatedBySourceRpmIdJoinArch($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRpmsRelatedBySourceRpmId === null) {
			if ($this->isNew()) {
				$this->collRpmsRelatedBySourceRpmId = array();
			} else {

				$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RpmPeer::SOURCE_RPM_ID, $this->id);

			if (!isset($this->lastRpmRelatedBySourceRpmIdCriteria) || !$this->lastRpmRelatedBySourceRpmIdCriteria->equals($criteria)) {
				$this->collRpmsRelatedBySourceRpmId = RpmPeer::doSelectJoinArch($criteria, $con, $join_behavior);
			}
		}
		$this->lastRpmRelatedBySourceRpmIdCriteria = $criteria;

		return $this->collRpmsRelatedBySourceRpmId;
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
	 * Otherwise if this Rpm has previously been saved, it will retrieve
	 * related Notifications from storage. If this Rpm is new, it will return
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
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotifications === null) {
			if ($this->isNew()) {
			   $this->collNotifications = array();
			} else {

				$criteria->add(NotificationPeer::RPM_ID, $this->id);

				NotificationPeer::addSelectColumns($criteria);
				$this->collNotifications = NotificationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NotificationPeer::RPM_ID, $this->id);

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
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
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

				$criteria->add(NotificationPeer::RPM_ID, $this->id);

				$count = NotificationPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(NotificationPeer::RPM_ID, $this->id);

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
			$l->setRpm($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Rpm is new, it will return
	 * an empty collection; or if this Rpm has previously
	 * been saved, it will retrieve related Notifications from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Rpm.
	 */
	public function getNotificationsJoinSubscription($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(RpmPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNotifications === null) {
			if ($this->isNew()) {
				$this->collNotifications = array();
			} else {

				$criteria->add(NotificationPeer::RPM_ID, $this->id);

				$this->collNotifications = NotificationPeer::doSelectJoinSubscription($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NotificationPeer::RPM_ID, $this->id);

			if (!isset($this->lastNotificationCriteria) || !$this->lastNotificationCriteria->equals($criteria)) {
				$this->collNotifications = NotificationPeer::doSelectJoinSubscription($criteria, $con, $join_behavior);
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
			if ($this->collRpmsRelatedBySourceRpmId) {
				foreach ((array) $this->collRpmsRelatedBySourceRpmId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collNotifications) {
				foreach ((array) $this->collNotifications as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collRpmsRelatedBySourceRpmId = null;
		$this->collNotifications = null;
			$this->aPackage = null;
			$this->aDistrelease = null;
			$this->aMedia = null;
			$this->aRpmGroup = null;
			$this->aArch = null;
			$this->aRpmRelatedBySourceRpmId = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseRpm:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseRpm::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseRpm
