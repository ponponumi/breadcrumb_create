<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "ホーム","link" => "/"],
    ["name" => "テスト3"],
];

$breadcrumb = new BreadcrumbCreate("div");
echo $breadcrumb->htmlCreate($array);
