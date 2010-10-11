<?php
/**
 * basic note display
 */
class Note extends Controller {
	public function execute() {
		if ($ldata = Login::check()) {
			$view = array(
				'email' => $ldata['login'],
				'numbered_id' => $_REQUEST['numbered_id'],
			);
			Run::me('Viewers','ins',$view);
		}
		View::assign('note',Run::cached('Numbered','getone',$_REQUEST['numbered_id']));
		View::display('note.tpl');
	}
}

