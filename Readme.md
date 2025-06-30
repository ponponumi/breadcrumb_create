# breadcrumb_create

このパッケージは、パンくずリストを生成するライブラリです。

## Composerでのインストールについて

次のコマンドを実行する事で、インストール可能です。

```bash
composer require ponponumi/breadcrumb_create
```

## パッケージの読み込みについて

PHPファイルに、次のように入力してください。(autoload.phpへのパスは、必要に応じて修正してください)

```php
require_once __DIR__ . "/vendor/autoload.php";

use Ponponumi\BreadcrumbCreate\BreadcrumbCreate;
```

## BreadcrumbCreateクラスについて

このクラスのメソッドは、全て動的メソッドとして作成しているため、インスタンスの作成が必要です。

### コンストラクタについて

次のように記述してください。

```php
$breadcrumb = new BreadcrumbCreate("ul",true);
```

#### 引数について

左から、次のようになっています。

##### string $tagMode="ul"

「ul」にすると、ulタグでliタグを囲います。

「ol」にすると、olタグでliタグを囲います。

「div」にすると、divタグでdivタグを囲います。

「ul」または「ol」にする事をおすすめします。

「ul」「ol」「div」以外の文字を渡した場合、「ul」として処理されます。

##### $spanMode=true

spanタグで囲うかどうかを選びます。

初期状態では「true」です。

なお、microdataモードが有効の場合、こちらで「false」を指定したとしても、spanタグで囲いますのでご注意ください。

### spanModeSetメソッドについて

ページ名をspanタグで囲うかどうかを選びます。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->spanModeSet(true);
```

#### 引数について

##### mixed $value

spanタグで囲うかどうかを選びます。

「true」の場合は囲い、「false」の場合は囲いません。

bool型以外を渡した場合、boolval関数で変換されます。

なお、microdataモードが有効の場合、こちらで「false」を指定したとしても、spanタグで囲いますのでご注意ください。

### tagModeChangeメソッドについて

使うHTMLタグを選びます。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->tagModeChange("ol");
```

#### 引数について

##### string $tagMode="ul"

「ul」にすると、ulタグでliタグを囲います。

「ol」にすると、olタグでliタグを囲います。

「div」にすると、divタグでdivタグを囲います。

「ul」または「ol」にする事をおすすめします。

「ul」「ol」「div」以外の文字を渡した場合、エラーは発生せず、現在の設定が引き継がれます。

### htmlAttributeConvertSetメソッドについて

HTMLの属性を、Emmet形式から変換するか選びます。

変換する場合、後述するHTML属性を指定するメソッドで、例えば「#breadcrumb-elem.breadcrumb.breadcrumb-list」という文字を渡すと、「id="breadcrumb-elem" class="breadcrumb breadcrumb-list"」を出力します。

「true」を渡せば変換し、「false」を渡せば変換しません。

変換しない場合、例えば「id="breadcrumb-elem" class="breadcrumb breadcrumb-list"」という属性を付与したい場合、後述するHTML属性を指定するメソッドで、「id="breadcrumb-elem" class="breadcrumb breadcrumb-list"」を渡してください。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->htmlAttributeConvertSet(true);
```

### listAttributeSetメソッドについて

HTMLのリストのタグ(ulまたはol)の、class属性とid属性を指定します。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->listAttributeSet(".breadcrumb#breadcrumb");
```

または

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->htmlAttributeConvertSet(false);
$breadcrumb->listAttributeSet('class="breadcrumb" id="breadcrumb"');
```

この場合、いずれも次のようなHTMLが生成されます。

```html
<ul class="breadcrumb" id="breadcrumb">
    <!-- パンくずリストのHTML -->
</ul>
```

### itemAttributeSetメソッドについて

HTMLのリストアイテムのタグ(li)の、class属性を指定します。

id属性は指定できません。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->itemAttributeSet(".breadcrumb-item");
```

または

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->htmlAttributeConvertSet(false);
$breadcrumb->itemAttributeSet('class="breadcrumb-item"');
```

この場合、いずれも次のようなHTMLが生成されます。

```html
<li class="breadcrumb-item">
    <!-- パンくずリストのHTML -->
</li>
```

### anchorAttributeSetメソッドについて

HTMLのアンカータグ(aタグ)の、class属性を指定します。

id属性は指定できません。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->anchorAttributeSet(".breadcrumb-item-link");
```

または

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->htmlAttributeConvertSet(false);
$breadcrumb->anchorAttributeSet('class="breadcrumb-item-link"');
```

この場合、いずれも次のようなHTMLが生成されます。

```html
<a class="breadcrumb-item-link">
    <!-- パンくずリストのHTML -->
</a>
```

### spanAttributeSetメソッドについて

HTMLのspanタグの、class属性を指定します。

id属性は指定できません。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->spanAttributeSet(".breadcrumb-item-name");
```

または

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->htmlAttributeConvertSet(false);
$breadcrumb->spanAttributeSet('class="breadcrumb-item-name"');
```

この場合、いずれも次のようなHTMLが生成されます。

```html
<span class="breadcrumb-item-name">
    トップ
</span>
```

### htmlEscapeSetメソッドについて

HTMLに出力する際、文字列をhtmlspecialchars関数で、エスケープするかどうかを選びます。

エスケープする場合はtrue、しない場合はfalseを渡してください。

初期値ではtrueです。

falseにすると、XSS攻撃が発生する可能性がありますので、余程の事情がない限り、trueのままにする事をおすすめします。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->htmlEscapeSet(true);
```

