#!/bin/bash
BOX_PATH=$(cd $(dirname $0) && pwd);

REDCOLOR='\033[0;31m'
GREENCOLOR='\033[0;32m'
NORMALCOLOR='\033[0m'
redsvn="https://svn.webproduction.ua/wpshop/wpshop/red"
greensvn="https://svn.webproduction.ua/wpshop/wpshop/green"
revision=$1
red=$red
if [[ -z $revision ]];
then
echo -en "введите ветку svn  ${REDCOLOR} red ${GREENCOLOR} green ${NORMALCOLOR}"

elif [[ "$revision" == "red" ]];
then
echo -en "${REDCOLOR} ВЕТКА RED ${NORMALCOLOR}"
(cd $BOX_PATH; svn sw $redsvn/core);
for i in `cd $BOX_PATH;find modules/ -mindepth 1 -maxdepth 1 -type d | sed 's/modules//'| sed '/template/d' | sed '/quiz/d'`;
do (cd $BOX_PATH/modules/$i; svn sw $redsvn/$i) ;
done

elif [[ "$revision" == "green" ]];
then
echo -en "${GREENCOLOR} ВЕТКА GREEN ${NORMALCOLOR}"
(cd $BOX_PATH; svn sw $greensvn/core);
for i in `cd $BOX_PATH;find modules/ -mindepth 1 -maxdepth 1 -type d | sed 's/modules//'| sed '/template/d' | sed '/quiz/d'`;
do (cd $BOX_PATH/modules/$i; svn sw $greensvn/$i) ;
done
else
echo "Error"
fi
