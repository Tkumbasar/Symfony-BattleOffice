# TP BattleOffice

## Résumé:

Vous avez pour mission de créer un système simplifié de E-Commerce en Landing Page, connecté à distance à une API Centrale qui gère les commandes.

Le projet comporte des contraintes que vous devez respecter. Mais aussi des recommandations dont vous pouvez vous passer.

L'objectif principal est de finir le projet dans le temps imparti avec toutes les contraintes requises.

Le projet est à la fois un mini E-Commerce local, mais aussi une landing Page connectée à un E-Commerce décentralisé. Cette pratique courante permet de déléguer la gestion de la commande à un backend externe, afin que seul le paiement et l'envoi de l'email soit géré par le système local.

## 🖊 Contraintes

Vous devez respecter le workflow suivant pour le tunnel de conversion ( = réalisation d'une commande ):

1. Affichage de la page d'accueil
2. Remplissage du formulaire
3. Validation du formulaire et affichage d'erreurs si besoin
4. Enregistrement de la commande en base de données locale
5. Envoi de la commande à l'API Centralisée par requête POST
    - URL : [https://api-commerce.simplon-roanne.com/order](https://api-commerce.simplon-roanne.com/order)
    - URL Documentation : [https://api-commerce.simplon-roanne.com](https://api-commerce.simplon-roanne.com)
6. Redirection sur la page de paiement Stripe/Paypal
7. Succès du paiement
    - En cas d'échec du paiement, redirection sur la page d'accueil avec erreur
8. Envoi du statut de paiement validé à l'API Centralisée par requête POST
    - URL : [https://api-commerce.simplon-roanne.com/order/status](https://api-commerce.simplon-roanne.com/order/status)
9. Envoi de l'email de confirmation
10. Redirection sur la page de confirmation

### Contraintes Fonctionnelles

- Tous les champs de l'adresse de facturation sont requis, à l'exception de "Complément Adr (Adresse ligne 2)".
  - Les champs de l'adresse de livraison deviennent également requis s'ils sont affichés.
  - Des erreurs en rouge doivent inciter le visiteur à remplir les champs.
  - L'adresse de livraison peut différer de l'adresse de facturation.

- Pays autorisés pour la commande : France, Belgique, Luxembourg.

- Le paiement s'effectue avec Stripe ou Paypal.
  - La finalisation d'une commande doit rediriger vers la page de confirmation en cas de succès.
  - Un paiement échoué doit renvoyer à la page d'accueil avec un message d'erreur.

- Un email de confirmation est envoyé en cas de succès de la commande.

### Contraintes Techniques

- Toutes les informations saisies doivent être enregistrées dans une base de données locales.
  - La commande, l'adresse de livraison, l'adresse de facturation (si fournie), le client, le produit acheté parmi ceux disponibles, le mode de paiement.

- Les classes de type Form doivent être utilisées au maximum pour gérer la requête, les erreurs de formulaires et l'enregistrement des entités.

- Utilisation du système de fichiers de logs de Symfony pour garder une trace du bon déroulement des commandes, de l'envoi de l'email et de l'envoi vers l'API Centrale.
  - [Logging (Symfony Docs)](https://symfony.com/doc/current/logging.html)

## 📄 Recommandations

- Avant de commencer le projet, établissez une liste exhaustive de tâches pour une meilleure organisation du développement.
  
- Pensez à concevoir votre base de données sous forme de diagramme avant de la créer avec l'outil de création des entités de Symfony en ligne de commandes.

- Pour la gestion de Stripe et Paypal :
  - Tentez l'intégration, mais si elle devient trop complexe, ne perdez pas trop de temps et passez à autre chose.

- Utilisez [HttpClient](https://drive.google.com/file/d/1MmgbD1UfDpK0IdFJpZlGApWa8doPXk4K/view?usp=sharing) pour la communication avec l'API Centrale.

## 🏃 Installation du Projet

1. Installez un nouveau projet Symfony version 7.

2. Copiez les fichiers du projet à partir du dépôt GitLab suivant :
   - [simplon-roanne / venteprivee-nœerf](https://gitlab.com/simplon-roanne/venteprivee-nerf)

## Étapes de Développement

A partir de ces consignes, établissez une liste de tâches en suivant le plus grand niveau de détail possible. Visez une liste de 20 à 30 tâches pour une meilleure gestion du développement.

## Liste des Tâches

1. **Installer le Projet Symfony**
   - Mettre en place un nouveau projet Symfony.

2. **Copier-Coller les Fichiers**
   - Copier-coller le controller, les assets et les templates depuis le dépôt GitLab.

3. **Créer les Entités Symfony**
   - Créer les entités avec la console CLI de Symfony (`make:entity`).
   - Générer les migrations à partir des entités (`make:migration`).
   - Migrer les migrations dans la BDD avec la console CLI (`doctrine:migrations:migrate`).

4. **Créer les Classes de Formulaire Symfony**
   - Créer les classes Types dans le dossier Form, à partir des entités.
   - Intégrer `$form->createView()` dans le controller et le passer au template.

5. **Gestion de la Requête (post-envoi du Formulaire)**
   - Intégrer le code `$form->handleRequest($request)` dans le controller.
   - Utiliser le manager de Doctrine pour persist et flush les entités (Injecter EntityManagerInterface directement dans votre méthode).

6. **Communication à l'API Externe (APICommerce) : Enregistrement de la Commande**
   - Préparer les dépendances, installer et utiliser Guzzle avec Composer.
   - Instancier le Client Guzzle dans le controller ou une classe séparée.
   - Utiliser `$client->request()` pour envoyer une requête POST à l'API Centrale.
   - Configurer le header avec le champ 'Authorization' et la valeur "Bearer XXXXXX" (token de l'API).
   - Ajouter le JSON en tant que payload de la requête.
   - Recevoir les informations de réponse et enregistrer l'ID de commande dans la BDD locale.
   - Rediriger vers la page de paiement avec l'ID de l'Order provenant de l'API.

7. **Gestion du Paiement avec Stripe (et PayPal si le temps le permet)**
   - Intégrer les moyens de paiement Stripe et PayPal avec Payum.
   - Rediriger vers le formulaire en cas d'erreur de paiement.

8. **Communication à l'API Externe (APICommerce) : Mise à Jour du Statut de Commande**
   - Réutiliser le code précédent pour faire une requête similaire.
   - Ajouter le paramètre pour identifier la bonne commande dans l'URL (**/order/{id}/status**).
   - Ajouter la payload pour indiquer le nouveau statut de commande (= PAID).

9. **Envoi de l'Email de Confirmation** du paiement au client avec Symfony, SMTP et MailCatcher
   - Créer un compte sur MailCatcher.
   - Configurer le fichier `.env` avec les paramètres SMTP de MailCatcher.
   - Envoyer le mail avec Symfony Mailer (Swift Mailer).

10. **Redirection vers la Page de Confirmation de Commande**
    - You did it! Hurray!
