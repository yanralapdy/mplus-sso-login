ENV ?= dev

.PHONY: help up down build shell artisan logs

help:
	@echo "Available commands:"
	@echo "  make up ENV=dev|prod     Start containers"
	@echo "  make down ENV=dev|prod   Stop containers"
	@echo "  make build ENV=dev|prod  Build images"
	@echo "  make shell               Enter app container"
	@echo "  make artisan cmd='...'   Run artisan command"
	@echo "  make setup	Run necessary command for laravel to run"

up:
	docker compose -f docker-compose.$(ENV).yml up -d

down:
	docker compose -f docker-compose.$(ENV).yml down

build:
	docker compose -f docker-compose.$(ENV).yml build

shell:
	docker compose -f docker-compose.dev.yml exec app sh

artisan:
	docker compose -f docker-compose.dev.yml exec app php artisan $(cmd)

setup:
	docker compose -f docker-compose.$(ENV).yml exec app sh ./sh/$(ENV).sh

