<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "ホーム","link" => "/"],
    ["name" => "テスト1"],
];

$option = [
    "listAttribute" => "#breadcrumb.breadcrumb",
    "itemAttribute" => "#breadcrumbItem.breadcrumbItem",
];

$breadcrumb = new BreadcrumbCreate();
echo $breadcrumb->htmlCreate($array,$option);
