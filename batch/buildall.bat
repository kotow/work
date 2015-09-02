@echo off
php symfony propel-build-model
php symfony propel-build-sql
php symfony clear-cache
mkdir cache\objcache
mkdir cache\listscache
php symfony generate-cache shema
if "%1" == "" goto end
if "%1" == "insert" goto insert
goto end
:insert
echo "================== Inserting new data ======================"
php symfony propel-insert-sql
php symfony propel-load-data backend append
php batch\run_init_data.php
:end
echo "============================================================"
php symfony generate-cache
php symfony build-backend
php symfony build-forms
php symfony compile-locales
php symfony compile-rights
echo "Done!"