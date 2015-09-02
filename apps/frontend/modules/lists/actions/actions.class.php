<?php
/**
 * @package    cms
 * @subpackage lists
 * @author     Jordan Hristov / Ilya Popivanov
 */

class listsActions extends listsCoreActions
{

	public function executeAdd()
	{
		$str = strtotime("2014-05-12 +3months");
		echo date("Y-m-d", $str);
		exit('');
		exit('no');
		$is = new ImportSession();
		$is->setLabel('Импорт сесия 21.04.2014');
		$is->setImportId(403);
		$is->setStartId(163);
		$is->setTmCount(79);
		$is->save();

		$is2 = new ImportSession();
		$is2->setLabel('Импорт сесия 01.05.2014');
		$is2->setImportId(404);
		$is2->setStartId(242);
		$is2->setTmCount(89);
		$is2->save();

		exit('done');
	}

}