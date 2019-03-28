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

/**
 * 数字转换为A、B...AZ
 * @param $n
 * @param $key_array
 * @return string
 */
function num_to_excel_column($n, $key_array) {
    $str = "";
    while ($n > 0) {
        $yu = $n % 26;
        $n = intval($n / 26);
        if ($yu == 0) {
            $str = $str . $key_array[25];
            $n--;
        } else {
            $str = $str . $key_array[$yu - 1];
        }
    }
    return strrev($str);
}

/**
 * excel表导出
 * @param $head
 * @param $fields
 * @param $data
 * @param $name
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
 * @throws PHPExcel_Writer_Exception
 */
function export_excel($head, $fields, $data, $name)
{
    require_once LIBPATH."php_excel/lib/Classes/PHPExcel.php";

    $key_array = array();

    for ($i = 0; $i < 26; $i++) {

        $key_array[] = chr($i + 65);
    }

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->setActiveSheetIndex(0);

    $objActSheet = $objPHPExcel->getActiveSheet();

    $objActSheet->setTitle($name);

    $objDrawing = new PHPExcel_Worksheet_Drawing();

    foreach ($head as $key => $value) {

        $column = num_to_excel_column($key + 1, $key_array);

        $objActSheet->setCellValueExplicit($column . 1, $value, PHPExcel_Cell_DataType::TYPE_STRING);
    }

    foreach ($data as $k => $obj) {

        $num = $k + 2;

        $j = 1;

        foreach ($fields as $field) {

            $column = num_to_excel_column($j, $key_array);

            $objActSheet->setCellValueExplicit($column . $num, $obj[$field], PHPExcel_Cell_DataType::TYPE_STRING);

            $j++;
        }
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    header('Content-Type: application/vnd.ms-excel');

    header('Content-Disposition: attachment;filename="' . $name . '.xlsx"');

    header('Cache-Control: max-age=0');

    $objWriter->save('php://output');
}






