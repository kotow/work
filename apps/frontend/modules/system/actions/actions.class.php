<?php
/**
 * @package    cms
 * @subpackage system
 * @author     Jordan Hristov / Ilya Popivanov
 */

class systemActions extends systemCoreActions
{
	public function executeExport()
	{
		//ini_set("display_errors", 1);
		$this->setLayout(false);
		header("Content-type: text/html; charset=utf-8");
		require_once(SF_ROOT_DIR."/lib/symfony/pdf/dompdf_config.inc.php");
		$this->getRequest()->setParameter("SearchMatch_id", $this->getRequestParameter("id"));
		$html = $this->getPresentationFor("search","details2");
		$html = str_replace("&nbsp;"," ", $html);


		$html = utf8_encode($html);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		//$dompdf->stream("Export.pdf");


		//$dompdf = new DOMPDF();
		//$dompdf->load_html($html);
		//$dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
		//$dompdf->render();

		$dompdf->stream("dompdf_out.pdf", array("Attachment" => true));

		exit();
	}
}