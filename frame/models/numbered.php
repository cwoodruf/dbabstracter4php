<?php
class Numbered extends NumberedEntity {
	public function __construct() {
		parent::__construct();
		# add any modifications to the schema in NumberedEntity here
		$this->schema['numbered_id']['alt'] = '#';
		$this->schema['email']['hide'] = true;
	}

	# get a chronologically grouped set of events relating to a login
	public function calendar($start,$action) {
		if (!preg_match('#^(\d\d\d\d)-(\d\d)-\d\d$#', $start, $m)) {
			if (!QUIET) die("bad date in Numbered::calendar: $start");
		}
		
		$rawevents = $this->getall(
			array(
				"where year(created) = %u and month(created) = %u ",
				$m[1], $m[2]
			)
		);
		if (!$rawevents) return array();
		foreach ($rawevents as $event) {
			$edate = preg_replace('# .*#','',$event['created']);
			$id = $event['numbered_id'];
			$event['_action_'] = $action;
			$event['_id_'] = 'numbered_id';
			$events[$edate][$id] = $event;
		}
		return $events;
	}
}

