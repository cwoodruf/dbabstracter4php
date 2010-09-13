<?php
class Admin extends Controller {
	const IMPORTURL = 'https://lifelinevm.net/lifeline/admin.php?action=export&vid=1036';
	const DEFPERMS = 'edit';

	public function __construct() {
		parent::__construct(__CLASS__);
	}
	public function execute($actions) {
		parent::execute($actions);
		switch ($actions[0]) {
		case 'import': 
			$this->importAdmins(); 
		break;
		}
		View::display('admin');
	}
	public function importAdmins() {
		global $ldata;
		if ($ldata['perms'] == 'superuser') {
			$url = self::IMPORTURL."&login={$ldata['login']}&hash=".urlencode($ldata['hash']);

			$curl = curl_init($url);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			$result = curl_exec($curl);
			curl_close($curl);

			$exported = unserialize(base64_decode($result));
			if (is_array($exported)) {
				$a = new Admins;
				foreach ($exported as $login => $md5) {
					$import = array(  
							'login' => $login, 
							'password' => encode_password($md5,'md5'),
							'created' => date('Y-m-d H:i:s'),
							'perms' => self::DEFPERMS,
						);
					$a->ins($import);
					if ($a->err()) {
						View::assign('errors',$a->err());
					}
				}
			} else {
				View::assign('errors','No import data found from lifeline.');
			}
		} else {
			View::assign('errors','You do not have sufficient permissions to import admins.');
		}
	}
}

