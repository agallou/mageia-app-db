insert into rpm_group (name)
select distinct rpm_group from rpmlinearized where rpm_group <> '';

insert into arch(name)
select distinct media_arch from rpmlinearized where media_arch <> '';

insert into media(name, vendor)
select distinct media_name, media_vendor from rpmlinearized where media_name <> '';

insert into distrelease (name)
select distinct version from rpmlinearized where version <> '';
