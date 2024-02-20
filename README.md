# PHP非同期処理(Guzzle)
php version 8.0想定

## docker起動〜ライブラリインストール
```shell
$ cd infra
$ cp .env.example .env # infra dir
$ docker-compose up -d # infra dir
$ docker-compose exec php bash # infra dir
$ cd html # (in container)
$ composer install # html dir (in container)
```

https://lvh.me
