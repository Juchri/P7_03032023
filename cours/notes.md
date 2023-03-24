# BileMo
## P7_03032023

- consulter la liste des produits BileMo ;
- consulter les détails d’un produit BileMo ;
- consulter la liste des utilisateurs inscrits liés à un client sur le site web ;
- consulter le détail d’un utilisateur inscrit lié à un client ;
- ajouter un nouvel utilisateur lié à un client ;
- supprimer un utilisateur ajouté par un client.

- authentifications via OAuth ou JWT

⚠️ niveaux 1, 2 et 3 du modèle de Richardson
 réponses mises en cache


 Quels endpoints ?
- POST/ phone (auth)
- PUT/ phone (auth)
- GET/ phone

- POST /phone/brands/{phoneId}

- GET/ clients /
- PUT/ clients (auth)
- POST/ clients (auth)
- DELETE/ clients


- GET/ clients/ users
- PUT/ clients/ users (auth)
- DELETE/ clients/ users (auth)

+ endpoints avec ordre : GET /users/{userId}/followers?sort=lastName&order=asc
+ filtres : GET /photos?location={locationId}

+ L’approche la plus courante est d’ajouter un /v1 au début de votre URI :


Quelles ressources ?
 - Téléphone
 - Utilisateur
 - Clients

 API publique ou privée ?

 De quelles ressources avez-vous besoin pour y effectuer les opérations CRUD ?
Avez-vous besoin des quatre opérations CRUD pour chaque ressource ? Ou seulement d’une ou deux ?

 Documentation avec réponses et exemples : (ex: l’API de Stripe  https://stripe.com/docs/api )

    1. Les descriptions des ressources API.

    2. Les URI et verbes HTTP disponibles ainsi que leur fonction.

    3. Les paramètres (s’il y en a) qui doivent être donnés à l’endpoint.

    4. Un exemple de requête.

    5. Une réponse typique pour la requête donnée.

 + identitifer les erreurs

https://www.meetup.com/api/general/ 

announce_error : Erreur dans l’annonce d’un événement

description_error : Désolé, votre description Meetup est trop longue

duration_error : La durée de cet événement n’est pas valide.

event_error : L’ID fourni ne correspond pas à un évènement pouvant être modifié

event_hosts_error : Un ou plusieurs des membres donnés ne sont pas des membres actifs de ce groupe

featured_photo_id_error : Il y a un problème avec la photo fournie.

fee.amount_error : Si le groupe se trouve aux États-Unis, le montant à acquitter ne peut pas excéder 4999. Sinon, il ne peut pas excéder 1 000 000.

fee.refund_policy_error : La politique de remboursement de fonds ne peut pas excéder 250.

guest_limit_error : Le nombre d’invités maximum n’est pas valide.

how_to_find_us_error : Votre description « Comment nous retrouver » est trop longue.


Requête CURL : 

`$ curl 127.0.0.1\ -H "Accept: application/json"\ -X POST\ -u myuser:pass\ --data
 '{"message":"hello"}'`


Vendredi 17 mars : 
- https://dbdiagram.io/d/64146104296d97641d88c59c : diagramme de classes pour déffricher un peu

---- 

Poster une brand : 

http://127.0.0.1:8000/api/brands : POST
{
    "name": "Apple",
    "idBrand": "1"
}

Poster un mobile :

http://127.0.0.1:8000/api/mobiles : POST
{
    "model": "Iphone",
    "idBrand": "1"
}


Vendredi 24 mars :
HASHER Le mot de passe et continuer le cours
Récupérer le mot de passe, le hasher, puis utiliser une méthode pour comparer (pas de if, pas de ==, juste la méthode qui compare les mots de passe)
Envoi mot de passe / Distribution de token (JWT) / Compare avec l'existent / Valide