<?php

namespace Ponponumi\BreadcrumbCreate;

use Ponponumi\HtmlAttributeCreate\Create;

class BreadcrumbCreate
{
    private string $listTag = "ul";
    private string $itemTag = "li";
    private $spanMode = false;

    public function __construct(string $tagMode = "ul", $spanMode = false)
    {
        switch($tagMode){
            case "ol":
                $this->listTag = "ol";
                break;
            case "div":
                $this->listTag = "div";
                $this->itemTag = "div";
                break;
        }

        $this->spanMode = $spanMode;
    }

    public function attributeGet(array $option,string $key)
    {
        $result = $option[$key] ?? "";

        if(!is_string($result)){
            $result = "";
        }

        return $result;
    }

    public function htmlCreate(array $data, array $option=[])
    {
        $html = "<" . $this->listTag;
    }
}
