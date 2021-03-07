<?php

namespace App\Controllers;

use App\Libraries\StampDutyCalculator;

class StampDutyController extends BaseController
{

	public function get()
	{
		$value = NULL;
		$isMain = 1;
		$data['table'] = $this->calculateStampDuty(STAMP_DUTY_CONDITIONS, $value, $isMain);;
		$data['value'] = $value;
		$data['isMain'] = $isMain;

		return view('calculator', $data);
	}


	public function post()
	{

		$isValidatedRequest = $this->validateRequest();
		if($isValidatedRequest){
			$value = $this->request->getPost("value");
			$isMain = ($this->request->getPost("type") == 1);

		}else{
			// set the result of validation
			$data['validation'] = $this->validator;
			$value = 0;
			$isMain = 1;

		}

			$data['table'] = $this->calculateStampDuty(STAMP_DUTY_CONDITIONS, $value, $isMain);;
			$data['value'] = $value;
			$data['isMain'] = $isMain;

		return view('calculator', $data);
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

		// calculate each rows of stamp duty conditions
		foreach($stamp_duty_conditions as $stamp_duty_condition){
			$table_row = StampDutyCalculator::calculate($stamp_duty_condition, $value, $isMain);
			array_push($table_data, $table_row);
		}

		// add total row at the bottom of the table
		$total_row = StampDutyCalculator::calculateTotal($table_data);
		array_push($table_data, $total_row);
		
		return $table_data;
	}

}
