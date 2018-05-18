# php-sdk
Example project that covers all aspects of the TCGplayer API. Built with Laravel PHP framework.

Steps to setup locally:
1) Clone project into directory.
2) `npm install` in directory to grab dependencies.
3) Copy .env.example file in base directory into .env, modify the last 4 values to set your API keys.
3) `php artisan migrate` to build out a local product database.
4) `php artisan serve` to run project. This project can be scaffolding, not a lot of routes are defined.
5) In a browser, go to : `127.0.0.1:8000/generateDatabase` if you want to generate a local product database.

Most of the project examples can be found in the services that are built. Each service corresponds to a set of endpoints which can be found in the documentation at: www.docs.tcgplayer.com

These services are located in app/Services. If you are looking for basic code examples on how to connect using GuzzleHttp and don't want to use the whole scaffolding check out these files for examples that work with the API.
