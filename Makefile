PHPCS  = phpcs
PHPCBF = phpcbf
SRC    = App

lint:
	${PHPCS} --standard=ruleset.xml ${SRC}

fix:
	${PHPCBF} --standard=ruleset.xml ${SRC}

.PHONY: lint fix clean
