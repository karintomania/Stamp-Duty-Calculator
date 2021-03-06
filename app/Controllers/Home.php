<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data['tax_table'] = "table";
		return view('calculater', $data);
	}
}
