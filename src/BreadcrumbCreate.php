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

    public function attributeGet(array $option,string $key,$idGet = true)
    {
        $result = $option[$key] ?? "";

        if(!is_string($result)){
            $result = "";
        }else{
            $getMode = 3;

            if(!$idGet){
                $getMode = 2;
            }

            $result = Create::htmlAttribute($result, 1, $getMode);
        }

        return $result;
    }

    public function htmlCreate(array $data, array $option=[])
    {
        $listAttribute = $this->attributeGet($option, "listAttribute");

        $html = "<" . $this->listTag;
    }
}
