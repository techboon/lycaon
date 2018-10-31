default: test

test:
	@vendor/bin/phpunit tests/

cs:
	@vendor/bin/phpcs src/ --standard=phpcs.xml

cbf:
	@vendor/bin/phpcs src/ --standard=phpcs.xml
