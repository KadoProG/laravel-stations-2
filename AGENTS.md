# Agent notes

## テスト実行

このプロジェクトでは PHPUnit が MySQL（`mysql-container` など）を前提にしているため、ホストから直接 `php artisan test` を実行すると DB に接続できないことがある。

コンテナ内で実行する:

```bash
docker compose exec php-container php artisan test
```

オプション例:

```bash
docker compose exec php-container php artisan test --group=station10
```
