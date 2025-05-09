# Attendance
## URL

- 環境開発: http://localhost/
- phpMyAdmin: http://localhost:8080
- MailHog: http://localhost:8025


## 実装機能

- ログイン機能（一般ユーザー・管理者ユーザー）
- ユーザー登録機能（一般ユーザー）
- メール認証機能

### 一般ユーザー

- 勤怠打刻 (出勤・退勤)
- 勤怠一覧の確認
- 勤怠詳細の確認
- 勤怠修正申請の提出
- 自分の修正申請の確認

### 管理者ユーザー

- 日次勤怠一覧の確認
- 各勤怠の詳細確認・修正
- スタッフ一覧の確認
- スタッフ毎の月次勤怠一覧の確認
- 修正申請一覧の確認
- 修正申請の詳細確認・承認

## 使用技術 （実行環境）

- Laravel: 8.83.8
- PHP: 7.4.9
- MYSQL: 8.0.26
- nginx: 1.21.1

## 環境構築

### Dockerのビルド

- docker-compose up -d --build
- macユーザーの方はdocker-compose.ymlに
mysql:
      platform: linux/amd64

phpmyadmin:
      platform: linux/amd64

mailhog:
      platform: linux/amd64  を追加してください。

### インストール

1. リポジトリをクローンします。

    ```sh
    git@github.com:Kenichi-Tnk/Attendance.git

    ```

2. 依存関係をインストールします。

    ```sh
    docker-compose exec php bash

    composer install
    ```

3. 環境設定ファイルをコピーして編集します。

    ```sh
    cp .env.example .env
    ```

    `.env`ファイルを編集して、データベース接続情報などを設定します。

4. アプリケーションキーを生成します。

    ```sh
    php artisan key:generate
    ```
    ```sh
    php artisan db:seed
    ```

5. データベースをマイグレーションしてシーディングします。

    ```sh
    php artisan migrate
    ```

## メール環境設定

- 本プロジェクトでは、開発環境でのメール送信にMailHogを使用しています。以下の設定を`.env`ファイルに追加してください：
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=mailhog
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="noreply@example.com"
    MAIL_FROM_NAME="${APP_NAME}"


## 基本設計
## Model
### User.php
- **説明**: ユーザー情報を管理するモデル。一般ユーザーや管理者ユーザーのデータを保持し、認証や権限管理に使用されます。

### Attendance.php
- **説明**: 勤怠情報を管理するモデル。出勤・退勤時間、日付などのデータを保持し、ユーザーの勤怠記録を管理します。

### AttendanceCorrect.php
- **説明**: 勤怠修正申請を管理するモデル。ユーザーが提出した勤怠修正の内容やステータスを保持します。

### AttendanceCorrectRest.php
- **説明**: 勤怠修正申請に関連する休憩時間を管理するモデル。修正申請に含まれる休憩時間のデータを保持します。

## View
## 会員登録画面(一般ユーザー)
- **bladeファイル名**:auth/register.blade.php

## ログイン画面(一般ユーザー)
- **bladeファイル名**: auth/login.blade.php

## 出勤登録画面(一般ユーザー)
- **bladeファイル名**:user/attendance/register.blade.php

## 勤怠一覧画面(一般ユーザー)
- **bladeファイル名**: user/attendance/index.blade.php

## 勤怠詳細画面(一般ユーザー)
- **bladeファイル名**: user/attendance/detail.blade.php

## 申請一覧画面(一般ユーザー)
- **bladeファイル名**: user/corrects/index.blade.php

## ログイン画面(管理者)
- **bladeファイル名**: auth/admin-login.blade.php

## 勤怠一覧画面(管理者)
- **bladeファイル名**: admin/attendance/index.blade.php

## 勤怠詳細画面(管理者)
- **bladeファイル名**: admin/attendance/detail.blade.php

## スタッフ一覧画面(管理者)
- **bladeファイル名**: admin/staff/index.blade.php

## スタッフ別勤怠一覧画面(管理者)
- **bladeファイル名**: admin/staff/show.blade.php

## 申請一覧画面(管理者)
- **bladeファイル名**: admin/corrects/index.blade.php

## 修正申請承認画面(管理者)
- **bladeファイル名**: admin/corrects/show.blade.php

## テーブル仕様
![users_table](./docs/users.png)
![attendances](./docs/attendances.png)
![rests](./docs/rests.png)
![attendance_corrects](./docs/attendance_corrects.png)
![attendance_correct_rests](./docs/attendance_correct_rests.png)

## ER図
![ER図](./docs/er-diagram.png)

## テストユーザー

### 一般ユーザー

- Email: `testuser@example.com`
- Password: `password`

### 管理者ユーザー

- Email: `admin@example.com`
- Password: `password`

## ライセンス

このプロジェクトはMITライセンスの下で公開されています。詳細はLICENSEファイルを参照してください。
