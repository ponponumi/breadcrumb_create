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
    private $htmlAttributeConvert = true;
    private string $pageNameKey = "name";
    private string $pageLinkKey = "link";

    public function __construct(string $tagMode = "ul", $spanMode = false)
    {
        $this->tagModeChange($tagMode);
    }

    public function tagModeChange(string $tagMode="ul")
    {
        switch($tagMode){
            case "ul":
                $this->listTag = "ul";
                $this->itemTag = "li";
                break;
            case "ol":
                $this->listTag = "ol";
                $this->itemTag = "li";
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
        // このメソッドはもう使わないが、外部アプリから呼び出される恐れがあるので残しておく
        $result = $option[$key] ?? "";

        if(!is_string($result)){
            $result = "";
        }else{
            $getMode = $this->attributeGetMode($idGet);
            $result = Create::htmlAttribute($result, 1, $getMode);
        }

        return $result;
    }

    public function htmlAttributeGet(string $value,$getMode)
    {
        // HTML属性を取得する
        if($this->htmlAttributeConvert){
            // 変換する場合
            return Create::htmlAttribute($value, 1, $getMode);
        }else{
            if(mb_substr($value,0,1) !== " "){
                // 最初が空文字でなければ、空文字を追加
                $value = " " . $value;
            }

            return $value;
        }
    }

    public function listAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode();
        $this->listAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function itemAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode(false);
        $this->itemAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function anchorAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode(false);
        $this->anchorAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function spanAttributeSet(string $value)
    {
        $getMode = $this->attributeGetMode(false);
        $this->spanAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function htmlEscapeSet($value)
    {
        // HTMLのエスケープの設定用。trueを推奨。
        $this->htmlEscape = $value;
    }

    public function htmlAttributeConvertSet($value)
    {
        $this->htmlAttributeConvert = $value;
    }

    public function pageNameKeySet(string $value="name")
    {
        if($value !== ""){
            $this->pageNameKey = $value;
        }
    }

    public function pageLinkKeySet(string $value="link")
    {
        if($value !== ""){
            $this->pageLinkKey = $value;
        }
    }

    public function pageKeySet(string $name="name",string $link="link")
    {
        // ページ名とリンクのキーを変更
        if($name !== $link){
            $this->pageNameKeySet($name);
            $this->pageLinkKeySet($link);
        }
    }

    public function optionListSet(array $option)
    {
        // オプションをセットする
        if($this->optionCheck($option,"htmlAttributeConvert")){
            $this->htmlAttributeConvertSet($option["htmlAttributeConvert"]);
        }

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

        if($this->optionCheck($option,"pageNameKey","string")){
            $this->pageNameKeySet($option["pageNameKey"]);
        }

        if($this->optionCheck($option,"pageLinkKey","string")){
            $this->pageLinkKeySet($option["pageLinkKey"]);
        }

        if($this->optionCheck($option,"htmlEscape")){
            $this->htmlEscapeSet($option["htmlEscape"]);
        }
    }

    public function htmlCreate(array $data, array $option=[])
    {
        $this->optionListSet($option);
        $spanStart = "<span" . $this->spanAttribute . ' itemprop="name">';
        $spanEnd = "</span>";

        $html = "<" . $this->listTag . $this->listAttribute . ' itemscope itemtype="https://schema.org/BreadcrumbList">';

        $i = 1;

        foreach($data as $dataItem){
            $itemName = "";
            $itemLink = "";

            if(is_array($dataItem)){
                $itemName = $dataItem[$this->pageNameKey] ?? "";
                $itemLink = $dataItem[$this->pageLinkKey] ?? "";

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
