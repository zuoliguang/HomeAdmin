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

/**
 * curl调用
 * @param  [type] $file_path [description]
 * @return [type]            [description]
 */
function curl_request($url, $post = null, $header = null)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    if ($post) {

        if (is_array($post)) {

            $post = http_build_query($post);
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        curl_setopt($ch, CURLOPT_POST, 1);

    } else {

        $post = "";

        curl_setopt($ch, CURLOPT_POST, 0);
    }

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");

    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

    if ($header) {

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    } else {

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($post)));
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_TIMEOUT,180);

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}








