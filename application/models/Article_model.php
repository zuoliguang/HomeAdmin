<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-27 13:53:27
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-09-15 20:52:11
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends Base_Model
{
	
	function __construct()
	{
		parent::__construct();

		$this->database = $this->bd_blog;

		$this->tableName = "article";
	}

	
}