# アプリケーション名
Atte
勤怠管理システム

## 作成した目的
模擬案件

## 機能一覧
- 会員登録してログイン
- 勤務開始、勤務終了、休憩開始、休憩終了の管理

## 使用技術
- Laravel 8.83.29
- PHP 7.4.9
- MySQL 8.0.26

## テーブル設計

### users テーブル
| カラム名    | 型        | 制約            |
|------------|----------|----------------|
| id         | BIGINT   | 主キー         |
| name       | STRING   | NOT NULL       |
| email      | STRING   | UNIQUE, NOT NULL |
| password   | STRING   | NOT NULL       |
| created_at | TIMESTAMP | 自動生成      |
| updated_at | TIMESTAMP | 自動生成      |

### attendances テーブル
| カラム名    | 型       | 制約                     |
|------------|---------|--------------------------|
| id         | BIGINT  | 主キー                   |
| user_id    | BIGINT  | 外部キー（users.id）     |
| date       | DATE    | UNIQUE, NOT NULL         |
| start_work | TIME    | NOT NULL                 |
| end_work   | TIME    | NULLABLE                 |
| created_at | TIMESTAMP | 自動生成               |
| updated_at | TIMESTAMP | 自動生成               |

### rests テーブル
| カラム名       | 型       | 制約                     |
|--------------|---------|--------------------------|
| id           | BIGINT  | 主キー                   |
| attendance_id | BIGINT  | 外部キー（attendances.id） |
| start_rest   | TIME    | NOT NULL                 |
| end_rest     | TIME    | NULLABLE                 |
| created_at   | TIMESTAMP | 自動生成               |
| updated_at   | TIMESTAMP | 自動生成               |

## ER図
![ER図](docs/er_diagram.png)

## 環境構築

### **Docker ビルド**
1. **プロジェクトをクローン**
   ```bash
   git clone git@github.com:mihonitou/atte3.git
   ```
2. DockerDesktop アプリを立ち上げる
3. Docker コンテナをビルドして起動
   ```bash
   docker compose up -d --build
   ```
⚠ no matching manifest for linux/arm64/v8 in the manifest list entries
というエラーが出た場合は、docker-compose.yml に以下の記述を追加
```yaml
mysql:
  image: mysql:8.0.26
  platform: linux/amd64

phpmyadmin:
  image: phpmyadmin/phpmyadmin:latest
  platform: linux/amd64
```
**Laravel環境構築**
1. コンテナに入る
```bash
docker compose exec php bash
```
2. Composer をインストール
```bash
composer install
```
3. .env ファイルを作成
```bash
cp .env.example .env
```
4. データベース接続情報を .env に追加
```text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
```bash
php artisan key:generate
```
6. マイグレーションの実行
```bash
php artisan migrate
```
7. シーディングの実行（ダミーデータ作成）
```bash
php artisan db:seed
```
## **URL**
| 環境          | URL                     |
|-------------|-------------------------|
| 開発環境       | [http://localhost/](http://localhost/) |
| phpMyAdmin | [http://localhost:8080/](http://localhost:8080/) |

## テストユーザーのアカウント
6人分のユーザーを用意
**全員のパスワードは `password`**

| 名前       | メールアドレス         | パスワード  |
|----------|-----------------|---------|
| テスト一郎 | `ichiro@test.com` | `password` |
| テスト二郎 | `jiro@test.com`   | `password` |
| テスト三郎 | `saburo@test.com` | `password` |
| テスト四郎 | `shiro@test.com`  | `password` |
| テスト五郎 | `goro@test.com`   | `password` |
| テスト六郎 | `rokuro@test.com` | `password` |

各ユーザーの **12月分の勤怠データ** を用意済み

