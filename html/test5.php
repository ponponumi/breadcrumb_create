<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "ホーム","link" => "/"],
    ["name" => "テスト5"],
];

$option = [
    "listAttribute" => 'class="breadcrumb" id="breadcrumb"',
    "itemAttribute" => 'class="breadcrumbItem"',
    "spanAttribute" => 'class="span"',
    "anchorAttribute" => 'class="anckor"',
    "htmlAttributeConvert" => false,
];

$breadcrumb = new BreadcrumbCreate();
echo $breadcrumb->htmlCreate($array,$option);
