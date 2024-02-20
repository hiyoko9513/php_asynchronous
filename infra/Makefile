up-build:
	docker-compose up -d --build
up:
	docker-compose up -d
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
down:
	docker-compose down
restart:
	@make down
	@make up

# oapi
docker/oapi/%/gen:
	docker run --rm -v $(PWD)/$(WORK_DIR)/docs/oas/$*:/spec redocly/cli:latest bundle root.yml -o root.gen.yml
docker/oapi/%/mock:
	make docker/oapi/$*/gen &&\
	docker run --rm -it -p 4011:4010 -v $(PWD)/$(WORK_DIR)/docs/oas/$*:/spec stoplight/prism:4 mock -h 0.0.0.0 /spec/root.gen.yml
docker/oapi/%/validate: # バージョン管理していないので将来バグが出そう
	make docker/oapi/$*/gen &&\
	docker run --rm -v $(PWD)/$(WORK_DIR)/docs/oas/$*:/spec openapitools/openapi-generator-cli validate -i /spec/root.gen.yml
docker/oapi/%/ui:
	make docker/oapi/$*/gen &&\
	docker run -p 8081:8080 -v $(PWD)/$(WORK_DIR)/docs/oas/$*:/usr/share/nginx/html/$* -e API_URL=$*/root.gen.yml swaggerapi/swagger-ui
docker/oapi/%/php/codegen:
	make docker/oapi/$*/gen &&\
	docker run --rm -v $(PWD)/$(WORK_DIR):/spec openapitools/openapi-generator-cli generate -i /spec/docs/oas/$*/root.gen.yml -g php-laravel -o /spec/$* -c /spec/docs/oas/$*/php-gen-config.json
docker/oapi/%/typescript/codegen:
	make docker/oapi/$*/gen &&\
	docker run --rm -v $(PWD)/$(WORK_DIR):/spec openapitools/openapi-generator-cli generate -i /spec/docs/oas/$*/root.gen.yml -g typescript-axios -o /spec/app -c /spec/docs/oas/$*/typescript-axios-gen-config.json

# php-laravel
docker/create/laravel:
	docker-compose run --rm php composer create-project laravel/laravel api --prefer-dist

# git
git/commit-template:
	cd ../ &&\
	cp ./.github/.gitmessage.txt.example ./.github/.gitmessage.txt &&\
    git config commit.template ./.github/.gitmessage.txt &&\
    git config --add commit.cleanup strip
