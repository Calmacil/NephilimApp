#!/bin/bash

DBNAME='nephilim'
DBUSER='nephilim'
DBPASSWORD='nephilim'
DBHOST='localhost'

START=''

if [ $# -gt 0 ]; then
    START=`basename $1`
fi

GO=false
if [ $START == '' ]; then GO=true; fi

for f in `ls ../sql/*`; do
    if [ $GO ]; then
        `mysql ${DBNAME} -u${DBUSER} -h${DBHOST} -p${DBPASSWORD} < ../sql/${f}`
    elif [ $f == $START ]; then
        GO=true
    fi
done
