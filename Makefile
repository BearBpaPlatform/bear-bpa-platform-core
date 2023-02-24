hello:
	@echo "hi more information is site http://bear-crm.com/"
phpstan:
	vendor/bin/phpstan analyse app
unittest-run:
	php vendor/bin/codecept run unit
create-unit:
	php vendor/bin/codecept generate:test Unit $(n)
install:
	composer install