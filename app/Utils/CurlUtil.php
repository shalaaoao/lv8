<?php

namespace App\Utils;

class CurlUtil
{
    public static $timeOut = 30;

    public static function get_data_from_url($url, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);        //设置url
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   //设置开启重定向支持
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeOut); //最大超时30s
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

        if (!empty($headers)) {
            $tHeaders = [];
            foreach ($headers as $k => $v) {
                $tHeaders[] = $k . ":" . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $tHeaders);
        }
        $output = curl_exec($ch);  //执行
        curl_close($ch);
        return $output;
    }

    /**
     * post请求
     * @param $url
     * @param array $data
     * @param array $headers
     * @param array $is_json
     * @return mixed
     */
    public static function post_data_from_url($url, $data = [], $headers = [], $is_json = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);        //设置url
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   //设置开启重定向支持
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //最大超时30s
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_POST, 1);

        if ($headers) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $tHeaders = [];
            foreach ($headers as $k => $v) {
                $tHeaders[] = $k . ":" . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $tHeaders);
        } else {
            if ($is_json) {
                $tHeaders = ['Content-Type:application/json'];

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $tHeaders);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }

        $output = curl_exec($ch);  //执行
        curl_close($ch);
        return $output;
    }

    public static function put_data_from_url($url, $data = [], $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);        //设置url
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   //设置开启重定向支持
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //最大超时30s
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        if (!empty($headers)) {
            $tHeaders = [];
            foreach ($headers as $k => $v) {
                $tHeaders[] = $k . ":" . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $tHeaders);
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        $output = curl_exec($ch);  //执行
        curl_close($ch);
        return $output;
    }

    public static function delete_data_from_url($url, $data = [], $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);        //设置url
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   //设置开启重定向支持
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //最大超时30s
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        if (!empty($headers)) {
            $tHeaders = [];
            foreach ($headers as $k => $v) {
                $tHeaders[] = $k . ":" . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $tHeaders);
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $output = curl_exec($ch);  //执行
        curl_close($ch);
        return $output;
    }

    public static function rawHttpRequst($url, $host)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Host: " . $host]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_TIMEOUT, 58);
        // curl_setopt($ch, CURLOPT_VERBOSE, true);
        $result = curl_exec($ch);
        return $result;
    }

    public static function rawHttpPostRequest($url, $host, $data = [], $headers = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Host: " . $host]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_TIMEOUT, 58);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if (!empty($headers)) {
            $tHeaders = [];
            foreach ($headers as $k => $v) {
                $tHeaders[] = $k . ":" . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $tHeaders);
        }

        // curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        return $result;
    }

    public static function head_data_from_url($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, false);

        $output = curl_exec($ch);
        curl_close($ch);
        if ($output) {
            $output = explode("\r\n", $output);
        }
        return $output;
    }

    public static function sendPost($url, $data = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);        //设置url
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   //设置开启重定向支持
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //最大超时30s
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        $output = curl_exec($ch);  //执行
        curl_close($ch);
        return json_decode($output, true);
    }

    public static function sendGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);        //设置url
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   //设置开启重定向支持
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //最大超时30s
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

        $output = curl_exec($ch);  //执行
        curl_close($ch);
        return json_decode($output, true);
    }

    /**
     * @param  string $url
     * @param  array $datas HTTP POST BODY
     * @param  array $param HTTP URL
     * @param  array $headers HTTP header
     * @return array
     */
    public static function multi_post($url, $datas=array(), $params=array(), $headers=array()){
//        $url = $this->buildUrl($url, $params);

        $chs = array();
        $result = array();
        $mh = curl_multi_init();
        foreach($datas as $data){
            $ch = curl_init();
            $chs[] = $ch;
//            $this->prepare($ch);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? http_build_query($data) : $data);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 60000);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 60000);
            curl_multi_add_handle($mh, $ch);
        }

        $running = null;
        do{
            curl_multi_exec($mh, $running);
            usleep(100);
        }while($running);

        foreach($chs as $ch){
            $content = curl_multi_getcontent($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $result[] = array(
                'code' => $code,
                'content' => $content,
            );
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        return $result;
    }
}
