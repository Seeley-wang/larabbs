<?php

function route_class()
{
    // 将当前请求的路由名称转化为css类名
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));

    return str_limit($excerpt, $length);
}