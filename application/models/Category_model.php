<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-27 13:53:27
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-27 14:58:49
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends Base_Model
{
	
	function __construct()
	{
		parent::__construct();

		$this->database = $this->bd_blog;

		$this->tableName = "category";
	}

	
}