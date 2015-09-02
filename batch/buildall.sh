php symfony propel-build-model
php symfony propel-build-sql
mkdir cache/objcache
mkdir cache/listscache
chmod -R 777 cache
chmod -R 777 log
chmod -R 777 www/media/upload
php symfony clear-cache
php symfony generate-cache rel
if [ "$1" == "insert" ]
then
	echo "=================== INSERT DATA ==============================="
	php symfony propel-insert-sql
	php symfony propel-load-data backend append
	php symfony tr
	php symfony ur
	php batch/run_init_data.php $2
fi
echo "========================================================"
php symfony generate-cache
php symfony build-backend
php symfony build-forms
php symfony compile-locales
php symfony compile-rights
echo "Done!"
