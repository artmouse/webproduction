#!/bin/bash
command=$1
dt=$(date +%Y-%b-%d:time=%H:%M:%S);
BOX_PATH=$(cd $(dirname $0) && pwd);
LOCAL_REVISION=$(svnversion  $BOX_PATH | sed s/[^0-9]//g | cut -c-5 );
echo "$LOCAL_REVISION";
echo "Running SVN update. Please wait...";
#svn info -R $BOX_PATH/modules > $BOX_PATH/log/modules-$dt-rev-$LOCAL_REVISION.log
#svn info $BOX_PATH  > $BOX_PATH/log/core-$dt-rev-$LOCAL_REVISION.log


if [[ -z $command ]];
then
echo -en "START UPDATE"
echo -en " "
echo "##########################START UPDATE=$dt#########################" >> $BOX_PATH/svnup.log
echo "=========================================OLD-CORE========================================" >> $BOX_PATH/svnup.log
svn info $BOX_PATH | sed -n -e6p -e3p >> $BOX_PATH/svnup.log
echo "=======================================OLD-MODULES=======================================" >> $BOX_PATH/svnup.log
svn info  $BOX_PATH/modules/* | sed  -e '/Rev/b; /URL/b; /Ревиз/b' -e d >> $BOX_PATH/svnup.log
svn cleanup $BOX_PATH/modules/*
svn cleanup $BOX_PATH
svn up  $BOX_PATH/modules/*
echo "Updating Engine"
svn up  $BOX_PATH
$BOX_PATH/updater.sh $LOCAL_REVISION
$BOX_PATH/updater.sh force
echo "===========================================NEW-CORE======================================" >> $BOX_PATH/svnup.log
svn info $BOX_PATH | sed -n -e6p -e3p >> $BOX_PATH/svnup.log
echo "=========================================NEW-MODULES=====================================" >> $BOX_PATH/svnup.log
svn info  $BOX_PATH/modules/* | sed  -e '/Rev/b; /URL/b; /Ревиз/b' -e d >> $BOX_PATH/svnup.log
echo "########################################END UPDATE#######################################" >> $BOX_PATH/svnup.log
echo "Finished";

elif [ -n $command ];
then
echo -en "START UPDATE 2 REVISION $command"
echo "##########################START UPDATE=$dt#########################" >> $BOX_PATH/svnup.log
echo "=========================================OLD-CORE========================================" >> $BOX_PATH/svnup.log
svn info $BOX_PATH | sed -n -e6p -e3p >> $BOX_PATH/svnup.log
echo "=======================================OLD-MODULES=======================================" >> $BOX_PATH/svnup.log
svn info  $BOX_PATH/modules/* | sed  -e '/Rev/b; /URL/b; /Ревиз/b' -e d >> $BOX_PATH/svnup.log
svn cleanup $BOX_PATH/modules/*
svn cleanup $BOX_PATH
svn up -r $command $BOX_PATH/modules/*
echo "Updating Engine"
svn up -r $command $BOX_PATH
$BOX_PATH/updater.sh $LOCAL_REVISION
$BOX_PATH/updater.sh force
echo "===========================================NEW-CORE======================================" >> $BOX_PATH/svnup.log
svn info $BOX_PATH | sed -n -e6p -e3p >> $BOX_PATH/svnup.log
echo "=========================================NEW-MODULES=====================================" >> $BOX_PATH/svnup.log
svn info  $BOX_PATH/modules/* | sed  -e '/Rev/b; /URL/b; /Ревиз/b' -e d >> $BOX_PATH/svnup.log
echo "########################################END UPDATE#######################################" >> $BOX_PATH/svnup.log
echo "Finished";
else
 echo "Error Update"
fi
