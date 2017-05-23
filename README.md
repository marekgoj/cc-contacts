Application written in Symfony 3. Stack is dockerized. Docker configuration based on https://github.com/maxpou/docker-symfony by Maxence Poutord.

## Installation 

1. Build/run containers with (with and without detached mode)

    ```bash
    $ cd docker
    $ docker-compose build
    $ docker-compose up -d
    ```

2. Prepare Symfony app
    1. Copy app/config/parameters.yml.dist to parameters.yml
    
        ```bash
        $ cp symfony/app/config
        $ cp parameters.yml.dist parameters.yml
        ```
        
    2. Update app/config/parameters.yml

        ```yml
        # path/to/your/symfony-project/app/config/parameters.yml
        parameters:
            database_host: db
        ```

    3. Composer install

        ```bash
        $ docker-compose exec php bash
        $ composer install
        # Symfony2
        $ sf doctrine:database:create
        $ sf doctrine:schema:update --force
        $ sf doctrine:fixtures:load --no-interaction
        # Symfony3
        $ sf3 doctrine:database:create
        $ sf3 doctrine:schema:update --force
        $ sf3 doctrine:fixtures:load --no-interaction
        ```
        
    4. Change var folder attribiutes

        ```bash
        $ cd symfony
        $ sudo chmod -R 777 var/cache var/logs
        ```

## Usage

Just run `docker-compose up -d`, then:

* Symfony app: visit [localhost](http://localhost)  
* Symfony dev mode: visit [localhost/app_dev.php](http://localhost/app_dev.php)  
* Logs (files location): logs/nginx and logs/symfony

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `mongo`: This is the Mongo database container,
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too,

This results in the following running containers:

```bash
$ docker-compose ps
     Name                   Command              State              Ports            
------------------------------------------------------------------------------------
docker_mongo_1   docker-entrypoint.sh mongod     Up      27017/tcp                   
docker_nginx_1   nginx                           Up      443/tcp, 0.0.0.0:80->80/tcp 
docker_php_1     docker-php-entrypoint php-fpm   Up      9000/tcp      
```

## Useful commands

```bash
# bash commands
$ docker-compose exec php bash

# Composer (e.g. composer update)
$ docker-compose exec php composer update

# SF commands (Tips: there is an alias inside php container)
$ docker-compose exec php php /var/www/symfony/app/console cache:clear # Symfony2
$ docker-compose exec php php /var/www/symfony/bin/console cache:clear # Symfony3
# Same command by using alias
$ docker-compose exec php bash
$ sf cache:clear

# Retrieve an IP Address (here for the nginx container)
$ docker inspect --format '{{ .NetworkSettings.Networks.dockersymfony_default.IPAddress }}' $(docker ps -f name=nginx -q)
$ docker inspect $(docker ps -f name=nginx -q) | grep IPAddress

# Mongo commands
$ docker-compose exec db mongo

# Correct cache/logs folder
$ sudo chmod -R 777 app/cache app/logs # Symfony2
$ sudo chmod -R 777 var/cache var/logs # Symfony3

# Check CPU consumption
$ docker stats $(docker inspect -f "{{ .Name }}" $(docker ps -q))

# Delete all containers
$ docker rm $(docker ps -aq)

# Delete all images
$ docker rmi $(docker images -q)
```

## FAQ

* Got this error: `ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?
If it's at a non-standard location, specify the URL with the DOCKER_HOST environment variable.` ?  
Run `docker-compose up -d` instead.

* Permission problem? See [this doc (Setting up Permission)](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup)

* How to config Xdebug?
Xdebug is configured out of the box!
Just config your IDE to connect port `9001` and id key `PHPSTORM` (but it is not working for me).
You can configure PhpStorm in this way:

    1. Run/debug configurations -> PHP Web Application
    
    2. Configure server: Host: localhost, Port: 80, configure path mappings.