.PHONY: init dev dev-d build stop clean logs logs-backend logs-frontend \
        shell-backend shell-frontend shell-db \
        migrate fresh seed \
        build-dev dev-server-up dev-server-down dev-logs \
        build-prod prod-up prod-down prod-logs

# ============================================================
# 初期セットアップ (初回のみ実行)
# ============================================================
init:
	@echo "==> [1/6] .env ファイルをコピー..."
	@cp -n .env.example .env 2>/dev/null || true
	@echo "==> [2/6] コンテナをビルド..."
	docker-compose build --no-cache
	@echo "==> [3/6] Laravel をインストール..."
	docker-compose run --rm backend composer create-project laravel/laravel . --prefer-dist --force
	@echo "==> [4/6] Laravel のサンプルAPIコードを配置..."
	$(MAKE) copy-stubs
	@cp -n backend/.env.example backend/.env 2>/dev/null || true
	docker-compose run --rm backend php artisan key:generate
	@echo "==> [5/6] DB を起動してマイグレーション..."
	docker-compose up -d db redis
	@echo "DBの起動を待機中..."
	@sleep 15
	docker-compose run --rm backend php artisan migrate --seed
	@echo "==> [6/6] フロントエンドの依存関係をインストール..."
	docker-compose run --rm frontend npm install
	@echo ""
	@echo "============================================"
	@echo "セットアップ完了! 'make dev' で開発サーバーを起動"
	@echo "============================================"

# Laravelのスタブファイルをbackend/にコピー
copy-stubs:
	@echo "Laravelサンプルコードを配置中..."
	@mkdir -p backend/app/Http/Controllers/Api
	@cp -f stubs/app/Http/Controllers/Api/TransactionController.php backend/app/Http/Controllers/Api/
	@cp -f stubs/app/Http/Controllers/Api/SummaryController.php backend/app/Http/Controllers/Api/
	@cp -f stubs/app/Models/Transaction.php backend/app/Models/
	@cp -f stubs/database/migrations/2024_01_01_000001_create_transactions_table.php backend/database/migrations/
	@cp -f stubs/database/seeders/TransactionSeeder.php backend/database/seeders/
	@cp -f stubs/database/seeders/DatabaseSeeder.php backend/database/seeders/
	@cp -f stubs/routes/api.php backend/routes/api.php
	@cp -f stubs/bootstrap/app.php backend/bootstrap/app.php
	@echo "サンプルコードの配置が完了しました"

# ============================================================
# 開発サーバー
# ============================================================
dev:
	docker-compose up

dev-d:
	docker-compose up -d

build:
	docker-compose build

stop:
	docker-compose down

clean:
	docker-compose down -v

# ============================================================
# ログ
# ============================================================
logs:
	docker-compose logs -f

logs-backend:
	docker-compose logs -f backend

logs-frontend:
	docker-compose logs -f frontend

# ============================================================
# シェルアクセス
# ============================================================
shell-backend:
	docker-compose exec backend bash

shell-frontend:
	docker-compose exec frontend sh

shell-db:
	docker-compose exec db mysql -u $${DB_USERNAME:-laravel} -p$${DB_PASSWORD:-secret} $${DB_DATABASE:-nostaledger}

# ============================================================
# Laravel コマンド
# ============================================================
migrate:
	docker-compose exec backend php artisan migrate

fresh:
	docker-compose exec backend php artisan migrate:fresh --seed

seed:
	docker-compose exec backend php artisan db:seed

artisan:
	docker-compose exec backend php artisan $(CMD)

# ============================================================
# dev環境 (サクラVPS - ステージング / ログレベル: debug)
# ============================================================
build-dev:
	docker-compose -f docker-compose.dev.yml build

dev-server-up:
	docker-compose -f docker-compose.dev.yml up -d

dev-server-down:
	docker-compose -f docker-compose.dev.yml down

dev-logs:
	docker-compose -f docker-compose.dev.yml logs -f

# ============================================================
# 本番環境 (サクラVPS - ログレベル: error)
# ============================================================
build-prod:
	docker-compose -f docker-compose.prod.yml build

prod-up:
	docker-compose -f docker-compose.prod.yml up -d

prod-down:
	docker-compose -f docker-compose.prod.yml down

prod-logs:
	docker-compose -f docker-compose.prod.yml logs -f
