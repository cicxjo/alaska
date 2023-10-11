PHPCS  = phpcs
PHPCBF = phpcbf
SRC    = App

lint:
	${PHPCS} --standard=PSR2 --report=emacs ${SRC}

fix:
	${PHPCBF} --standard=PSR2 ${SRC}

.PHONY: lint fix clean
