COMPOSER ?= composer
GIT ?= git
PHP ?= php

import: build copy-files
	$(GIT) status

build: clean scoper source
	cp build-dist/scoper.inc.php source/
	$(COMPOSER) -d source config autoloader-suffix Phpactor
	$(COMPOSER) -d source config --unset scripts
	$(COMPOSER) -d source install --no-dev --optimize-autoloader --classmap-authoritative --ignore-platform-reqs
	(cd source; $(PHP) -d 'memory_limit=1G' ../build-dist/vendor/bin/php-scoper add-prefix)

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

build-dist/composer.lock: build-dist/composer.json
	$(COMPOSER) -d build-dist install

build-dist/vendor/bin/php-scoper: build-dist/composer.lock

scoper: build-dist/vendor/bin/php-scoper

source: source/composer.json

source/composer.json:
	$(GIT) submodule update --init

.PHONY: build clean clobber commit copy-files import scoper
