#!/bin/bash

# Downloads and compares 2 RPMs
# Needs: rsync, rpmdiff, diff

if [ -z $6 ]
then
  echo "Usage: $0 MAGEIAVERSION ARCH MEDIA1 RPM1 MEDIA2 RPM2"
  echo
  echo "Example: $0 3 x86_64 core/release ruby-i18n-0.6.1-3.mga3.noarch.rpm core/updates_testing ruby-i18n-0.6.1-3.1.mga3.noarch.rpm"
  exit
fi

mkdir -p /tmp/qarpmdiff_tmp
cd /tmp/qarpmdiff_tmp

mirror=rsync://distrib-coffee.ipsl.jussieu.fr/pub/linux/Mageia/distrib/
distro=$1;
arch=$2;
media1=$3
rpm1=$4;
media2=$5
rpm2=$6


rm -f $rpm1;
rm -f $rpm2;

if [ $arch != 'SRPMS' ]
then
  filler="media/"
else
  filler=
fi

rsync -a --no-motd $mirror/$distro/$arch/$filler$media1/$rpm1 $rpm1
rsync -a --no-motd  $mirror/$distro/$arch/$filler$media2/$rpm2 $rpm2

echo
echo "*** rpmdiff output between $rpm1 and $rpm2 ***"
/usr/bin/rpmdiff -iT $rpm1 $rpm2
rm -rf /tmp/rpmlint.$rpm1*
rm -rf /tmp/rpmlint.$rpm2*

echo 
echo "*** unified diff between RPM contents ***"
rm -rf $rpm1.d
mkdir $rpm1.d
cd $rpm1.d
rpm2cpio ../$rpm1 | cpio -idm
cd ..

rm -rf $rpm2.d
mkdir $rpm2.d
cd $rpm2.d
rpm2cpio ../$rpm2 | cpio -idm
cd ..

LC_ALL=C diff -ruN $rpm1.d/ $rpm2.d/
rm -f $rpm1
rm -f $rpm2
rm -rf $rpm1.d
rm -rf $rpm2.d
