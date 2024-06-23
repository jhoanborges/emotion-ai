# Emotion AI

**Description**:  Emotion-AI is an educative project that uses Open AI API and facebook socialite controller to read all post, images and then give you an insights of potentially things that a social network can sell to you.
Other things to include:

  - **Technology stack**: We use laravel, because Laravel rocks!!!.

  - **Links to production or demo instances**
  - Try it now live https://emotion-ai.hexagun.mx


**Screenshot**: 

![image](https://github.com/jhoanborges/emotion-ai/assets/32471957/e5bfba93-6849-472b-ba93-74eacb72df29)
![image](https://github.com/jhoanborges/emotion-ai/assets/32471957/522d0f21-da5a-4e40-918a-bff4d383c0e7)

## Dependencies

Laravel 11
PHP 8.3
openai-php/laravel library

## Installation

Make sure Docker is installed in your machine.
Execute 
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
then 
```
sail up -d
sail composer update
sail artisan key:generator
sail artisan migrate
```
No docker?

Install composer in your machine.
Then run 
```
composer update
php artisan migrate
php artisan key:generate
php artisan serve 
```

Don't forget to put your .env file. We provided a .env example

## Configuration

Set your CHATGPT_API_KEY key in your .env  https://platform.openai.com/settings/organization/billing/overview

FB_CLIENT_ID and FB_CLIENT_SECRET are set in the .env.example for academic purposes.

## Usage

Log in with Facebook and magic starts

## Getting involved

This section should detail why people should get involved and describe key areas you are
currently focusing on; e.g., trying to get feedback on features, fixing certain bugs, building
important pieces, etc.

General instructions on _how_ to contribute should be stated with a link to [CONTRIBUTING](CONTRIBUTING.md).

----

## Open source licensing info
1. [TERMS](TERMS.md)
2. [LICENSE](LICENSE)
3. [CFPB Source Code Policy](https://github.com/cfpb/source-code-policy/)
