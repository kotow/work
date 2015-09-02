@echo off
echo "--> UPDATING PROJECT ... "
xcopy ..\..\cms ..\ /e/h/s/q/EXCLUDE:exclude.txt
echo "--> REMOVING SVN DIRECTORIES ... "
php deleteall.php -arv ..\ ".svn"
echo "--> DONE"