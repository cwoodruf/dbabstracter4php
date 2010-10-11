<?php
/**
 * tools for showing different types of calendars
 */
class Calendar {
	public static $calendar;
	public static $first;
	public static $firstepoch;
	public static $nextdate;
	public static $prevdate;
	public static $startdate;
	public static $startepoch;

	public static function showmonth() {
		self::$calendar = 'month';
		self::setdates();
		View::assign('weeks', range(0,5));
		# TODO need a better way to generate the days of the week based on locale
		foreach (array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') as $d) {
			$days[++$dow] = $d;
		}
		View::assign('days', $days);
		View::assign('calendar',self::$calendar);
		View::display("calendar.tpl");
	}

	public static function setdates() {
		self::$startdate = self::startdate();
		self::$first = preg_replace('#-\d+$#','-01',self::$startdate);
		self::$firstepoch = strtotime(self::$first);
		self::$startepoch = strtotime(self::$startdate);
		self::$prevdate = date('Y-m-d',strtotime(self::$startdate." - 1 month"));
		self::$nextdate = date('Y-m-d',strtotime(self::$startdate." + 1 month"));
		View::assign('prevdate',self::$prevdate);
		View::assign('nextdate',self::$nextdate);
		View::assign('startday',date('j',self::$startepoch));
		View::assign('startdate',self::$startdate);
		View::assign('eom', ($eom = date('t',self::$startepoch)));
		View::assign('enddate', preg_replace('#-\d+$#',"-$eom",self::$startdate));
		View::assign('firstdow', date('N',self::$firstepoch));
		View::assign('mon', date('m',self::$startepoch));
		View::assign('month', date('F',self::$startepoch));
		View::assign('year', date('Y',self::$startepoch));
	}

	public static function startdate() {
		$date = $_REQUEST['startdate'];
		if (!Check::isdate($date)) {
			$date = sprintf(
				'%04d-%02d-%02d',
				$_REQUEST['Date_Year'],
				$_REQUEST['Date_Month'],
				$_REQUEST['Date_Day']
			);
		}
		if (!Check::isdate($date)) $date = date('Y-m-d');
		return $date;
	}
}

