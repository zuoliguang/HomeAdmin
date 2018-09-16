<?php

/**
 * Upload 文件上传处理
 * @Author: zuoliguang
 * @Date:   2018-08-23 08:54:52
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-09-16 21:05:38
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends Base_Controller {

	public $upload_config;

	function __construct()
	{
		parent::__construct();

        $this->upload_config['allowed_types'] = 'gif|jpg|png'; // 允许上的文件 MIME 类型

        $this->upload_config['max_size'] = 1024 * 50; // 允许上传文件大小的最大值（单位 KB），设置为 0 表示无限制

        $this->upload_config['max_width'] = 1024 * 5; // 图片的最大宽度（单位为像素），设置为 0 表示无限制

        $this->upload_config['max_height'] = 1024 * 5; // 图片的最大高度（单位为像素），设置为 0 表示无限制
	}

	/**
	 * layui富文本图片上传
	 * @param  string $target_index 上传的角标名称
	 * @return [type]               [description]
	 */
	public function uploadEditorImage($target_index="file")
	{
		$save_path = FCPATH.'upload/image/'.date('Y-m-d');

		make_dir($save_path);

		$this->upload_config['upload_path'] = $save_path;

		$this->upload_config['file_name'] = date('Y-m-d').'-'.$this->timestemp;

		$this->load->library('upload', $this->upload_config);

		$src = $_SERVER['HTTP_ORIGIN']."/upload/image/".date('Y-m-d');

		// 上传结果操作
		$result = [];

		if (!$this->upload->do_upload($target_index)) {

			$result = [
				'code' => -1,

				'msg' => $this->upload->display_errors(),

				'data' => []
			];

		} else {

			$upload_file_data = $this->upload->data();

			$file_name = $upload_file_data['file_name'];

			$src .= "/".$file_name;

			$image_info = getimagesize($src);

			$width = $image_info[0];

			$height = $image_info[1];

			$result = [
				'code' => 0,

				'msg' => 'ok',

				'data' => [

					'src' => $src,

					'width' => $width,

					'height' => $height,

					'title' => 'HOMEADMIN图片'
				]
			];
		}

		echo json_encode($result);
	}

}