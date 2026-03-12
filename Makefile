DC := docker compose

DB_NAME ?= E_sitrana_db
DB_USER ?= esitrana
DB_PASS ?= E_sitrana@2024!

.PHONY: up down build restart logs ps app-shell db-shell perms reset-db

up:
	$(DC) up -d --build

down:
	$(DC) down

build:
	$(DC) build

restart:
	$(DC) restart

logs:
	$(DC) logs -f --tail=200

ps:
	$(DC) ps

app-shell:
	$(DC) exec app bash

db-shell:
	$(DC) exec -T db mysql -u$(DB_USER) -p'$(DB_PASS)' $(DB_NAME)

perms:
	$(DC) exec -T app bash -lc "chmod -R 777 /var/www/html/uploads"

reset-db:
	$(DC) down -v
	$(DC) up -d --build
