COMPOSE=docker compose
ENVIRONMENT=$(shell bash ./scripts/get-env.sh)
EXECNGINX=$(COMPOSE) exec nginx
EXECPHP=$(COMPOSE) exec php
EXECVANILLA=$(COMPOSE) exec -w /vanilla php
EXECJQUERY=$(COMPOSE) exec -w /jquery php
EXECSTIMULUS=$(COMPOSE) exec -w /stimulus php
EXECAPISPA=$(COMPOSE) exec -w /api/spa php
EXECSPA=$(COMPOSE) exec spa

start:
	$(COMPOSE) build --force-rm
	$(COMPOSE) up -d --remove-orphans --force-recreate
	make perm
	make vendor
	make db
	make sync
	make perm

up:
	$(COMPOSE) up -d --remove-orphans

stop:
	$(COMPOSE) stop

down:
	$(COMPOSE) down

db: wait-for-db
	$(EXECVANILLA) php bin/console doctrine:database:create --if-not-exists
	$(EXECVANILLA) php bin/console doctrine:schema:update --force

schema: wait-for-db
	$(EXECVANILLA) php bin/console doctrine:schema:update --force

# SSH
ssh-php:
	$(EXECPHP) sh

ssh-vanilla:
	$(EXECVANILLA) sh

ssh-jquery:
	$(EXECJQUERY) sh

ssh-stimulus:
	$(EXECSTIMULUS) sh

ssh-api-spa:
	$(EXECAPISPA) sh

ssh-spa:
	$(EXECSPA) sh

ssh-nginx:
	$(EXECNGINX) bash

# LINTER
lint-vanilla:
	$(EXECVANILLA) yarn lint

lint-jquery:
	$(EXECJQUERY) yarn lint

lint-stimulus:
	$(EXECSTIMULUS) yarn lint

lint-spa:
	$(EXECSPA) yarn lint

# PERM
perm: perm-vanilla perm-jquery perm-stimulus perm-api-spa

perm-vanilla:
ifeq ($(ENVIRONMENT),Linux)
	sudo chown -R www-data:$(USER) ./vanilla
	sudo chmod -R g+rwx ./vanilla
else
	$(EXECPHP) chown -R www-data:root /vanilla
	$(EXECPHP) chown -R www-data:root /vanilla/public/
endif

perm-jquery:
ifeq ($(ENVIRONMENT),Linux)
	sudo chown -R www-data:$(USER) ./jquery
	sudo chmod -R g+rwx ./jquery
else
	$(EXECPHP) chown -R www-data:root /jquery
	$(EXECPHP) chown -R www-data:root /jquery/public/
endif

perm-stimulus:
ifeq ($(ENVIRONMENT),Linux)
	sudo chown -R www-data:$(USER) ./stimulus
	sudo chmod -R g+rwx ./stimulus
else
	$(EXECPHP) chown -R www-data:root /stimulus
	$(EXECPHP) chown -R www-data:root /stimulus/public/
endif

perm-api-spa:
ifeq ($(ENVIRONMENT),Linux)
	sudo chown -R www-data:$(USER) ./api/spa
	sudo chmod -R g+rwx ./api/spa
else
	$(EXECPHP) chown -R www-data:root /api/spa
	$(EXECPHP) chown -R www-data:root /api/spa/public/
endif

# CACHE CLEAR
cc: cc-vanilla cc-jquery cc-stimulus cc-api-spa

cc-vanilla:
	$(EXECVANILLA) bin/console c:cl --no-warmup
	$(EXECVANILLA) bin/console c:warmup

cc-jquery:
	$(EXECJQUERY) bin/console c:cl --no-warmup
	$(EXECJQUERY) bin/console c:warmup

cc-stimulus:
	$(EXECSTIMULUS) bin/console c:cl --no-warmup
	$(EXECSTIMULUS) bin/console c:warmup

cc-api-spa:
	$(EXECAPISPA) bin/console c:cl --no-warmup
	$(EXECAPISPA) bin/console c:warmup

# VENDOR
vendor: vendor-vanilla vendor-jquery vendor-stimulus vendor-api-spa

vendor-vanilla: wait-for-db
	$(EXECVANILLA) composer install -n
	$(EXECVANILLA) yarn install --pure-lockfile
	make perm-vanilla

vendor-jquery: wait-for-db
	$(EXECJQUERY) composer install -n
	$(EXECJQUERY) yarn install --pure-lockfile
	make perm-jquery

vendor-stimulus: wait-for-db
	$(EXECSTIMULUS) composer install -n
	$(EXECSTIMULUS) yarn install --pure-lockfile
	make perm-stimulus

vendor-api-spa: wait-for-db
	$(EXECAPISPA) composer install -n
	make perm-api-spa

# ASSETS
assets: assets-vanilla assets-jquery assets-stimulus

assets-vanilla:
	$(EXECVANILLA) bin/console assets:install
	$(EXECVANILLA) yarn run encore dev

assets-jquery:
	$(EXECJQUERY) bin/console assets:install
	$(EXECJQUERY) yarn run encore dev

assets-stimulus:
	$(EXECSTIMULUS) bin/console assets:install
	$(EXECSTIMULUS) yarn run encore dev

# WAIT DB
wait-for-db:
	$(EXECPHP) php -r "set_time_limit(60);for(;;){if(@fsockopen(\"db\",3306)){break;}echo \"Waiting for DB\n\";sleep(1);}"

# SYNC
sync: sync-vanilla sync-jquery sync-stimulus sync-spa

sync-vanilla:
	@echo Syncing vanilla node_modules dependencies...
ifeq ($(OS)$(SHELL),Windows_NTsh.exe)
	if exist vanilla/node_modules rmdir vanilla/node_modules /S /Q
else
	rm -rf vanilla/node_modules
endif
	mkdir vanilla/node_modules
	docker cp nmj-php:/vanilla/node_modules ./vanilla/
	@echo Dependencies for vanilla synced!

sync-jquery:
	@echo Syncing jquery node_modules dependencies...
ifeq ($(OS)$(SHELL),Windows_NTsh.exe)
	if exist jquery/node_modules rmdir jquery/node_modules /S /Q
else
	rm -rf jquery/node_modules
endif
	mkdir jquery/node_modules
	docker cp nmj-php:/jquery/node_modules ./jquery/
	@echo Dependencies for jquery synced!

sync-stimulus:
	@echo Syncing stimulus node_modules dependencies...
ifeq ($(OS)$(SHELL),Windows_NTsh.exe)
	if exist stimulus/node_modules rmdir stimulus/node_modules /S /Q
else
	rm -rf stimulus/node_modules
endif
	mkdir stimulus/node_modules
	docker cp nmj-php:/stimulus/node_modules ./stimulus/
	@echo Dependencies for stimulus synced!

sync-spa:
	@echo Syncing spa node_modules dependencies...
ifeq ($(OS)$(SHELL),Windows_NTsh.exe)
	if exist spa/node_modules rmdir spa/node_modules /S /Q
else
	rm -rf spa/node_modules
endif
	mkdir spa/node_modules
	docker cp nmj-spa:/usr/src/spa/node_modules ./spa/
	@echo Dependencies for spa synced!
