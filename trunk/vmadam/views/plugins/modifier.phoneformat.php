<?php
/**
 * mangle 10 digit phone numbers
 */
function smarty_modifier_phoneformat($phone) {
	$phone = preg_replace('#\D#', '', $phone);
	if (preg_match('#(\d{3})(\d{3})(\d{4})#',$phone,$m)) {
		return sprintf("(%s) %s-%s", $m[1], $m[2], $m[3]);
	} 
	return $phone;
}
		
