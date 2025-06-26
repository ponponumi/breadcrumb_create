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
    private bool $microdataMode = true;

    public function __construct(string $tagMode = "ul", $spanMode = false)
    {
        $this->tagModeChange($tagMode);
    }

    public function tagModeChange(string $tagMode="ul"): void
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

    public function optionCheck(array $option,string $key,string|null $type=null): bool
    {
        if(array_key_exists($key,$option)){
            if($type === null || gettype($option[$key]) === $type){
                // データ型が指定されていないか、データ型が一致すれば
                return true;
            }
        }

        return false;
    }

    private function attributeGetMode($idGet = true): int
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

    public function htmlAttributeGet(string $value,$getMode): string
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

    public function listAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode();
        $this->listAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function itemAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode(false);
        $this->itemAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function anchorAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode(false);
        $this->anchorAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function spanAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode(false);
        $this->spanAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    public function htmlEscapeSet($value): void
    {
        // HTMLのエスケープの設定用。trueを推奨。
        $this->htmlEscape = $value;
    }

    public function htmlAttributeConvertSet($value): void
    {
        $this->htmlAttributeConvert = $value;
    }

    public function pageNameKeySet(string $value="name"): void
    {
        if($value !== ""){
            $this->pageNameKey = $value;
        }
    }

    public function pageLinkKeySet(string $value="link"): void
    {
        if($value !== ""){
            $this->pageLinkKey = $value;
        }
    }

    public function pageKeySet(string $name="name",string $link="link"): void
    {
        // ページ名とリンクのキーを変更
        if($name !== $link){
            $this->pageNameKeySet($name);
            $this->pageLinkKeySet($link);
        }
    }

    public function microdataModeSet(bool $value=true): void
    {
        // microdataモードを有効にするか
        $this->microdataMode = $value;
    }

    public function optionListSet(array $option, bool $jsonLDMode=false): void
    {
        // オプションをセットする
        if(!$jsonLDMode){
            // JSON-LDでなければ
            if($this->optionCheck($option,"htmlAttributeConvert")){
                $this->htmlAttributeConvertSet($option["htmlAttributeConvert"]);
            }

            if($this->optionCheck($option,"microdataMode")){
                $this->microdataModeSet(boolval($option["microdataMode"]));
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

            if($this->optionCheck($option,"htmlEscape")){
                $this->htmlEscapeSet($option["htmlEscape"]);
            }
        }

        if($this->optionCheck($option,"pageNameKey","string")){
            $this->pageNameKeySet($option["pageNameKey"]);
        }

        if($this->optionCheck($option,"pageLinkKey","string")){
            $this->pageLinkKeySet($option["pageLinkKey"]);
        }
    }

    public function htmlCreate(array $data, array $option=[]): string
    {
        if($data === []){
            return "";
        }

        // マイクロデータ
        $listMicrodata = "";
        $itemMicrodata = "";
        $linkMicrodata = "";
        $nameMicrodata = "";

        if($this->microdataMode){
            // マイクロデータが有効であれば
            $listMicrodata = ' itemscope itemtype="https://schema.org/BreadcrumbList"';
            $itemMicrodata = ' itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"';
            $linkMicrodata = ' itemprop="item"';
            $nameMicrodata = ' itemprop="name"';
        }

        $this->optionListSet($option);
        $spanStart = "<span" . $this->spanAttribute . $nameMicrodata . '>';
        $spanEnd = "</span>";

        $html = "<" . $this->listTag . $this->listAttribute . $listMicrodata . '>';

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

            $itemHtml = "<" . $this->itemTag . $this->itemAttribute . $itemMicrodata . '>';

            if($itemLink !== ""){
                $itemHtml .= '<a href="' . $itemLink . '"' . $this->anchorAttribute . $linkMicrodata . '>' . $spanStart . $itemName . $spanEnd . '</a>';
            }else{
                $itemHtml .= $spanStart . $itemName . $spanEnd;
            }

            if($this->microdataMode){
                $itemHtml .= '<meta itemprop="position" content="' . strval($i) . '">';
                $i++;
            }

            $itemHtml .= "</" . $this->itemTag . ">";

            $html .= $itemHtml;
        }

        $html .= "</" . $this->listTag . ">";

        return $html;
    }

    public function jsonArrayCreate(array $data, array $option=[]): array
    {
        // JSON-LD形式の配列を作成
        if($data === []){
            return [];
        }

        $this->optionListSet($option, true);

        $result = [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => [],
        ];

        $count = 1;

        foreach($data as $dataItem){
            $itemName = "";
            $itemLink = "";

            if(is_array($dataItem)){
                $itemName = $dataItem[$this->pageNameKey] ?? "";
                $itemLink = $dataItem[$this->pageLinkKey] ?? "";
            }

            $addData = [
                "@type" => "ListItem",
                "position" => $count,
                "name" => $itemName,
            ];

            if($itemLink !== ""){
                $addData["item"] = $itemLink;
            }

            $count++;

            $result["itemListElement"][] = $addData;
        }

        return $result;
    }

    public function jsonStringCreate(array $data, array $option=[]): string
    {
        // JSON-LD形式のJSONを生成
        $jsonArray = $this->jsonArrayCreate($data, $option);

        if($jsonArray === []){
            return "";
        }

        return json_encode($jsonArray);
    }

    public function jsonScriptCreate(array $data, array $option=[]): string
    {
        $jsonLD = $this->jsonStringCreate($data, $option);

        if($jsonLD !== ""){
            $jsonLD = '<script type="application/ld+json">' . $jsonLD . '</script>';
        }

        return $jsonLD;
    }

    public function jsonScript(array $data, array $option=[]): void
    {
        echo $this->jsonScriptCreate($data, $option);
    }
}
