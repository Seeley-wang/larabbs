<?php
/**
 * Created by PhpStorm.
 * User: Clown
 * Date: 18/7/12
 * Time: 上午12:39
 */

namespace App\Handlers;


use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    /**
     * @param $text
     * @return string
     */
    public function translate($text)
    {

        $http = new Client();
        // 初始化配置信息
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        $sign = md5($appid . $text . $salt . $key);

        $query = http_build_query([
            "q" => $text,
            "from" => "zh",
            "to" => "en",
            "appid" => $appid,
            "salt" => $salt,
            "sign" => $sign
        ]);
        $response = $http->get($api . $query);
        $result = json_decode($response->getBody(), true);
        // 尝试获取获取翻译结果
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst']);
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return $this->pinyin($text);
        }

    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}