### pageNameKeySetメソッドについて

ページ名の連想配列のキーを指定してください。

初期値では「name」です。

例えば、「pageName」に変更する場合、次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->pageNameKeySet("pageName");
```

### pageLinkKeySetメソッドについて

ページリンクの連想配列のキーを指定してください。

初期値では「link」です。

例えば、「pageLink」に変更する場合、次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->pageLinkKeySet("pageLink");
```

### pageKeySetメソッドについて

ページ名とページリンクの連想配列のキーを指定してください。

初期値では「link」です。

例えば、ページ名は「pageName」、ページリンクは「pageLink」に変更する場合、次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->pageKeySet("pageName","pageLink");
```

### microdataModeSetメソッドについて

HTMLを、microdata形式のパンくずリストにするかどうかを、選びます。

初期値では「true」です。

microdataを無効にする場合、次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->microdataModeSet(false);
```

#### HTMLでの出力例について

前提条件として、後述する次のデータをHTML生成用のメソッドに、渡したとします。

```php
$data = [
    ["name" => "ホーム","link" => "http://localhost/"],
    ["name" => "ページ"],
];
```

microdataが有効の場合、次のように出力されます。

```html
<ul itemscope itemtype="https://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="http://localhost/" itemprop="item">
            <span itemprop="name">ホーム</span>
        </a>
        <meta itemprop="position" content="1">
    </li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">ページ</span>
        <meta itemprop="position" content="2">
    </li>
</ul>
```

microdataが無効の場合、次のように出力されます。

```html
<ul>
    <li>
        <a href="http://localhost/">
            <span>ホーム</span>
        </a>
    </li>
    <li>
        <span>ページ</span>
    </li>
</ul>
```

##### どちらにするべきか？

* JSON-LD形式のパンくずリストを使う→microdataを無効
* JSON-LD形式のパンくずリストを使わない→microdataを有効

こうする事をお勧めします。

### optionListSetメソッドについて

オプションを設定します。

次のように記述してください。

戻り値はありません。

```php
$breadcrumb = new BreadcrumbCreate();
$breadcrumb->optionListSet([
    "htmlAttributeConvert" => true,                 // htmlAttributeConvertSetメソッドに渡します
    "listAttribute" => ".breadcrumb",               // listAttributeSetメソッドに渡します
    "itemAttribute" => ".breadcrumb-item",          // itemAttributeSetメソッドに渡します
    "anchorAttribute" => ".breadcrumb-item-link",   // anchorAttributeSetメソッドに渡します
    "spanAttribute" => ".breadcrumb-item-name",     // spanAttributeSetメソッドに渡します
    "htmlEscape" => true,                           // htmlEscapeSetメソッドに渡します
    "pageNameKey" => "name",                        // pageNameKeySetメソッドに渡します
    "pageLinkKey" => "link",                        // pageLinkKeySetメソッドに渡します
]);
```

#### 引数について

左から、次のようなオプションになります。

##### array $option

上記のような配列を、渡してください。

省略はできません。

##### bool $jsonLDMode=false

JSON-LD形式のパンくずリスト向けのデータを渡す場合、「true」を渡してください。

trueにすると、「pageNameKey」と「pageLinkKey」以外のデータを、設定しなくなります。

省略した場合はfalseとして扱います。

### htmlCreateメソッドについて

パンくずリストのHTMLを生成します。

戻り値は、生成したHTMLを文字列として返します。

次のように記述してください。

```php
$data = [
    ["name" => "ホーム","link" => "http://localhost/"],
    ["name" => "ページ"],
];

$option = [
    "listAttribute" => ".breadcrumb#breadcrumb",
    "itemAttribute" => ".breadcrumb-item",
    "anchorAttribute" => ".breadcrumb-item-link",
    "spanAttribute" => ".breadcrumb-item-name"
];

$breadcrumb = new BreadcrumbCreate();
$html = $breadcrumb->htmlCreate($data, $option);
echo $html;
```

この場合、次のようなHTMLを生成します。

```html
<ul id="breadcrumb" class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="http://localhost/" class="breadcrumb-item-link" itemprop="item">
            <span class="breadcrumb-item-name" itemprop="name">ホーム</span>
        </a>
        <meta itemprop="position" content="1">
    </li>
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span class="breadcrumb-item-name" itemprop="name">ページ</span>
        <meta itemprop="position" content="2">
    </li>
</ul>
```

#### 引数について

左から、次のような引数になります。

##### array $data

ここには、パンくずリストのデータを渡してください。

##### array $option=[]

ここには、オプションの配列を渡してください。

内部的には、optionListSetメソッドを呼び出しておりますので、配列の形式については、上記のoptionListSetメソッドについての説明をご覧ください。

### htmlメソッドについて

引数、生成するHTMLについては、htmlCreateメソッドと同じです。

しかし、このメソッドでは戻り値がなく、htmlCreateメソッドの値をechoで出力します。

次のように記述してください。

```php
$data = [
    ["name" => "ホーム","link" => "http://localhost/"],
    ["name" => "ページ"],
];

$option = [
    "listAttribute" => ".breadcrumb#breadcrumb",
    "itemAttribute" => ".breadcrumb-item",
    "anchorAttribute" => ".breadcrumb-item-link",
    "spanAttribute" => ".breadcrumb-item-name"
];

$breadcrumb = new BreadcrumbCreate();
$breadcrumb->html($data, $option);
```

## ライセンスについて

このパッケージは、MITライセンスとして作成されています。
