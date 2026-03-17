#!/bin/bash

if [ -f .env ]; then
    # Export variables from .env file
    set -a
    . ./.env
    set +a
fi

# Use DB_DUMP_PATH from .env, with a default of ~/db-dump
# The 'eval' is used to expand the '~' if it exists in the path
DUMP_PATH=$(eval echo "${DB_DUMP_PATH:-~/db-dump}")

case "$1" in
    run)
        shift
        docker compose --file=$COMPOSE_FILE run --rm cli "$@"
        ;;

    cli)
        shift
        docker compose -p shopper-cli --file=cli.compose.yaml run --rm cli "$@"
        ;;

    setup)
        ./app.sh cli composer setup
        ;;

    sdb)
        ./app.sh run php artisan migrate --force
        ;;

    cp)
        ./app.sh cli vendor/bin/pint --test
        ;;

    cr)
        ./app.sh cli vendor/bin/rector process --dry-run
        ;;

    cps)
        ./app.sh cli vendor/bin/phpstan analyse --no-progress
        ;;

    ct)
        ./app.sh cli vendor/bin/pest tests/Unit --testdox
        ./app.sh run vendor/bin/pest tests/Feature --testdox
        ;;
    c)
        ./app.sh cp
        ./app.sh cr
        ./app.sh cps
        ./app.sh ct
        ;;

    mysqldump)
        # Create the directory if it doesn't exist
        mkdir -p "$DUMP_PATH"

        DB_NAME=$(docker compose exec mysql sh -c 'echo "$MYSQL_DATABASE"')
        echo "Dumping database '$DB_NAME' to $DUMP_PATH..."
        docker compose exec mysql sh -c 'exec mysqldump $MYSQL_DATABASE -uroot -p"$MYSQL_ROOT_PASSWORD"' | gzip > "$DUMP_PATH"/"$DB_NAME"-$(date +%Y_%m_%d_%H_%M_%S)-dump.sql.gz
        echo "Database dump complete."
        ;;

    mysqlrestore)
        DB_NAME=$(docker compose exec mysql sh -c 'echo "$MYSQL_DATABASE"')

        # Find the latest dump file for the current database
        LATEST_DUMP=$(ls -t "$DUMP_PATH"/"$DB_NAME"-*.sql.gz 2>/dev/null | head -n 1)

        if [ -z "$LATEST_DUMP" ]; then
            echo "No database dump found for '$DB_NAME' in $DUMP_PATH"
            exit 1
        fi

        echo "Restoring database from $LATEST_DUMP..."
        gunzip < "$LATEST_DUMP" | docker compose exec -T mysql sh -c 'mysql $MYSQL_DATABASE -uroot -p"$MYSQL_ROOT_PASSWORD"'
        echo "Database restore complete."
        ;;

    *)
        docker compose --file=$COMPOSE_FILE exec app php artisan "$@"
        ;;
esac


# todo implement: some command like - sail php -d xdebug.mode=off vendor/bin/rector process
