# TicTacToe application for Tech Test

An implementation of TicTacToe using Laravel 11 + Vue (using Inertia).

## Local Testing

This uses Laravel Sail to run locally - you will need to have docker installed.

### Install the dependencies

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### Bring Sail up

Copy `.env.example` to `.env`

```shell
vendor/bin/sail up -d
```

This may take a while the images are built.

### Install NPM dependencies

```shell
vendor/bin/sail npm i
```

### Start Vite

```shell
vendor/bin/sail npm run dev
```

### Access the site

The site should now be available at `localhost`. If this doesn't work 
(or you already have something binding to the default HTTP / Vite ports) then
edit `.env` and add `APP_PORT=1234` (or a number of your choice) and `VITE_PORT=4321`

# Testing notes

Laravel Breeze was used to scaffold the main information. You should be able to register
by clicking the "register" button in the dashboard.

Create an account, then create a game.

Then, in an incognito window, create another account and use the join link from the first.

# Submission notes

Due to time constraints, there are the following limitations:

 - There are no tests. Immediate targets would be `\App\Models\Game::calculateGameState` 
   and the various join / move methods.
 - The design of the site could be improved significantly - my goal was to provide basic
   functionality first
 - Types are manually generated - I would have preferred to generate them automatically but decided this was overkill
 - The data is refreshed via an ajax request every 3s. This isn't the best idea since it requires all the overhead of a
   HTTP request. However, time meant that I didn't want to fight with Pusher over getting an initial submission.
