# Zoomer (SAE 3.01)
## Auteur :
Belleterre Noa, Chafei Najib, Descoutures Jules, Oudin Dorian
## Installation / Configuration
### Installation par `Composer`

Lancer `composer install` pour installer [PHP Coding Standards Fixer](https://cs.symfony.com/) et le configurer dans PhpStorm (le fichier `.php-cs-fixer.php` contient les règles personnalisées basées sur la recommandation [Symfony](https://symfony.com/doc/current/contributing/code/standards.html))

## Serveur Web local


Lancez le serveur Web local avec cette commande :
```bash
symfony serve
```

### Accès au serveur Web
Naviguez alors à partir de cette adresse : <http://localhost:8000/>

### Scripts disponible

Différent scripts composer sont utilisable au sein du projet:

`start` : Pour lancer le serveur Web sur Linux   
`fix:cs` : Pour fixer le code PHP au normes de PHP CS Fixer  
`test:cs` : Pour tester le code PHP selon les normes de PHP CS Fixer  
`test:codeception` : Ce script initialise la base de données de test avant de lancer les tests  
`test` : Pour executer tout les tests  
`db` : Ce script génère une base de données avec des données factices. Il détruit la base de données, la crée,
applique les migrations puis génère des données factices.

### Base de données

**Nom** : zoomer  
**Version** : mariadb-10.2.25

### Mise en production sur une machine virtuelle 
#### Prérequis 

| Composant | Version |
|-----------|---------|
| PHP       | 8.1     |
| Composer  | 2.6.5   |
| Symfony   | 6.x     |
| Ubuntu    | 22.04   |

### Identifiants
#### Machine virtuelle
- user : user0001
- pass : thispassissafe

#### phpMyAdmin
- user : admin
- pass : thatsanothersqlpass

#### Utilisateurs sur le site
administrateur :
- user : hep@hotmail.com
- pass : test

visiteur :
- user : namassepasmousse@gmail.com
- pass : test