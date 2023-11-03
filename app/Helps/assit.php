<?php

// =====================================================================================================================
// use项目

// =====================================================================================================================
// 项目基础方法

if (!function_exists("handle_response")) {
    function handle_response($data = array(), $message = "", $code = 200)
    {
        return response()->json(compact("data", "message"), $code);
    }
}

if (!function_exists("obj_to_array")) {
    function obj_to_array($obj)
    {
        if (is_array($obj)) {
            return $obj;
        }
        return is_null($obj) ? [] : $obj->toArray();
    }
}

if (!function_exists("curlGet")) {
    function curlGet($url, $data)
    {
        if (empty($url) || empty($data)) {
            return false;
        }

        $url = $url . "?" . http_build_query($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 返回内容不输出到页面
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $output = curl_exec($curl);

        // Log::info(curl_error($curl));
//        dd(curl_error($curl));

        if (!$output) {
            return false;
        }
        curl_close($curl);


        return json_decode($output, true);
    }
}

if (!function_exists("is_right_data")) {
    function is_right_data($data, $key)
    {
        // 定义了数据且数据为 真, true, 0, "0"
        $result = false;
        if (isset($data[$key])) {
            if (is_numeric($data[$key])) {
                $result = true;
            } elseif (is_bool($data[$key])) {
                $result = true;
            } else {
                if ($data[$key]) {
                    $result = true;
                }
            }
        }
        return $result;
    }
}

if (!function_exists("is_wrong_data")) {
    function is_wrong_data($data, $key)
    {
        // 没有定义了数据
        // 数据定义了但数据为 null
        // 数据定义了但数据为 ""
        // 数据定义了但数据为 []空数组
        $result = false;
        if (!isset($data[$key])) {
            $result = true;
        }
        if (isset($data[$key])) {
            if (is_null($data[$key])) {
                $result = true;
            } elseif (is_numeric($data[$key])) {
                $result = false;
            } elseif (is_bool($data[$key])) {
                $result = false;
            } else {
                if (!$data[$key]) {
                    $result = true;
                }
            }
        }

        return $result;
    }
}


// =====================================================================================================================

if (!function_exists("adminUrl")) {
    function adminUrl($path)
    {
        $path = "/" . config('admin.route.prefix') . "/" . $path;

        return url($path);
    }
}