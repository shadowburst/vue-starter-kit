install:
	docker run --rm --interactive --user $$(id -u):$$(id -g) --tty --volume .:/app composer install --ignore-platform-reqs --no-scripts
	docker run --rm --interactive --user $$(id -u):$$(id -g) --tty --volume .:/app --workdir /app node:22 npm ci
