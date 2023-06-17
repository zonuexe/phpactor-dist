COMPOSER ?= composer
GIT ?= git
PHP ?= php

import: remove-files copy-files
	$(GIT) status

pull-master:
	(cd source; $(GIT) fetch --tags && git checkout master && git reset --hard && git pull)

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

source: source/composer.json

source/composer.json:
	$(GIT) submodule update --init

.PHONY: clean clobber commit copy-files import pull-master remove-files
