down:
	docker-compose -f docker-compose.yml down
up:
	docker-compose -f docker-compose.yml up -d
build:
	docker-compose -f docker-compose.yml build
ps:
	docker-compose -f docker-compose.yml ps