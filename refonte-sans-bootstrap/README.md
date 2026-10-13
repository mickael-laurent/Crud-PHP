# CRUD PHP — refonte sans Bootstrap

Nouvelle version pédagogique du CRUD, écrite en PHP natif avec PDO et du CSS maison. Aucun Bootstrap, aucune bibliothèque JavaScript et aucune dépendance Composer.

## Fonctionnalités

- Authentification avec mots de passe hachés par `password_hash()`
- Sessions renouvelées à la connexion
- CRUD des contacts (création, lecture, modification, suppression)
- Requêtes SQL préparées
- Validation serveur et échappement HTML à l'affichage
- Protection CSRF des formulaires qui modifient des données
- Schéma SQL séparant les comptes des contacts

## Prérequis

PHP 8.1 ou plus récent avec les extensions `pdo_mysql` et `mbstring`, MariaDB et un serveur web local (WampServer convient). Le pilote PHP `pdo_mysql` sert aussi à se connecter à MariaDB : il n'est pas nécessaire d'installer MySQL.

## Installation locale

1. Créer une base de données vide, par exemple `crud_refonte`.
2. Importer `schema.sql` dans cette base avec phpMyAdmin.
3. Ouvrir `config.php` et régler le nom de la base MariaDB, l'utilisateur et le mot de passe.
4. Configurer le serveur web pour que le dossier `refonte-sans-bootstrap` soit la racine du site, ou y accéder par son chemin local.
5. Ouvrir `install.php`. Il permet de créer le premier compte uniquement lorsque la table `users` est vide.
6. Se connecter, puis tester l'ajout, la consultation, la modification et la suppression d'un contact.

## Important

- L'installateur se bloque dès qu'un compte existe. Il n'y a pas de compte ni de mot de passe prédéfini.
- Ne publie pas `config.php` avec des identifiants de production. Utilise un compte MariaDB dédié aux droits limités.
- Cette version est conçue pour un environnement local d'apprentissage. Avant une mise en production, configure HTTPS, les cookies de session, les sauvegardes, la journalisation et les règles de déploiement.
- Les fichiers historiques à la racine du dépôt ne sont pas modifiés. Cette refonte est isolée dans ce dossier.
