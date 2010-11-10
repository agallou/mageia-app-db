drop table if exists rpmlinearized;
truncate table rpm_group;
truncate table arch;
truncate table media;
truncate table distrelease;
truncate table package;
truncate table rpm;
truncate table rpm_group;
truncate table rpmfile;

create table rpmlinearized
(
  filename varchar(255),
  evr varchar(255),
  summary varchar(255),
  description varchar(45),
  buildtime timestamp,
  url__1 text,
  rpm_size int,
  source_rpm text,
  license varchar(255),
  rpm_group varchar(255),
  arch varchar(45),
  media_name varchar(45), 
  media_distrib__1 text,
  media_vendor varchar(255),
  version varchar(45),
  media_arch__1 text,
  rpm_pkgid char(32)

);

load data local infile './tmp/reduced_file' into table rpmlinearized;

alter table rpmlinearized add index index_filename (filename);
alter table rpmlinearized add index index_version (version);
alter table rpmlinearized add index index_media (media_name, media_vendor);
alter table rpmlinearized add index index_group (rpm_group);
alter table rpmlinearized add index index_arch (arch);

insert into rpm_group (name)
select distinct rpm_group from rpmlinearized where rpm_group <> '';

insert into arch(name)
select distinct arch from rpmlinearized where arch <> '';

insert into media(name, vendor)
select distinct media_name, media_vendor from rpmlinearized where media_name <> '';

insert into distrelease (name)
select distinct version from rpmlinearized where version <> '';

insert into package (name, md5_name)
select distinct filename, md5(filename) from rpmlinearized;

/* TODO ajouter un index sur package.name */
/* TODO supprimer index unique_name sur media et en ajouter un unique_media_vendor) */
insert into rpm (package_id, distrelease_id, media_id, rpm_group_id, licence, name, evr, version, `release`, `summary`, `description`, `url`, `src_rpm`)
select package.id, distrelease.id, media.id, rpm_group.id, license, filename, evr, evr, evr, summary, description, NULL, source_rpm
from rpmlinearized, package, distrelease, media, rpm_group
where rpmlinearized.filename = package.name
  and rpmlinearized.version = distrelease.name
  and rpmlinearized.media_name = media.name
  and rpmlinearized.media_vendor = media.vendor
  and rpmlinearized.rpm_group = rpm_group.name
;
/* TODO ajouter index sur rpm.name */
insert into rpmfile (rpm_pkgid, build_time, arch_id, rpm_id, `size`, arch)
select rpmlinearized.rpm_pkgid, rpmlinearized.buildtime, arch.id, rpm.id, rpmlinearized.rpm_size, arch.name
from rpmlinearized, arch, rpm
where rpmlinearized.filename = rpm.name
  and rpmlinearized.arch = arch.name
;

drop table rpmlinearized;

