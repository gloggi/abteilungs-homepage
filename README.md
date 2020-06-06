# Gloggi Abteilungs-Homepage

## Running locally

1. Clone the git repository

    ```git clone https://github.com/gloggi/abteilungs-homepage.git```

2. Go into the created directory

    ```cd abteilungs-homepage```

3. Start the docker containers

    ```docker-compose up```

4. Once the containers have started, access the site at `localhost:8080`

You can log in with user 'admin@gloggi.ch' and password 'admin'.


## Installing on a hoster

TODO

## Creating a database change

In order to modify the initial state and structure of the database, we use migrations. Migrations are SQL files in the db/migrations directory. You can run `docker-compose exec migrations new` or copy an old migration. Then fill it in by hand, or if you don't know what changes to make in SQL, you can make the changes in the Directus admin interface, then run `docker-compose exec migrations dump` and see the generated (structure) changes in db/schema.sql (`git diff HEAD db/schema.sql`).
