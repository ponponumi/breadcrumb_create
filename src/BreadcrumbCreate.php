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
    private bool $spanMode = true;

    /**
     * パンくずリストを作成する準備をします。
     * @param string $tagMode タグモードを「ul」「ol」「div」から設定してください。「ul」または「ol」をおすすめします。
     * @param mixed $spanMode spanタグで囲うかどうかを選んでください。microdataモードの場合は、無条件で囲います。デフォルトは「true」です。
     */
    public function __construct(string $tagMode = "ul", $spanMode = true)
    {
        $this->tagModeChange($tagMode);
        $this->spanModeSet($spanMode);
    }

    /**
     * spanタグで囲うかどうかを選んでください。microdataモードの場合は、無条件で囲います。
     *
     * @param mixed $value 囲う場合はtrue、囲わない場合はfalseを渡してください。
     * @return void
     */
    public function spanModeSet(mixed $value): void
    {
        $this->spanMode = boolval($value);
    }

    /**
     * 使うHTMLタグを変えます。
     * @param string タグモードを「ul」「ol」「div」から設定してください。「ul」または「ol」をおすすめします。
     * @return void
     */
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

    /**
     * オプションを確認し、あるかどうかを調べます。このメソッドは、まもなくprivateメソッドになります。
     * @param array $option ここには、オプションの連想配列を渡してください。
     * @param string $key ここには、オプションのキーを渡してください。
     * @param string|null $type ここには、データ型を渡してください。全ての型を許可する場合、nullを渡してください。デフォルトではnullです。
     * @return bool
     */
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

    /**
     * このメソッドは、まもなく削除されます。
     *
     * @param array $option
     * @param string $key
     * @param boolean $idGet
     * @return string
     */
    public function attributeGet(array $option,string $key,$idGet = true): string
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

    /**
     * HTML属性を取得します。このメソッドは、まもなくprivateメソッドになります。
     * @param string $value ここには、Emmet形式の文字を渡してください。
     * @param mixed $getMode ここには、どの形式で取得するかを渡してください。
     * @return string
     */
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

    /**
     * リストの属性を変更します。
     * @param string $value ここには、属性を渡してください。
     * @return void
     */
    public function listAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode();
        $this->listAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    /**
     * アイテムの属性を変更します。
     * @param string $value ここには、属性を渡してください。
     * @return void
     */
    public function itemAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode(false);
        $this->itemAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    /**
     * アンカーの属性を変更します。
     * @param string $value ここには、属性を渡してください。
     * @return void
     */
    public function anchorAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode(false);
        $this->anchorAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    /**
     * spanの属性を変更します。
     * @param string $value ここには、属性を渡してください。
     * @return void
     */
    public function spanAttributeSet(string $value): void
    {
        $getMode = $this->attributeGetMode(false);
        $this->spanAttribute = $this->htmlAttributeGet($value, $getMode);
    }

    /**
     * HTMLをエスケープするかを変更します。
     * @param mixed $value 「true」にするとエスケープし、「false」にするとエスケープしません。エスケープしないと、XSS攻撃の対象になる可能性があるため、「true」にする事を推奨します。
     * @return void
     */
    public function htmlEscapeSet($value): void
    {
        // HTMLのエスケープの設定用。trueを推奨。
        $this->htmlEscape = $value;
    }

    /**
     * HTMLの属性を、Emmet形式から変換するか選びます。
     * @param mixed $value 「true」なら変換し、「false」なら変換しません。
     * @return void
     */
    public function htmlAttributeConvertSet($value): void
    {
        $this->htmlAttributeConvert = $value;
    }

    /**
     * ページの名前のキーを設定します。
     * @param string $value 新しいキーを渡してください。
     * @return void
     */
    public function pageNameKeySet(string $value="name"): void
    {
        if($value !== ""){
            $this->pageNameKey = $value;
        }
    }

    /**
     * ページのリンクのキーを設定します。
     * @param string $value 新しいキーを渡してください。
     * @return void
     */
    public function pageLinkKeySet(string $value="link"): void
    {
        if($value !== ""){
            $this->pageLinkKey = $value;
        }
    }

    /**
     * ページの名前とリンクのキーを設定します。
     * @param string $name 新しい名前のキーを渡してください。
     * @param string $link 新しいリンクのキーを渡してください。
     * @return void
     */
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

        // spanタグ
        $spanStart = "";
        $spanEnd = "";

        if($this->microdataMode || $this->spanMode){
            // spanで囲う設定にしているか、HTMLにmicrodataを書き込む設定であれば
            $spanStart = "<span" . $this->spanAttribute . $nameMicrodata . '>';
            $spanEnd = "</span>";
        }

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

    public function html(array $data, array $option=[]): void
    {
        // HTMLを出力
        echo $this->htmlCreate($data, $option);
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
        // JSON-LD形式のJSONを、srciptタグで囲った文字を生成
        $jsonLD = $this->jsonStringCreate($data, $option);

        if($jsonLD !== ""){
            $jsonLD = '<script type="application/ld+json">' . $jsonLD . '</script>';
        }

        return $jsonLD;
    }

    public function jsonScript(array $data, array $option=[]): void
    {
        // JSON-LD形式のJSONを、srciptタグで囲った文字を出力
        echo $this->jsonScriptCreate($data, $option);
    }
}
