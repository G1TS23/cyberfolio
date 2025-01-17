# Cyberfolio

## Prérequis :

- [Installer PHP](https://www.php.net/manual/en/install.php)
- [Installer Symfony CLI](https://symfony.com/download)
- [Installer Composer](https://getcomposer.org/download/)
- [Installer et paramétrer le Framework Symfony](https://symfony.com/doc/current/setup.html)

## Mise en place du projet :

- Cloner le projet

````
$ cd projets/
$ git clone ...
````

- Faire en sorte que Composer installe les dépendances du projet

````
$ cd cyberfolio/
$ composer install
````

- Exécuter la commande pour mettre à jour les bibliothèques :
```
$ php bin/console importmap:install
```

## Configurer la base de données

- Copier le contenu du fichier .env dans un fichier env.local à la racine du projet
- Mofifier le fichier .env.local avec vos informations de connexion à votre base de données :

<pre>
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://<b>app:!ChangeMe!</b>@127.0.0.1:3306/cyberfolio?serverVersion=8.0.32&charset=utf8mb4"
# DATABASE_URL="mysql://<b>app:!ChangeMe!</b>@127.0.0.1:3306/cyberfolio?serverVersion=10.4.28-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://<b>app:!ChangeMe!</b>@127.0.0.1:5432/cyberfolio?serverVersion=16&charset=utf8"
</pre>

- Créer un fichier .env à la racine du projet et copier le contenu du fichier .env.local

- Créer la base de données :

````
$ php bin/console doctrine:database:create
````

- Créer les tables :

````
$ php bin/console doctrine:database:create
````

## Démarrer le server en local

````
$ symfony serve
````

## Créer un compte administrateur

- Aller à l'url [127.0.0.1:8000/](127.0.0.1:8000/)
- Créer un compte standard avec votre adresse email (ex: mail@domain.com)
- Ensuite dans la console exécuter la commande :

```
$ php bin/console app:promote-user mail@domain.com
```

- Reconnectez-vous avec ce compte
- Vous aurez accès au tableau de bord administrateur

## Accéder au Cyberfolio

- Les Cyberfolio sont accessible en publique à l'addresse :
  - 127.0.0.1:8000/cyberfolio/{user_id}
- Pour l'admin dans la section Utilisateurs
- Pour un utilisateur directement dans la section Cyberfolio

## Compte administrateur

- URL du *back-office* : [127.0.0.1:8000/](127.0.0.1:8000/)
- Identifiant : `test@test.com`
- Mot de passe : `Azertyui`

## État d'avancement

- [x] Création des entités
- [x] Mise en place du CRUD
- [x] Mise en place de l'authentification
- [x] Sécurisation des routes
- [x] Dashboard admin
- [x] Dashboard user
- [x] [Maquette Figma](https://www.figma.com/proto/8TROFXo2sJLoTgsbkxUWxe/Untitled?node-id=32-711&t=GFIveranbQIGQK26-1)
- [x] Front End :
  - [x] Section Projets
  - [ ] Section Infos
  - [ ] Section Contact
- [x] Ajout de l'upload d'image pour le screenshot

## Difficultés rencontrées et solutions

La principale difficulté à été la mise en place de l'authentification et des la sécurisation des routes. Grâce au
support de cours et à la documention Symfony j'ai finalement réussit à tout mettre en place. J'ai aussi du adapter ces
ressources pour distinguer la gestion de l'administration entre l'admin et l'utilisateur.

## Bilan des acquis

- Mise en place d'une MCD
- Création des entités et du CRUD avec Doctrine
- Mise en place de l'authentification et de la sécurisation des routes
- Utilisation des assets et des templates Twig

## Remarques complémentaires

- Exemple de [Cyberfolio](127.0.0.1:8000/cyberfolio/7) après l'importation du fichier `cyberfolio.sql`