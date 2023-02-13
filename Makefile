COMPOSER ?= composer
GIT ?= git
PHP ?= php

import: build remove-files copy-files
	$(GIT) status

pull-master:
	(cd source; $(GIT) fetch --tags && git checkout master && git reset --hard && git pull)

build: clean scoper source
	cp build-dist/scoper.inc.php source/
	$(COMPOSER) -d source config autoloader-suffix Phpactor
	$(COMPOSER) -d source config --unset scripts
	$(COMPOSER) -d source install --no-dev --optimize-autoloader --classmap-authoritative --ignore-platform-reqs
	(cd source; $(PHP) -d 'memory_limit=1G' ../build-dist/vendor/bin/php-scoper add-prefix)

build-dist/composer.lock: build-dist/composer.json
	$(COMPOSER) -d build-dist install

build-dist/vendor/bin/php-scoper: build-dist/composer.lock

clean:
	$(GIT) -C source clean -xf .
	$(GIT) -C source reset --hard

clobber: clean
	$(GIT) clean -xf .
	rm -fr -- source
	$(GIT) restore -s HEAD -- source

copy-files:
	cp -r source/dist/* .

commit:
	$(eval PHPACTOR_REVISION := $(shell $(GIT) -C source describe --tags))
	$(GIT) add -A
	$(GIT) commit -m "Import Phpactor $(PHPACTOR_REVISION)"

remove-files:
	rm -fr -- autoload/* bin/* ftplugin/* lib/* plugin/* templates/* vendor/*

scoper: build-dist/vendor/bin/php-scoper

source: source/composer.json

source/composer.json:
	$(GIT) submodule update --init

.PHONY: build clean clobber commit copy-files import pull-master remove-files scoper
