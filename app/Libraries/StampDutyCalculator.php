<?php
namespace App\Libraries;


class StampDutyCalculator {

	public static function calculate($stamp_duty_condition, $value, $isMain){
		$percent_key = $isMain ? 'percent_main' : 'percent_additional';
		// initialize table_row
		$percent = ($stamp_duty_condition[$percent_key]*100)."%";

		$table_row = array(
			"range" => $stamp_duty_condition['range_label'],
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
			$stamp_duty = $target_value * $stamp_duty_condition[$percent_key];
			$table_row['value'] = StampDutyCalculator::formatNum($target_value);
			$table_row['stamp_duty'] = StampDutyCalculator::formatNum($stamp_duty);
		// property value is greater than max
		}else{
			$target_value = $stamp_duty_condition['max'] - $stamp_duty_condition['min'];
			$stamp_duty = $target_value * $stamp_duty_condition[$percent_key];
			$table_row['value'] = StampDutyCalculator::formatNum($target_value);
			$table_row['stamp_duty'] = StampDutyCalculator::formatNum($stamp_duty);
		}

	return $table_row;
	}

	public static function formatNum($num, $precision = 2) {
		return number_format(floor($num)) . substr(str_replace(floor($num), '', $num), 0, $precision + 1);
	}

	public static function calculateTotal($table_data) {
		$total = 0;
		foreach($table_data as $table_row){
			$stamp_duty = str_replace(',', '', $table_row['stamp_duty']);
			$total += $stamp_duty;
		}

		$total_row = array("stamp_duty" => StampDutyCalculator::formatNum($total));

		return $total_row;
	}
}
