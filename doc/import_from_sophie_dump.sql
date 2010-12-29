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
  source_rpm text,
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

load data local infile './tmp/reduced_file' into table rpmlinearized;

alter table rpmlinearized add index index_filename (filename);
alter table rpmlinearized add index index_version (version);
alter table rpmlinearized add index index_media (media_name, media_vendor);
alter table rpmlinearized add index index_group (rpm_group);
alter table rpmlinearized add index index_media_arch (media_arch);

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

insert into rpm_group (name)
select distinct rpm_group from rpmlinearized where rpm_group <> '';

insert into arch(name)
select distinct media_arch from rpmlinearized where media_arch <> '';

insert into media(name, vendor)
select distinct media_name, media_vendor from rpmlinearized where media_name <> '';

update media set is_updates=true where name like '%updates%';
update media set is_backports=true where name like '%backports%';
update media set is_updates=true, is_testing=true where name like '%testing%';

insert into distrelease (name)
select distinct version from rpmlinearized where version <> '';

update distrelease
set is_latest = true where name = '2010.1';

update distrelease
set is_dev_version = true where name = 'cooker';

insert into package (name, md5_name)
select distinct package_name, md5(package_name) from rpmlinearized;
update package 
set is_application = 1
where left(name, 3) <> 'lib'
  and name not like '%-devel'
  and name not like '%-debug'
  and name not like 'locales-__'
;



insert into rpm (package_id, distrelease_id, media_id, rpm_group_id, licence, name, evr, version, `release`, `summary`, `description`, `url`, `src_rpm`, `rpm_pkgid`, `build_time`, `size`, `realarch`, `arch_id`)
select  package.id, 
        distrelease.id, 
        media.id, 
        rpm_group.id, 
        license, 
        filename, 
        evr, 
        SUBSTRING(evr, 1, LENGTH(SUBSTRING_INDEX(evr, '-', 1))),
        SUBSTRING(evr, LENGTH(SUBSTRING_INDEX(evr, '-', 1))+2),
        summary, 
        description, 
        url, 
        source_rpm,
        rpm_pkgid, 
        buildtime, 
        rpm_size, 
        realarch, 
        arch.id
from rpmlinearized, package, distrelease, media, rpm_group, arch
where rpmlinearized.package_name = package.name
  and rpmlinearized.version = distrelease.name
  and rpmlinearized.media_name = media.name
  and rpmlinearized.media_vendor = media.vendor
  and rpmlinearized.rpm_group = rpm_group.name
  and rpmlinearized.media_arch = arch.name
;




drop table rpmlinearized;
