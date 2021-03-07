<?php

namespace App\Controllers;

use App\Libraries\StampDutyCalculater;

class StampDutyController extends BaseController
{
	public function index()
	{
		$data['tax_table'] = "table";
		$value = $this->request->getGet("value");
		$isMain = ($this->request->getGet("type") == 1);




		// $table_data = array();
		$table_data = $this->calculateStampDuty(STAMP_DUTY_CONDITIONS, $value, $isMain);

		$data['value'] = $value;
		$data['isMain'] = $isMain;
		$data['table'] = $table_data;

		return view('calculater', $data);
	}

	private function calculateStampDuty($stamp_duty_conditions, $value, $isMain){

		$table_data = array();

		foreach($stamp_duty_conditions as $stamp_duty_condition){
			$table_row = StampDutyCalculater::Calculate($stamp_duty_condition, $value, $isMain);
			array_push($table_data, $table_row);
		}

		return $table_data;
	}

}
