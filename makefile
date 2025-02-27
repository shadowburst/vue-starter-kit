install_php:
	docker run --rm --interactive --user $$(id -u):$$(id -g) --tty --volume .:/app composer install --ignore-platform-reqs --no-scripts

run:
	./vendor/bin/sail up -d

install_node: run
	./vendor/bin/sail npm ci

install: install_php install_node


