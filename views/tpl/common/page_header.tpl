<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link type="text/css" rel="stylesheet" href="{$smarty.const.FULL_URL_TO_FW}/common_views/css/bootstrap.css"/>
    {*стили проекта. Принудительно подключаем CSS jquery_ui и считаем, что файл style.css
    в проекте обязательно есть
    если нужно переопределить стили Bootstrap, это можно сделать именно в style.css конкретного проекта
    *}
    <link type="text/css" rel="stylesheet" href="views/css/style.css"/>

    {*Общие яваскрипты - используются практически во всех проектах*}
{*
    <script type="text/javascript" src="{$smarty.const.FULL_URL_TO_FW}/common_views/js/jquery.js"></script>
*}
{*
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
*}
    <script type="text/javascript" src="{$smarty.const.FULL_URL_TO_FW}/common_views/js/jquery.js"></script>
    <script type="text/javascript" src="{$smarty.const.FULL_URL_TO_FW}/common_views/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="{$smarty.const.FULL_URL_TO_FW}/common_views/js/bootstrap.js"></script>

    {*Клиентские яваскрипты - массивом*}
    {if isset($js)}
        {foreach from=$js item=client_js}
        <script type="text/javascript" src="views/js/{$client_js}"></script>
        {foreachelse}
        {/foreach}

    {/if}

    {*Клиентские стили - кроме style.css, если есть конечно*}
    {if isset($css)}
        {foreach from=$css item=client_css}
            <link rel="stylesheet" type="text/css" href="views/css/{$client_css}"/>
        {foreachelse}
        {/foreach}

    {/if}


</head>
<body>
<div class="container">