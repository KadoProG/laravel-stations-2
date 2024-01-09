ここはデータベースの設定を行うところらしい

## factories

パチもんデータを挿入する際どういうパチもんを挿入するかを設定するファイル。パチもんを挿入しない場合は作らなくて OK。

## migrations

データテーブルを作成するところ。日付順に実行されるらしい。外部キーが必要な場合は後に実行するように命名するように。

```bash
# /database/mygrations/****_create_****_table.phpが作成される
docker compose exec php-container php artisan make:migration CreatePracticesTable
```

## seedres

サンプルデータを挿入するコマンド`db:seed`で実行される。factories で作ったパチもんを呼び出すときもここから個数を指定して実行する。

原則 migration 後 1 回のみ実行するらしい。

## そして忘れず Model ファイルを作成する

```bash
# これを実行すると、app/Models/Practice.phpが作成されるんだってさ
docker compose exec php-container php artisan make:model Practice
```
