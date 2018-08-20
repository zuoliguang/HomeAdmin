<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:59:41
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-20 14:09:44
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Model extends CI_Model
{
	public $timestemp;
	
	public $microtimestemp;

	function __construct()
	{
		parent::__construct();

		$this->timestemp = time();

		$this->microtimestemp = microtime();

		$this->bd_admin = $this->load->database('homeadmin', true);
	}
}