#!/bin/bash

cd ~/www/rtm.webproduction.ua/templates/rtm/media/import_images/

for archive in `ls *\.zip 2>/dev/null`
    do
        /usr/bin/unzip ${archive} -d `echo ${archive} | sed s/\.zip$//` && rm ${archive}
    done

exit 0
