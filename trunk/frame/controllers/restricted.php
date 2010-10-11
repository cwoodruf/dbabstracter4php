<?php
/**
 * example of a page or set of pages that require login
 */
class Restricted extends Controller {
	public function execute() {

		# $ldata has the user record
		# you can use this info to fine tune the response logic
		# in this case we accept any valid login, if not we display the login form

		if ($ldata = Login::check()) {
			$id = $_REQUEST['numbered_id'];
			$n = new Numbered;

			switch($this->actions[1]) {
			case 'save':
				if (!$id) {
					$_REQUEST['email'] = $ldata['login'];
					$n->ins($_REQUEST);
					$id = $n->getid();
				} else {
					$n->upd($id,$_REQUEST);
				}
				if (!$n->err()) {
					View::assign('topmsg',"saved $id");
					Entity::setpageidhowmany('numbered');
				}
				break;
			case 'confirmdelete':
				$this->flag('note_to_delete',$id);
				View::assign('confirm',"Really delete note?");
				View::assign('action','delete');
				View::display("confirm.tpl");
				return;
			case 'delete':
				$id = $this->delflag('note_to_delete');
				$n->del($id);
				Entity::setpageidhowmany('numbered');
				View::assign('confirm',"Note $id deleted!");
				View::display("confirm.tpl");
				return;
			default:
				$this->input['created'] = date('Y-m-d H:i:s');
			}
			if ($id) $this->input = $n->getone($id);
			View::assign('schema',$n->schema);
			View::display('restricted.tpl');

		} else {
			View::display('login.tpl');
		}
	}
}

