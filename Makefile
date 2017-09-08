DEFAULT_GOAL := help

########################################################################################################################
####                                            SET ENVIRONMENT VARIABLES                                           ####
########################################################################################################################
export SERVICE_NAME ?=demoapi
export DOCKER_SERVICES ?=demoapi

export DOMAIN ?=video-games-records.dev
export VOLUME_PREFIX ?= ../../../../..
export SITE_NAME ?=Demoapi Service Core
export PROJECT_NAME ?=dildevelop

export INFRA_ENV ?=demoapi-local
export PHP_ENV ?=php.env
export ENV_NAME ?=.env

export SUFFIX_VS=v3

export LOCALIP := $(shell ip addr show | awk '$$1 == "inet" && $$3 == "brd" { sub (/\/.*/,""); print $$2 }' | head -n1)

export NETWORK_NAME ?=${SERVICE_NAME}_default
export NETWORK_DRIVER ?=overlay
export NETWORK_SUBNET ?=192.16.238.0/24
export LABEL_UCP ?=dev-fr

export SECRET_PATH ?= ./config/docker/${SUFFIX_VS}/secrets

########################################################################################################################
####                                                 COMMAND ALIASES                                                ####
########################################################################################################################
qa-docker       = docker run --rm --user $$(id -u):$$(id -g) --volume $$(pwd):/data/www
compose-file    = --compose-file ./config/docker/${SUFFIX_VS}/${INFRA_ENV}/${SERVICE_NAME}/docker-compose.yml
docker-compose 	= docker-compose -f ${PWD}/config/docker/${SUFFIX_VS}/${INFRA_ENV}/${SERVICE_NAME}/docker-compose.yml -p ${PROJECT_NAME} --project-directory ${PWD}

########################################################################################################################
####                                                      STACK                                                     ####
########################################################################################################################

help:
	@echo "# Type 'make install' to start. Type 'make uninstall' to stop."

reinstall: uninstall install

install: check-composer up

init: init-network
	@mkdir -p data/reports data/documentation data/cache data/log data/database/mysql/dir

init-network:
	@-docker network create --driver=${NETWORK_DRIVER} --attachable --subnet ${NETWORK_SUBNET} --label com.docker.ucp.access.label=${LABEL_UCP} --label com.docker.stack.namespace=${SERVICE_NAME} ${NETWORK_NAME}

uninstall:
	@for service in ${DOCKER_SERVICES} ; do (docker stack rm $${service}) || true ; done

up: init
	@-cmd/composer install --no-dev
	@for service in $(DOCKER_SERVICES) ; do SERVICE_NAME=$${service} && docker stack deploy ${compose-file} $${service} ; done


#----------------------------------------------------------------------------------------------------------------------#
#                                                   COMPOSER COMMAND                                                   #
#----------------------------------------------------------------------------------------------------------------------#

check-composer:
	@if [ $(date -d 'now - 3 weeks' '+%s') -gt $(date -r www/composer.lock '+%s') ]; then echo 'WARNING! You did not update your composer dependencies since a long time ago. You should update.'; fi

#----------------------------------------------------------------------------------------------------------------------#
#                                                      ANALYTICS                                                       #
#----------------------------------------------------------------------------------------------------------------------#
phplint:
	@cmd/phplint

phpunit:
	@-cmd/phpunit

# Run the phpmetrics tool.
phpmetrics:
	@cmd/phpmetrics

# Run the PHP Code Sniffer tool.
phpcs:
	@cmd/phpcs

# Run the phpcbf tool that fixes PHP Code Sniffer errors.
phpcbf:
	@cmd/phpcbf

# Run the php copy/paste detector tool.
phpcpd:
	@cmd/phpcpd

# Run the pdepend tool.
pdepend:
	@cmd/pdepend

# Run the dashboard creator.
dashboard:
	@cmd/dashboard


########################################################################################################################
####                                           CONCATENATION OF COMMANDS                                            ####
########################################################################################################################
compose:
	@${docker-compose} ${CMD}

php:
	${docker-compose} run --rm php-cmd ${CMD}
