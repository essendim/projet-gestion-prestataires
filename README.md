## Tests

### Vérification des Endpoints de l'API

1. **Pré-requis**
   - **Postman ou Insomnia** : Utilisez un outil comme Postman pour tester les requêtes HTTP.
   - **Serveur d'API en cours d'exécution** : Faites en sorteque votre application Symfony est en cours d'exécution, généralement sur `http://localhost:8000` ou `http://127.0.0.1:8000`.

2. **Tester chaque Endpoint**

   #### 1.1. Endpoints pour la gestion des prestataires (ProviderController)

   - **GET /api/providers**
     - **Description** : Récupère la liste de tous les prestataires.
     - **Étapes** :
       1. Ouvrez Postman.
       2. Créez une nouvelle requête GET.
       3. Entrez l'URL : `http://localhost:8000/api/providers`.
       4. Cliquez sur "Send".
     - **Vérifiez** : Un code de statut 200 et la réponse doit contenir une liste de prestataires.

   - **POST /api/providers**
     - **Description** : Crée un nouveau prestataire.
     - **Étapes** :
       1. Sélectionnez la méthode POST.
       2. Entrez l'URL : `http://localhost:8000/api/providers`.
       3. Dans l'onglet "Body", sélectionnez "raw" et choisissez "JSON" comme type.
       4. Ajoutez un JSON valide pour le prestataire, par exemple :
         ```json
         {
             "name": "Prestataire Exemple",
             "email": "exemple@prestataire.com"
         }
         ```
       5. Cliquez sur "Send".
     - **Vérifiez** : Un code de statut 201 et le prestataire créé dans la réponse.

   - **PUT /api/providers/{id}**
     - **Description** : Met à jour un prestataire existant.
     - **Étapes** :
       1. Sélectionnez la méthode PUT.
       2. Remplacez `{id}` par l'ID du prestataire à mettre à jour.
       3. Entrez l'URL : `http://localhost:8000/api/providers/{id}`.
       4. Dans le corps, ajoutez le JSON à mettre à jour.
     - **Vérifiez** : Un code de statut 200 et le prestataire mis à jour dans la réponse.

   - **DELETE /api/providers/{id}**
     - **Description** : Supprime un prestataire.
     - **Étapes** :
       1. Sélectionnez la méthode DELETE.
       2. Remplacez `{id}` par l'ID du prestataire à supprimer.
       3. Entrez l'URL : `http://localhost:8000/api/providers/{id}`.
       4. Cliquez sur "Send".
     - **Vérifiez** : Un code de statut 204.

   #### 1.2. Endpoints pour la gestion des services (ServiceController)

   - **GET /api/services**
     - Suivez les mêmes étapes que pour les prestataires, en remplaçant `providers` par `services`.

   - **POST /api/services**, **PUT /api/services/{id}**, **DELETE /api/services/{id}**
     - Suivez les mêmes étapes que pour les prestataires, en remplaçant `providers` par `services`.

### Tests pour le Cache

1. **Vérification du Cache**
   - Pour tester le cache, vous pouvez suivre ces étapes :
     - Vérifiez que le cache fonctionne :
       1. Effectuez une requête vers un endpoint qui utilise le cache (par exemple, GET /api/providers).
       2. Vérifiez la première réponse et le temps de réponse.
       3. Effectuez la même requête plusieurs fois.
     - **Vérifiez** : Le temps de réponse devrait être plus rapide lors des requêtes suivantes, indiquant que les données sont mises en cache.

2. **Effacement du Cache**
   - Vous pouvez également tester le mécanisme d’effacement du cache :
     - Testez la commande de nettoyage du cache :
       ```bash
       php bin/console cache:clear
       ```
     - Refaites la requête GET pour vérifier que les données mises en cache ont été effacées.

### Tests pour les Notifications

1. **Vérification des Notifications**
   - Si vous utilisez des notifications, assurez-vous que :
     - Les notifications sont envoyées après des actions spécifiques (comme la création d'un prestataire).
     - Testez :
       1. Créez un nouveau prestataire via POST.
       2. Vérifiez si une notification a été émise (vous pouvez vérifier votre système de notifications ou votre base de données).

### Tests pour les Logs

1. **Vérification des Logs**
   - Pour tester la fonctionnalité de journalisation :
     - **Générez un log** :
       1. Effectuez une action qui devrait être enregistrée dans les logs (par exemple, créez ou mettez à jour un prestataire).
     - **Vérifiez les logs** :
       1. Allez dans le répertoire des logs, généralement situé dans `var/log/`.
       2. Ouvrez le fichier de log correspondant à votre environnement (ex: `dev.log` ou `prod.log`).
       3. Assurez-vous que les actions effectuées sont bien enregistrées avec les niveaux de log appropriés (info, erreur, avertissement).
