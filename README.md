# TP_php
Mini tp en php 

# Documentation du projet Senskritok

## 1. Présentation

Senskritok est une API développée avec PHP et Symfony permettant de gérer des films.

Chaque film possède :
- Un titre (`title`)
- Une description (`description`)
- Une année de sortie (`year`)
- Des catégories (`categories`)

Le projet utilise Doctrine ORM pour gérer la base de données et le Serializer de Symfony pour gérer les échanges JSON.

## 2. Environnement utilisé

- PHP 8.4.27
- Symfony 8.1.10
- Composer 2.11.1
- Symfony CLI 5.22.2
- Visual Studio Code

## 3. Installation et lancement

Ouvrir le terminal dans le dossier du projet, puis exécuter :

```powershell
composer install
```

Cette commande installe les dépendances du projet.

Démarrer ensuite le serveur Symfony :

```powershell
symfony serve
```

L'API est accessible à l'adresse :

http://127.0.0.1:8000

## 4. Organisation du projet

Les principaux fichiers et dossiers sont :

- `src/Entity/` : contient les entités `Movie` et `Category`.
- `src/Repository/` : permet d'effectuer des recherches en base de données.
- `src/Controller/MoviesController.php` : contient les routes de l'API.
- `src/Model/` : contient les modèles de données utilisés dans le projet.
- `movies.http` : contient les requêtes permettant de tester l'API.

## 5. Fonctionnalités : CRUD des films

Le CRUD comprend quatre opérations :

| Opération | Méthode HTTP | Route |
|---|---|---|
| Créer un film | POST | `/movies` |
| Consulter les films | GET | `/movies` |
| Modifier un film | PUT | `/movies/{id}` |
| Supprimer un film | DELETE | `/movies/{id}` |

Les films sont enregistrés et manipulés en base de données grâce à Doctrine.

## 6. Tester l'API

Les tests se trouvent dans le fichier `movies.http`.

Dans Visual Studio Code, ouvrir ce fichier et cliquer sur **Send Request** au-dessus de la requête à tester.

### Créer un film

```http
POST http://127.0.0.1:8000/movies
Content-Type: application/json

{
    "title": "The Matrix",
    "description": "A computer hacker discovers the truth about reality.",
    "year": 1999
}
```

### Consulter les films

```http
GET http://127.0.0.1:8000/movies
```

### Modifier un film

```http
PUT http://127.0.0.1:8000/movies/4
Content-Type: application/json

{
    "title": "Inception - Updated",
    "description": "Updated description.",
    "year": 2011
}
```

### Supprimer un film

```http
DELETE http://127.0.0.1:8000/movies/4
```

**Attention :** remplacer `4` par l'identifiant réel du film à modifier ou supprimer. Vérifier son existence avant d'envoyer la requête.

## 7. Conclusion

Le projet permet actuellement de créer, consulter, modifier et supprimer des films à travers une API Symfony. Les quatre opérations du CRUD ont été testées avec le fichier `movies.http`.composer install
