<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "ホーム","link" => "/"],
    ["name" => "テスト2"],
];

$breadcrumb = new BreadcrumbCreate("ol",true);
$breadcrumb->microdataModeSet(false);
echo $breadcrumb->htmlCreate($array);
