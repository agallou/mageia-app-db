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
