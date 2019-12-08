#!/bin/bash

docker-compose -f ./docker/docker-compose.yml up -d --build
docker exec -it venkatma_php php composer.phar install
docker exec -it venkatma_mysql mysql -uroot -ppassword -e "$(cat data/sql/init_database.sql)"