<?php

namespace Tests\Support\Libraries;

use App\Libraries\StampDutyCalculater;

class StampDutyCalculaterTest extends \CodeIgniter\Test\CIUnitTestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function testFormatNumAdd()
	{
		$result = StampDutyCalculater::formatNum(1000000.01);
		$expected = "1,000,000.01";


		$this->assertEquals($expected, $result);
	}

	public function testCalculateValueLessThanMin()
	{
		$stamp_duty_condition = array(
			"min" => 500000,
			"max" => 925000,
			"percent_main" => 0.05,
			"percent_additional" => 0.08
		);

		$value = 250000;
		$isMain = true;
		$result = StampDutyCalculater::Calculate($stamp_duty_condition, $value, $isMain);
		$expected = array(
			"range" => "£500,000 - £925,000",
			"percent" => "5%",
			"value" => 0,
			"stamp_duty" => 0
		);

		$this->assertEquals($expected['range'], $result['range']);
		$this->assertEquals($expected['percent'], $result['percent']);
		$this->assertEquals($expected['value'], $result['value']);
		$this->assertEquals($expected['stamp_duty'], $result['stamp_duty']);

	}


	public function testCalculateValueGreaterThanMinAndLessThanMax()
	{
		$stamp_duty_condition = array(
			"min" => 500000,
			"max" => 925000,
			"percent_main" => 0.05,
			"percent_additional" => 0.08
		);

		$value = 700000;
		$isMain = true;
		$result = StampDutyCalculater::Calculate($stamp_duty_condition, $value, $isMain);
		$expected = array(
			"range" => "£500,000 - £925,000",
			"percent" => "5%",
			"value" => "200,000",
			"stamp_duty" => "10,000"
		);

		$this->assertEquals($expected['range'], $result['range']);
		$this->assertEquals($expected['percent'], $result['percent']);
		$this->assertEquals($expected['value'], $result['value']);
		$this->assertEquals($expected['stamp_duty'], $result['stamp_duty']);

	}

	public function testCalculateValueGreaterThanMinAndMaxUndefined()
	{
		$stamp_duty_condition = array(
			"min" => 1500000,
			"max" => NULL,
			"percent_main" => 0.12,
			"percent_additional" => 0.15
		);

		$value = 2000000;
		$isMain = true;
		$result = StampDutyCalculater::Calculate($stamp_duty_condition, $value, $isMain);
		$expected = array(
			"range" => "£1,500,000 + ",
			"percent" => "12%",
			"value" => "500,000",
			"stamp_duty" => "60,000"
		);

		$this->assertEquals($expected['range'], $result['range']);
		$this->assertEquals($expected['percent'], $result['percent']);
		$this->assertEquals($expected['value'], $result['value']);
		$this->assertEquals($expected['stamp_duty'], $result['stamp_duty']);

	}

	public function testCalculateValueGreaterThanMax()
	{
		$stamp_duty_condition = array(
			"min" => 925000,
			"max" => 1500000,
			"percent_main" => 0.10,
			"percent_additional" => 0.13
		);

		$value = 2000000;
		$isMain = true;
		$result = StampDutyCalculater::Calculate($stamp_duty_condition, $value, $isMain);
		$expected = array(
			"range" => "£925,000 - £1,500,000",
			"percent" => "10%",
			"value" => "575,000",
			"stamp_duty" => "57,500"
		);

		$this->assertEquals($expected['range'], $result['range']);
		$this->assertEquals($expected['percent'], $result['percent']);
		$this->assertEquals($expected['value'], $result['value']);
		$this->assertEquals($expected['stamp_duty'], $result['stamp_duty']);

	}

	public function testCalculateAdditional()
	{
		$stamp_duty_condition = array(
			"min" => 500000,
			"max" => 925000,
			"percent_main" => 0.05,
			"percent_additional" => 0.08
		);

		$value = 550000;
		$isMain = false;
		$result = StampDutyCalculater::Calculate($stamp_duty_condition, $value, $isMain);
		$expected = array(
			"range" => "£500,000 - £925,000",
			"percent" => "8%",
			"value" => "50,000",
			"stamp_duty" => "4,000"
		);

		$this->assertEquals($expected['range'], $result['range']);
		$this->assertEquals($expected['percent'], $result['percent']);
		$this->assertEquals($expected['value'], $result['value']);
		$this->assertEquals($expected['stamp_duty'], $result['stamp_duty']);

	}

}