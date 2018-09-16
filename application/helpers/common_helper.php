<?php

/**
 * 公共函数库
 * @Author: zuoliguang
 * @Date:   2018-08-20 08:43:55
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-09-16 14:02:57
 */

/**
 * 创建文件夹
 * @param  [type] $file_path [description]
 * @return [type]            [description]
 */
function make_dir($file_path)
{
    if (!is_dir($file_path)) {

    	return mkdir($file_path, 0777, true);
    }

    return true;
}