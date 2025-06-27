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

## ライセンスについて

このパッケージは、MITライセンスとして作成されています。
