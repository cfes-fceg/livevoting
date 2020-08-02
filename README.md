# Live Voting

Live Voting is an online voting application designed to be used in the context of meetings where motions and voting are required. 

#### [Staging Server](http://live-voting-staging.herokuapp.com)

## Installation (For Development)
0. Install dependencies (Apache/NginX, MySQL, PHP (7.3+)). Windows users are recommended to use a all-in-one solution like [Laragon](https://laragon.org/). Mac users can install dependencies using `brew`. 
1. Clone the repository locally, make sure to choose a location on your computer keeping in mind that the `public` will be the directory served by your web server.
1. Make a copy of `.env.example` and save it as `.env` in the same directory. Set the `DB_` values to match your local configuration.
1. In the root of the project, run `composer install`
1. Run `composer mfs` (Shortcut for `php artisan migrate:fresh --seed`) to create the database and fill it with sample data. If you don't want the sample data, just run `php artisan migrate:fresh`. Note that no default users are created when you do not seed.
1. `laravel/passport` is used for API authentication. Generate oauth keys for your installation: `php artisan passport:keys`
1. To make debugging locally easier, we use Laravel's `telescope`. Finalize its installation by running `php artisan telescope:publish`
1. Run `npm install` to install the frontend dependencies, and then `npm run dev` to build the front end assets.

**Note:** _You need to rebuild the frontend assets after making modifications in order to see them in your browser. You can do this each time using `npm run dev`, or you can run `npm run watch` which will watch for changes to the front-end source code and trigger a rebuild if needed_
