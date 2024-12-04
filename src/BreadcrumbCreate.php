<?php

namespace Ponponumi\BreadcrumbCreate;

use Ponponumi\HtmlAttributeCreate\Create;

class BreadcrumbCreate
{
    private string $listTag = "ul";
    private string $itemTag = "li";
    private $htmlEscape = true;
    private string $listAttribute = "";
    private string $itemAttribute = "";
    private string $anchorAttribute = "";
    private string $spanAttribute = "";

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
    }

    public function optionCheck(array $option,string $key,string|null $type=null)
    {
        if(array_key_exists($key,$option)){
            if($type === null || gettype($option[$key]) === $type){
                // データ型が指定されていないか、データ型が一致すれば
                return true;
            }
        }

        return false;
    }

    private function attributeGetMode($idGet = true)
    {
        return $idGet ? 3 : 2;
    }

    public function attributeGet(array $option,string $key,$idGet = true)
    {
        $result = $option[$key] ?? "";

        if(!is_string($result)){
            $result = "";
        }else{
            $getMode = $this->attributeGetMode($idGet);
            $result = Create::htmlAttribute($result, 1, $getMode);
        }

        return $result;
    }

    public function listAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode();
        $this->listAttribute = Create::htmlAttribute($value, 1, $getMode);
    }

    public function itemAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode(false);
        $this->itemAttribute = Create::htmlAttribute($value, 1, $getMode);
    }

    public function anchorAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode(false);
        $this->anchorAttribute = Create::htmlAttribute($value, 1, $getMode);
    }

    public function spanAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode(false);
        $this->spanAttribute = Create::htmlAttribute($value, 1, $getMode);
    }

    public function htmlEscapeSet($value)
    {
        // HTMLのエスケープの設定用。trueを推奨。
        $this->htmlEscape = $value;
    }

    public function optionListGet(array $option)
    {
        // オプションをセットする
        if($this->optionCheck($option,"listAttribute","string")){
            $this->listAttributeSet($option["listAttribute"]);
        }

        if($this->optionCheck($option,"itemAttribute","string")){
            $this->itemAttributeSet($option["itemAttribute"]);
        }

        if($this->optionCheck($option,"anchorAttribute","string")){
            $this->anchorAttributeSet($option["anchorAttribute"]);
        }

        if($this->optionCheck($option,"spanAttribute","string")){
            $this->spanAttributeSet($option["spanAttribute"]);
        }

        if($this->optionCheck($option,"htmlEscape")){
            $this->htmlEscapeSet($option["htmlEscape"]);
        }
    }

    public function htmlCreate(array $data, array $option=[])
    {
        $this->optionListGet($option);
        $spanStart = "<span" . $this->spanAttribute . ' itemprop="name">';
        $spanEnd = "</span>";

        $html = "<" . $this->listTag . $this->listAttribute . ' itemscope itemtype="https://schema.org/BreadcrumbList">';

        $i = 1;

        foreach($data as $dataItem){
            $itemName = "";
            $itemLink = "";

            if(is_array($dataItem)){
                $itemName = $dataItem["name"] ?? "";
                $itemLink = $dataItem["link"] ?? "";

                if($this->htmlEscape){
                    $itemName = htmlspecialchars($itemName, ENT_QUOTES);
                    $itemLink = htmlspecialchars($itemLink, ENT_QUOTES);
                }
            }

            $itemHtml = "<" . $this->itemTag . $this->itemAttribute . ' itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';

            if($itemLink !== ""){
                $itemHtml .= '<a href="' . $itemLink . '"' . $this->anchorAttribute . ' itemprop="item">' . $spanStart . $itemName . $spanEnd . '</a>';
            }else{
                $itemHtml .= $spanStart . $itemName . $spanEnd;
            }

            $itemHtml .= '<meta itemprop="position" content="' . strval($i) . '">';
            $itemHtml .= "</" . $this->itemTag . ">";
            $i++;

            $html .= $itemHtml;
        }

        $html .= "</" . $this->listTag . ">";

        return $html;
    }
}
