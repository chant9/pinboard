## Welcome to my Pinboard.in scraping project

Built with a Laravel backend and Vue.js frontend.

Please follow the instructions below to setup the site.

### Installation

In your local development environment, clone the repository by running the git command below:

```
git clone https://github.com/chant9/pinboard.git
```

## Installation

Please run all the commands below from the project root directory.

### Installing Laravel

Run the composer command below.

```
composer install
```

If an error occurs with the composer install, you may need to run the command below.

```
composer install --ignore-platform-reqs
```

### Setting up the environment file

Copy of the example .env file to be the .env file used with the command below.

```
mv .env.example .env
```

The example environment file may need modifying for your database details, it will be setup with the standard details below.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pinboard
DB_USERNAME=root
DB_PASSWORD=
```

### Installing Vue.js

Run the npm command below.

```
npm install
```

If an error occurs with the npm install, you may need to run the command below.

```
npm install --legacy-peer-deps
```

You can then compile the application by running the command below.

```
npm run build
```

### Setting up the database

Run the php artisan command below, if there is an error connecting to the database, please verify the details in the environment file.

```
php artisan migrate
```

### Running the site server

Run the php artisan command below to start the site, and it should output the site URL. The site URL will likely be http://127.0.0.1:8000/

```
php artisan serve
```

## Setting up the site

To scrap the articles from pinboard.in, run the command below. This command uses the RoachPHP web scraping toolkit to pull the articles and save them into the database, along with the topic tags. 

```
php artisan app:scrap-pinboard
```

Running the command below should give confirmation that it is scrapping articles and how many were created once it is complete.

![ScreenShot](/resources/screenshots/command-scraping-1.png)

The command can be run again at any time, and any new articles will be created, and existing articles will be skipped, based on matching the existing article URLs. 

![ScreenShot](/resources/screenshots/command-scraping-2.png)

When the articles are created, the URLs are checked to confirm the links are still available, and the additional command below has also been created to re-check the link availabilites. This command checks 10 articles each time, selecting the oldest first, and is currently setup to run with the Laravel schedule, once per day. 

```
php artisan app:scrap-pinboard
```

The command below can be run to see when the scheduled command are next due to run (however a CRON would need to be configured for the 'schedule:run' artisan command to be processed).

![ScreenShot](/resources/screenshots/command-schedule.png)

## Using the site

Once the articles have been created in the database, you can visit the homepage to see the Vue.js frontend, that uses Laravel API endpoints to pull JSON data into the page.

The frontend has been styled with Tailwind CSS, and should look like the screenshots below. The articles are shown in two columns on desktop, and stack into a single column on mobile screen sizes.

The articles can be filtered by clicking the tags in the top right corner.

![ScreenShot](/resources/screenshots/articles-1.png)

Below shows an example where multiple tags have been selected, and only articles that contain all the selected tags are displayed.

![ScreenShot](/resources/screenshots/articles-2.png)
