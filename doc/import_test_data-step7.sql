-- source packages of applications are flagged as applications too
update package as source_package
JOIN rpm as source_rpm ON source_package.ID = source_rpm.PACKAGE_ID
JOIN rpm ON source_rpm.ID = rpm.SOURCE_RPM_ID AND rpm.is_source = FALSE
JOIN package ON rpm.PACKAGE_ID = package.ID
SET source_package.is_application = 1
WHERE package.is_application = 1;

drop table rpmlinearized;