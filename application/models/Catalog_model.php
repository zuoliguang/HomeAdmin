<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:51:08
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-23 11:15:20
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_model extends Base_Model
{
	function __construct()
	{
		parent::__construct();

		$this->tableName = "catalog";

		$this->load->helper('html');
	}

	/**
	 * 获取菜单信息源数据
	 * @author zuoliguang 2018-08-23
	 * @return [type] [description]
	 */
	public function getAllCatalogs()
	{
		$fields = "id, pid, title, icon, url";

		$where = ["is_del" => 0];

		$this->bd_admin->select($fields);

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where($where);

		return $this->bd_admin->get()->result_array();
	}

	/**
	 * 获取菜单树 两级菜单
	 * @author zuoliguang 2018-08-22
	 * @return [type] [description]
	 */
	public function getTreeList()
	{
		$data = $this->getAllCatalogs();

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

	/**
	 * 两级菜单
	 * 获取页面支持前端json格式的菜单树
	 * @author zuoliguang 2018-08-23
	 * @return [type] [description]
	 */
	public function getLayuiTree()
	{
		$data = $this->getAllCatalogs();

		$kvd = [];

		foreach ($data as $item) {

			$kvd[$item["id"]] = $item;
		}

		$treeList = [];

		foreach ($data as $catalog) {
			
			if (intval($catalog["pid"])==0) {
				
				$treeList[$catalog["id"]]["id"] = $catalog["id"];
				
				$treeList[$catalog["id"]]["name"] = $catalog["title"];

			} else {

				if (isset($treeList[$catalog["pid"]])) {

					$treeList[$catalog["pid"]]["children"][] = [ 

						"id" => $catalog["id"],

						"name"=>$catalog["title"] 
					];
				}
			}
		}

		return $treeList;
	}
}