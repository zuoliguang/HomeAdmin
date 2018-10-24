<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:51:08
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-09-22 17:25:24
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Friendships_model extends Base_Model
{
	function __construct()
	{
		parent::__construct();

		$this->database = $this->bd_blog;

		$this->tableName = "friendships";
	}

}