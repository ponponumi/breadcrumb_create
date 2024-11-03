<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "ホーム"],
];

$breadcrumb = new BreadcrumbCreate();
echo $breadcrumb->htmlCreate($array);
