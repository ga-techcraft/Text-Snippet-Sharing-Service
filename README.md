# 目次

1. [概要](#概要)  
2. [機能要件](#機能要件)  
3. [技術要件](#技術要件)  
4. [開発の背景と工夫した点](#開発の背景と工夫した点)  
5. [苦労したこと：Webhook を活用した自動デプロイ](#苦労したことwebhook-を活用した自動デプロイ)  
6. [一瞬悩んだこと：スニペット表示のアプローチ](#一瞬悩んだことスニペット表示のアプローチ)  
7. [学び・身についた技術](#学び身についた技術)

---

## 概要
ユーザーがコードスニペットをオンラインで共有できる、Pastebinのようなサービスを構築。アカウント登録不要で、簡単にコードやテキストを貼り付け、共有URLを生成できる。

---

## 機能要件

### 1. スニペットのアップロード
- ユーザーはテキストエリアにテキストやコードを貼り付ける  
- プログラミング言語を選択して構文ハイライトを適用可能  
- 一意のURLが生成される  

### 2. スニペットの閲覧
- 一意のURLでスニペットにアクセスできる  
- 選択された言語に応じた構文ハイライトを表示  

### 3. スニペットの有効期限設定
- オプション：10分、1時間、1日、永続  
- 期限切れスニペットは自動削除  
- 閲覧時に「Expired Snippet」の表示  

---

## 技術要件

### ウェブインターフェース
- **HTML/CSS**：UI作成  
- **JavaScript**：動的処理  
- **Monaco Editor**：コード入力補助  

### バックエンド
- **PHP 8.0+**：OOPで構築  

### データベース
- **MySQL**：スニペットの内容、言語、作成時刻、有効期限を記録  

### ミドルウェア
- マイグレーション管理システムによるスキーマ管理  
- `MySQLWrapper` クラスによるデータベース操作抽象化  

---

## 開発の背景と工夫した点

このプロジェクトでは、**バックエンド開発の理解と経験を深めること**に重点を置いており、UI/UXについては今後改善予定です。  
本番環境として AWS 上の Ubuntu に Nginx を構築し、開発・運用を行いました。  

また、自作の軽量フレームワークで、**Model / View / Controller の役割を明確に分離**することで、コードの見通しが良くなり、機能追加をスムーズに行えるようにしました。

---

## 苦労したこと：Webhook を活用した自動デプロイ

ローカルで `git push` した際に、本番サーバー側が自動で `git pull` を行う「**自動デプロイ**」の仕組みを構築しました。  

GitHub の Webhook を使って、デプロイコマンドをサーバー側で安全に実行するようにしています。  

特に難しかったのは、**本番サーバー上の `.git` ディレクトリの所有権とパーミッションの設計**です。  
セキュリティと実行権限のバランスを取りながら、`www-data` ユーザーで安全に `git pull` を実行できるよう試行錯誤しました。

---

## 一瞬悩んだこと：スニペット表示のアプローチ

スニペットをシェアした際に表示するページについて、当初はサーバーサイドレンダリングで HTML を返すことも検討しました。  

しかし、最終的には **バックエンドは API を提供し、クライアントが取得して描画（クライアントサイドレンダリング）する構成**を採用しました。  

様々なアプローチ方法はありますが、このアプローチにより、スマホ対応や他サービスとの連携も柔軟にできるようになることを学びました。

---

## 学び・身についた技術

- `cron` を使って、**定期バッチ処理**（期限切れスニペットの自動削除）を実装できるようになった  
    → 詳細について以下の Qiita 記事に記載しています。  
    https://qiita.com/TechCraft/items/82ea8a4e1719592434d1  

- Webhook + GitHub + PHP を使った**自動デプロイの構築**  
    → 詳細について以下の Qiita 記事に記載しています。
　　　https://qiita.com/TechCraft/items/576464946639eced8f0b