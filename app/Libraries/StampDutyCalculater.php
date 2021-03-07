<?php
namespace App\Libraries;


class StampDutyCalculater {

	public static function Calculate($stamp_duty_condition, $value, $isMain){
		$percent_key = $isMain ? 'percent_main' : 'percent_additional';
		// initialize table_row
		$range = '£'.$stamp_duty_condition['min'].(isset($stamp_duty_condition['max'])?' - £':' + ').$stamp_duty_condition['max'];
		$percent = ($stamp_duty_condition[$percent_key]*100)."%";

		$table_row = array(
			"range" => $range,
			"percent" => $percent,
			"value" => 0,
			"stamp_duty" => 0
		);

		// property value is less than min
		if($value <= $stamp_duty_condition['min']){

			$table_row['value'] = 0;
			$table_row['stamp_duty'] = 0;

		// property value is greater than min and less than max or max is undefined 
		}else if($value > $stamp_duty_condition['min'] && ($value <= $stamp_duty_condition['max'] || $stamp_duty_condition['max'] === NULL) ){
			$target_value = $value - $stamp_duty_condition['min'];
			$table_row['value'] = $target_value;
			$table_row['stamp_duty'] = $target_value * $stamp_duty_condition[$percent_key];
		// property value is greater than max
		}else{
			$target_value = $stamp_duty_condition['max'] - $stamp_duty_condition['min'];
			$table_row['value'] = $target_value;
			$table_row['stamp_duty'] = $target_value * $stamp_duty_condition[$percent_key];
		}

	return $table_row;
	}
}
