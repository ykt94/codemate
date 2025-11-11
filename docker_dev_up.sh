#!/bin/sh

export COMPOSE_DOCKER_CLI_BUILD=1
export DOCKER_BUILDKIT=1

override=$1
if [ $override != "" ]; then
  override="-f $override"
fi

docker compose -f compose.dev.yml $override -p codemate up -d
