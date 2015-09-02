echo "=================================================> COPYING PROJECT ... "
xcopy ..\cms . /e/h/s/q
echo "=================================================> DONE"
echo "=================================================> REMOVING SVN DIRECTORIES ... "
php batch\deleteall.php -arv . ".svn"
echo "=================================================> DONE"

echo "=================================================> REMOVING LOG, OM AND MAP ... "
php batch\deleteall.php -arv lib\model\om
php batch\deleteall.php -arv lib\model\map
php batch\deleteall.php -arv log
echo "=================================================> DONE"

echo "=================================================> REMOVING UPLOADED MEDIA ... "
php batch\deleteall.php -frv www\media
echo "=================================================> DONE"

echo "=================================================> REMOVING CACHE ... "
php batch\deleteall.php -frv cache
echo "=================================================> DONE"

echo "=================================================> REMOVING OBJECT CACHE DIRECTORIES ... "
php batch\deleteall.php -drv cache\objcache
echo "=================================================> DONE"
echo "=================================================> CONFIGURING"
php batch\configure.php %1 %2 %3 %4 %5
echo "=================================================> DONE"
echo "=================================================> BUILDING DOCUMENT MODELS"
call batch\buildall.bat insert
echo "=================================================> DONE"