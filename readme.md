# BTS SIO - Injection SQL

## installation

### Création des fichiers environnement

#### Mac et linux

`cp _.env.example .env && cp app/_.env.example app/.env`

### Démarrage des services

`docker compose up -d`

### Installation des librairies composer

`docker exec -it secure-sql-injection-app composer install`


