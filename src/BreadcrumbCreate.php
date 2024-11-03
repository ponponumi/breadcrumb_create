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
        $itemAttribute = $this->attributeGet($option, "itemAttribute", false);
        $anchorAttribute = $this->attributeGet($option, "anchorAttribute", false);
        $spanStart = "";
        $spanEnd = "";

        if($this->spanMode){
            $spanAttribute = $this->attributeGet($option, "spanAttribute", false);
            $spanStart = "<span" . $spanAttribute . ">";
            $spanEnd = "</span>";
        }

        $html = "<" . $this->listTag . $listAttribute . ' itemscope itemtype="https://schema.org/BreadcrumbList">';

        foreach($data as $dataItem){
            $itemName = "";
            $itemLink = "";

            if(is_array($dataItem)){
                $itemName = $dataItem["name"] ?? "";
                $itemLink = $dataItem["link"] ?? "";
            }

            $itemHtml = "<" . $this->itemTag . $itemAttribute . ' itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';

            if($itemLink !== ""){
                $itemHtml .= '<a href="' . $itemLink . '"' . $anchorAttribute . '>' . $itemName . '</a>';
            }else{
                $itemHtml .= $spanStart . $itemName . $spanEnd;
            }

            $itemHtml .= "</" . $this->itemTag . ">";

            $html .= $itemHtml;
        }

        $html .= "</" . $this->listTag . ">";

        return $html;
    }
}
