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

## ライセンスについて

このパッケージは、MITライセンスとして作成されています。
