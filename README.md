# test__contact-form
お問い合わせフォーム

## 環境構築

Docker ビルド
 1,git clone リンク
 2,docker-compose up -d --build

 ＊MySQLは、OSによって起動しない場合があるので、それぞれのPCに合わせて docker-compose.yml ファイルを編集してください。

laravel環境構築
 1,docker-compose exec app bash
 2,composer install
 3,.env.example ファイルから.envを作成し、環境変数を変更
 4,php artisan key:generate
 5,php artisan migrate
 6,php artisan db:seed


 ## 使用技術(実行環境)

 ・ php 8.4.1
 ・ Laravel Framework 8.83.29
 ・ mysql  Ver 8.0.32 for Linux on aarch64


## ER図

 contact.drawio.png を参照ください。


## URL

 ・開発環境：http://localhost:8080/
 ・phpMyAdmin：http://localhost:8081/