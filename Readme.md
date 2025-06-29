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

## ライセンスについて

このパッケージは、MITライセンスとして作成されています。
