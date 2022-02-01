# Une API en Symfony 5 avec JWT(en cours de prod)


## Prerequis

### Un serveur(le mien j'ai utilisé Apache)

### Une base de donnée(ex: MySQL)

### PHP version 8.0 ou +

### Les conf de base actuel sur la bdd sont les conf pour XAMP ou WAMP

## Commande de lancement

### composer install

### php bin/console doctrine:database:create // Pour creer la base de données Si c'est déjà créer on peut skiper

### php bin/console doctrine:migrations:migrate  // Pour lancer la migration parce que y a déjà les migrations qui sont présents dans dossier migrations

### php -S 127.0.0.1:8000 -t public  // Pour lancer l'application il faut une version de php>=8.0 installer pour que ca marche
## Utilise API Platform


### Ce qu'on peut faire pour le moment

#### Creer, modifier, supprimer voir  un article

#### Creer, modifier, supprimer voir un utilisateur
