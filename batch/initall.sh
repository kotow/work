echo "=================================================> COPYING PROJECT ... "
if find /home/cms -maxdepth 0 -type d
then
    cp -r /home/cms/* ./
fi

echo "=================================================> DONE"
echo "=================================================> REMOVING SVN DIRECTORIES ... "
find ./ -type d -name ".svn" | while read -r; do rm -rf "$REPLY"; done
echo "=================================================> DONE"

echo "=================================================> REMOVING LOG, OM AND MAP ... "
rm -rf lib/model/om/*
rm -rf lib/model/map/*
rm -rf log/*
echo "=================================================> DONE"

echo "=================================================> REMOVING UPLOADED MEDIA ... "
find www/media -type f | while read -r; do rm "$REPLY"; done
echo "=================================================> DONE"

echo "=================================================> REMOVING CACHE ... "
find cache -type f | while read -r; do rm "$REPLY"; done
echo "=================================================> DONE"

echo "=================================================> REMOVING OBJECT CACHE DIRECTORIES ... "
find cache/objcache -type d | while read -r; do rm -rf "$REPLY"; done
mkdir cache/objcache
echo "=================================================> DONE"
echo "=================================================> CONFIGURING"
if [ "$3" == "" ]
then
	echo "=================== EMPTY PASS ==============================="
	php batch/configure.php $1 $2 "" $4 $5
else
	php batch/configure.php $1 $2 $3 $4 $5
fi
echo "=================================================> DONE"
echo "=================================================> BUILDING DOCUMENT MODELS"
bash batch/buildall.sh insert
echo "=================================================> DONE"
