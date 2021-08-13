#!/bin/bash

while true
do
    cwd=$PWD
    if [ -d "$cwd/temphtml/" ]; then
        rm -r $cwd/temphtml/
        echo delete temphtml
    else
        echo temphtml doesnt exist
    fi

    mkdir temphtml

    if [[ "$1" == "michaels_urls.txt" ]]; then
        murls=$(<"$1")
        hurls=$(<"$2")
        else
        murls=$(<"$2")
        hurls=$(<"$1")
    fi


    IFS=$'\n'
    n=1
    for url in $hurls
    do 
        echo $url
        echo $n : $url
        curl ${url} -o "${cwd}/temphtml/h${n}h.html"
        n=$((n+1))

    done

    IFS=$'\n'
    n=1
    for url in $murls
    do
        echo $url
        echo $n : $url
        curl ${url} -o "${cwd}/temphtml/m${n}m.html"
        n=$((n+1))

    done

    #Get tagsoup if it doesn't exist in current directory
    tagsoup=`find -maxdepth 1 -name "tagsoup-1.2.1.jar"`
    if [[ $tagsoup != "./tagsoup-1.2.1.jar" ]]; then
        wget 'http://maven.org/maven2/org/ccil/cowan/tagsoup/tagsoup/1.2.1/tagsoup-1.2.1.jar'
    fi

    htmls=`find ${cwd}/temphtml -name "*.html"`

    #echo HTMLS: $htmls

    #replace html files with xhtml
    if [[ ! -z $htmls ]]; then
        java -jar tagsoup-1.2.1.jar --files $htmls
        for file in $htmls
        do
            rm $file
        done
    else
        echo there are no htmls
    fi

    xhtmls=`find ${cwd}/temphtml -name "*.xhtml"`

    lencwd=${#cwd}
    #lenwtemp is the length of cwd + /temphtml/
    lenwtemp=$(($lencwd+10))

    for xhtml in $xhtmls
    do
        cutlen=$((${#xhtml}-$lenwtemp)) #gets length of filename
        filename=`echo $xhtml | cut -c${lenwtemp}-$((${lenwtemp}+${cutlen}))` #cuts filename
        id=`echo $filename | egrep -o '[0-9]*'` #grabs id
        #echo $xhtml $id
        python3 parser.py $xhtml $id
    done

    rm -r $cwd/temphtml/

    printf "\n"
    echo "Sleep started, running again in 6 hours."
    sleep 21600

    printf "\n"
    echo "RUN AGAIN -- 6hr sleep"
done