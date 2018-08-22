<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:51:08
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-22 14:22:08
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_model extends Base_Model
{
	function __construct()
	{
		parent::__construct();

		$this->tableName = "catalog";
	}

	/**
	 * 获取菜单树
	 * @author zuoliguang 2018-08-22
	 * @return [type] [description]
	 */
	public function getTreeList()
	{
		$fields = "id, pid, title, icon, url";

		$where = ["is_del" => 0];

		$this->bd_admin->select($fields);

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where($where);

		$data = $this->bd_admin->get()->result_array();

		$kvd = [];

		foreach ($data as $item) {

			$kvd[$item["id"]] = $item;
		}

		$treeList = [];

		foreach ($data as $catalog) {
			
			if (intval($catalog["pid"])==0) {
				
				$treeList[$catalog["id"]] = $catalog;

			} else {

				if (isset($treeList[$catalog["pid"]])) {

					$treeList[$catalog["pid"]]["items"][] = $catalog;
				}
			}
		}

		return $treeList;
	}
}