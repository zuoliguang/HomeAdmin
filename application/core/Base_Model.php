<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:59:41
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-21 14:05:14
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Model extends CI_Model
{
	public $timestemp;
	
	public $microtimestemp;

	public $pageSize = 20;

	public $tableName;

	function __construct()
	{
		parent::__construct();

		$this->timestemp = time();

		$this->microtimestemp = microtime();

		$this->bd_admin = $this->load->database('homeadmin', true);
	}

	public function getAdminById($id)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("id", $id);

		return $this->bd_admin->get()->row_array();
	}

	public function update($data=[], $where=[])
	{
		$this->bd_admin->where($where);

		$this->bd_admin->update($this->tableName, $data);

		return $this->bd_admin->affected_rows();
	}

	public function all($fields="*", $where=[], $start=0, $size=0, $orderBy="id", $orderType="ASC")
	{
		$size = ($size==0) ? $this->pageSize : $size;

		$this->bd_admin->select($fields);

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where($where);

		$this->bd_admin->limit($size, $start);

		$this->bd_admin->order_by($orderBy, $orderType);

		return $this->bd_admin->get()->result_array();
	}


}