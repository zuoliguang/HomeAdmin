<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:51:08
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-21 16:49:19
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_model extends Base_Model
{
	function __construct()
	{
		parent::__construct();

		$this->tableName = "catalog";
	}

	public function getTreeList()
	{
		$fields = "pid, title, icon, url";

		$where = ["is_del" => 1];

		$this->bd_admin->select($fields);

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where($where);

		$data = $this->bd_admin->get()->result_array();

		echo json_encode($data);die();
	}
}