drop table if exists rpmlinearized;
truncate table rpm_group;
truncate table arch;
truncate table media;
truncate table distrelease;
truncate table package;
truncate table rpm;
truncate table rpm_group;

create table rpmlinearized
(
  filename varchar(255),
  evr varchar(255),
  summary varchar(255),
  description text,
  buildtime datetime,
  url text,
  rpm_size int,
  source_rpm varchar(255),
  license varchar(255),
  rpm_group varchar(255),
  realarch varchar(45),
  media_name varchar(45), 
  media_distrib__1 text,
  media_vendor varchar(255),
  version varchar(45),
  media_arch varchar(45),
  rpm_pkgid char(32)

);

load data local infile './tmp/reduced_file' into table rpmlinearized character set latin1;

alter table rpmlinearized add index index_filename (filename);
alter table rpmlinearized add index index_version (version);
alter table rpmlinearized add index index_media (media_name, media_vendor);
alter table rpmlinearized add index index_group (rpm_group);
alter table rpmlinearized add index index_media_arch (media_arch);
alter table rpmlinearized add index index_source_rpm (source_rpm);

delete from rpmlinearized where version NOT IN (
	'cooker', 
	'2007.0',
	'2007.1',
	'2008.0',
	'2008.1',
	'2009.0',
	'2009.1',
	'2010.0',
	'2010.1',
	'2010.2',
	'2011.0',
	'2011.1',
	'2012.0',
	'2012.1',
	'2013.0',
	'2013.1'
);

alter table rpmlinearized add package_name varchar(255);

update rpmlinearized
set package_name = LCASE(SUBSTRING(filename, 1, LENGTH(filename) - (LENGTH(SUBSTRING_INDEX(filename, '-', -2))+1)));

delete from rpmlinearized where package_name LIKE '%-debug';


insert into rpm_group (name)
select distinct rpm_group from rpmlinearized where rpm_group <> '';

insert into arch(name)
select distinct media_arch from rpmlinearized where media_arch <> '';

insert into media(name, vendor)
select distinct media_name, media_vendor from rpmlinearized where media_name <> '';

update media set is_updates=true where name like '%updates%';
update media set is_backports=true where name like '%backports%';
update media set is_updates=true, is_testing=true where name like '%testing%';
update media set is_third_party=true where name like 'plf%';

insert into distrelease (name)
select distinct version from rpmlinearized where version <> '';

update distrelease
set is_latest = true where name = '2010.1';

update distrelease
set is_dev_version = true where name = 'cooker';



insert into rpm (distrelease_id, media_id, rpm_group_id, licence, name, short_name, evr, version, `release`, `summary`, `description`, `url`, `rpm_pkgid`, `build_time`, `size`, `realarch`, `arch_id`)
select  distrelease.id, 
        media.id, 
        rpm_group.id, 
        license, 
        filename, 
        package_name, 
        evr, 
        SUBSTRING(evr, 1, LENGTH(SUBSTRING_INDEX(evr, '-', 1))),
        SUBSTRING(evr, LENGTH(SUBSTRING_INDEX(evr, '-', 1))+2),
        rpmlinearized.summary, 
        rpmlinearized.description, 
        url, 
        rpm_pkgid, 
        buildtime, 
        rpm_size, 
        realarch, 
        arch.id
from rpmlinearized, distrelease, media, rpm_group, arch
where rpmlinearized.version = distrelease.name
  and rpmlinearized.media_name = media.name
  and rpmlinearized.media_vendor = media.vendor
  and rpmlinearized.rpm_group = rpm_group.name
  and rpmlinearized.media_arch = arch.name
;

UPDATE rpm 
SET is_source=true,
    source_rpm_id = id
WHERE name LIKE '%.src.rpm'; 

UPDATE rpm
JOIN media ON rpm.media_id = media.ID
JOIN arch ON rpm.arch_id = arch.ID
JOIN rpmlinearized ON rpm.name=rpmlinearized.filename AND media.name = rpmlinearized.media_name AND arch.name = rpmlinearized.media_arch
JOIN rpm as sourcerpm ON rpmlinearized.source_rpm = sourcerpm.name AND rpm.media_id = sourcerpm.media_id AND rpm.arch_id = sourcerpm.arch_id
SET rpm.source_rpm_id = sourcerpm.id;



insert into package (name, md5_name, is_source)
select distinct short_name, md5(CONCAT(short_name, '-', is_source)), is_source from rpm;

UPDATE rpm
JOIN package ON rpm.short_name = package.name AND rpm.is_source = package.is_source
SET rpm.PACKAGE_ID = package.ID;

update package 
set is_application = 1
where left(name, 3) <> 'lib'
  and name not like '%-devel'
  and name not like 'locales-__'
;

-- source packages of applications are flagged as applications too
update package as source_package
JOIN rpm as source_rpm ON source_package.ID = source_rpm.PACKAGE_ID
JOIN rpm ON source_rpm.ID = rpm.SOURCE_RPM_ID AND rpm.is_source = FALSE
JOIN package ON rpm.PACKAGE_ID = package.ID
SET source_package.is_application = 1
WHERE package.is_application = 1;


drop table rpmlinearized;
