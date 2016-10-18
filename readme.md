# Qysqa

Yet another URL-shortener service

[![Build Status](https://travis-ci.org/naffiq/qysqa.svg?branch=master)](https://travis-ci.org/naffiq/qysqa)
[![Code Climate](https://codeclimate.com/github/naffiq/qysqa/badges/gpa.svg)](https://codeclimate.com/github/naffiq/qysqa)

### About

"Qysqa" translates as short from kazakh. This project is
powered with Lumen microframework from Laravel.
  
### Installation

#### Installing dependencies
Clone the repository and install dependencies via [composer](https://getcomposer.org/download) 

```bash
$ composer install
```

#### Setting up database

Configure the app by copying `.env.example` file to `.env` and setup
your database according to [Lumen documentation](https://lumen.laravel.com/docs/5.3/database#configuration)

After that, run migrations with artisan

```bash
$ php artisan migrate
```

#### Running tests

[Install phpunit](https://phpunit.de/) and run tests by this command
```bash
$ phpunit
```