<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;

$array = [
    ["name" => "<script>alert('hello');</script>ホーム"],
];

$breadcrumb = new BreadcrumbCreate();
echo $breadcrumb->htmlCreate($array);
