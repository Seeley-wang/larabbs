<?php

function route_class()
{	
	// 将当前请求的路由名称转化为css类名
	return str_replace('.', '-', Route::currentRouteName());
}