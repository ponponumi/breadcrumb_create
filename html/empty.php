<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [];

$option = [
    "listAttribute" => 'class="breadcrumb" id="breadcrumb"',
    "itemAttribute" => 'class="breadcrumbItem"',
    "spanAttribute" => 'class="span"',
    "anchorAttribute" => 'class="anckor"',
    "htmlAttributeConvert" => false,
    "pageNameKey" => "title",
    "pageLinkKey" => "url",
];

$breadcrumb = new BreadcrumbCreate();
echo $breadcrumb->htmlCreate($array,$option);
