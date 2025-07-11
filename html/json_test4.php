<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "ホーム","link" => "/"],
    ["name" => "\"'<JSON&のテスト>'\""],
];

$breadcrumb = new BreadcrumbCreate();
$breadcrumb->jsonScript($array);
