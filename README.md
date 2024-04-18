# Atte
勤怠管理システムを作成しました。
![stamp画面](https://github.com/daiki0727/Atte/assets/149881657/c1a58ed6-b582-4975-af0c-3b8848ecc4fe)
ログイン後、勤務開始・終了、休憩開始・終了のボタン押下で勤務時間を管理します。

## 作成した目的
○○社の人事評価の為。

## アプリケーションURL
+ 開発環境：http://localhost/
+ phpMyAdmin：Http://localhost:8080/

## 他のリポジトリ
作成中

## 機能一覧
+ ログイン機能
  
  >新規登録後、メールアドレス・パスワードでログインします。
+ メール認証
  
  >新規ユーザー登録により、メール認証が送られます。
+ 勤務時間管理
  
  >勤務時間の重複を防ぐため、１日に１度のみ勤務開始ボタンを押下する事ができます。
+ 休憩時間管理
  
  >１日に何度も休憩が可能です。
+ 日付別勤怠管理
  
  >日別に勤務したユーザーの一覧を見ることができます。
+ ユーザー別勤怠管理
  
  >ユーザー別の勤怠表を見ることができます。
+ ユーザー検索機能
  
  >ユーザー名をあいまい検索できます。

## 使用技術（実行環境）
+ PHP8.3.0
+ Laravel 8.83.27
+ MySQL8.0.26

## テーブル設計
![勤怠管理システム各テーブル](https://github.com/daiki0727/Atte/assets/149881657/7af41c7b-66a1-4fbb-99d2-6f8667981a3e)

## ER図
![初級案件ER図](https://github.com/daiki0727/Atte/assets/149881657/3b63492a-d063-4ceb-accb-d8c4d0a80716)

# 環境構築

## Dockerビルド
1. `git clone `
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

## Laravel環境構築
1. `docker-compse exec php bash`
2. `composer install`
3. .envに以下の環境変数を追加
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE= laravel_db
DB_USERNAME= laravel_user
DB_PASSWORD= laravel_pass
```
5. アプリケーションキーの作成
```
php artisan key:generate
```
7. マイグレーションの実行
```
php artisan migrate
```
8. シーディングの実行
```
php artisan migrate --seed 
```
