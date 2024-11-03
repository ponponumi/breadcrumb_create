<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "ホーム","link" => "/"],
    ["name" => "テスト3"],
];

$option = [
    "spanAttribute" => ".span#span",
    "anchorAttribute" => ".anchor#anchor",
];

$breadcrumb = new BreadcrumbCreate("div",true);
echo $breadcrumb->htmlCreate($array,$option);
