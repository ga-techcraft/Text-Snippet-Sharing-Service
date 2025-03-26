# Pastebin風スニペット共有サービス 仕様書

## 概要
ユーザーがプレーンテキストやコードスニペットをオンラインで共有できる、Pastebinのようなサービスを構築する。アカウント登録不要で、簡単にコードやテキストを貼り付け、共有URLを生成できる。

---

## 機能要件

### 1. スニペットのアップロード
- ユーザーはテキストエリアにテキストやコードを貼り付ける
- プログラミング言語を選択して構文ハイライトを適用可能
- 一意のURL（例：https://{domain}/{path}/{unique-string}）が生成される
- `parse_url` のようなライブラリでURLのパースが可能

### 2. スニペットの閲覧
- 一意のURLでスニペットにアクセスできる
- 選択された言語に応じた構文ハイライトを表示

### 3. スニペットの有効期限設定
- オプション：10分、1時間、1日、永続
- 期限切れスニペットは自動削除
- 閲覧時に「Expired Snippet」の表示

### 4. データストレージ
- 入力は全て検証・サニタイズされる
- SQLインジェクション対策済みの安全な保存方法を採用

### 5. フロントエンドインターフェース
- HTML/CSSによるシンプルかつ使いやすいUI
- Monacoエディタでコード入力をサポート（検討）
- 投稿後、一意のURLが生成されて表示される

### 6. エラーハンドリング
- 入力文字数制限、未サポート文字に対する処理
- エラーメッセージの明示

---

## 技術要件

### ウェブインターフェース
- **HTML/CSS**：UI作成
- **JavaScript**：動的処理
- **Monaco Editor**（検討）：コード入力補助

### バックエンド
- **PHP 8.0+**：OOPで構築
- **一意URL生成**：`hash()` 関数等を利用

### データベース
- **MySQL**：スニペットの内容、言語、作成時刻、有効期限を記録

### ミドルウェア
- マイグレーション管理システムによるスキーマ管理
- `MySQLWrapper` クラスによるデータベース操作抽象化

---

## 非機能要件

### デプロイメント
- 短く覚えやすいドメインやサブドメインで公開
- 高可用性の確保（ダウンタイム最小化）
- Git同期によりワンタッチで開発・デプロイ可能な体制

### パフォーマンス
- スニペット取得の高速化
- 構文ハイライトの即時反映

### スケーラビリティ
- 同時多数リクエストに対応できる構成

### セキュリティ
- データは暗号化とHTTPS通信で安全に管理
- サニタイズ処理と安全なデータベース操作

---

## 備考
- 使用ライブラリ：Monaco Editor、highlight.js、PHP hash ライブラリなど
- 管理ツール：Git、MySQL Workbench、phpMyAdmin など
- 構成：LAMP/LEMPスタック想定

