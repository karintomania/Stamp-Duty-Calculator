<?php

namespace App\Controllers;

use App\Libraries\StampDutyCalculater;

class StampDutyController extends BaseController
{

	public function get()
	{
		$data['table'] = array();
		$data['value'] = 0;
		$data['isMain'] = 1;

		return view('calculater', $data);
	}


	public function post()
	{

		$isValidatedRequest = $this->validateRequest();
		if($isValidatedRequest){
			$value = $this->request->getPost("value");
			$isMain = ($this->request->getPost("type") == 1);

			$table_data = $this->calculateStampDuty(STAMP_DUTY_CONDITIONS, $value, $isMain);
			$data['table'] = $table_data;
			$data['value'] = $value;
			$data['isMain'] = $isMain;
		}else{
			$data['validation'] = $this->validator;
			$data['table'] = array();
			$data['value'] = 0;
			$data['isMain'] = 1;
		}

		return view('calculater', $data);
	}


	private function validateRequest(){
		$rules =  array(
			'value' => ['label' => 'Property Value', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
			'type' => ['label' => 'Property Type', 'rules' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1]'],
		);

		return $this->validate($rules);
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
