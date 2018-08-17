<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:54:58
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-17 16:08:13
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function ajaxJson($state=0, $message="", $data=[])
	{
		echo json_encode(["state"=>$state, "message"=>$message, "data"=>$data]);
		exit();
	}
}