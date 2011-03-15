drop table if exists rpmlinearized;
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

alter table rpmlinearized add package_name varchar(255);

update rpmlinearized
set package_name = LCASE(SUBSTRING(filename, 1, LENGTH(filename) - (LENGTH(SUBSTRING_INDEX(filename, '-', -2))+1)));
