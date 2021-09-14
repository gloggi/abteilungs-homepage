# Gloggi Abteilungs-Homepage

## Running locally

1. Clone the git repository

    ```git clone https://github.com/gloggi/abteilungs-homepage.git```

2. Go into the created directory

    ```cd abteilungs-homepage```

3. Start the docker containers

    ```docker-compose up```

4. Once the containers have started, access the site at `https://localhost`

You can log in with user 'admin@gloggi.ch' and password 'admin'.


## Installing on a hoster

TODO

## Creating a database change

In order to modify the initial state and structure of the database, we use migrations. Migrations are SQL files in the db/migrations directory. The easiest way to create a migration is to perform your changes in the Directus admin interface and then run `docker-compose run --entrypoint create migrations`. This will create a new migration file that contains all changes exist in your database when comparing to a fresh database that was just set up using all existing migrations.

Alternatively, you can run `docker-compose exec migrations new` to create an empty migration, or copy and edit an old migration.
