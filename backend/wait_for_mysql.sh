#!/bin/bash
set -e

host="$1"
port="$2"
shift 2
cmd="$@"

until mysqladmin ping -h"$host" -P"$port" -u root -p123 --silent; do
    echo "Waiting for MySQL to be ready..."
    sleep 2
done

echo "MySQL is up - executing command"
exec $cmd
