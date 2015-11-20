# MajoraRestClient

## Description

comming soon

## TODO
    - ROUTE
        - fetcher guzzle (via url) :
            - prendre en compte l'appel d'un xml
            - prendre en compte l'appel d'un html
        - fetcher via file :
            - prendre en compte yaml
            - prendre en compte xml
            - prendre en compte html
        - RouteConfigBuilder :
          - convertir une url traditionnelle en schema RouteConfig
        - Definir le schema routeConfig

    - MAP
        - MapFileBuilder:
            - gérer l'ajout d'une route en yml et xml
            - gérer l'update d'une route en yml et xml
            - gérer la suppression d'une route en yml et xml
        - Créer le XmlMapFileFetcher
        - Créer une commande pour générer les routes
        - Ajouter le schema d'un objet dans le mapping

    - REST
        - gérer l'hydratation de l'objet lors de la réception de données
        - gérer chaque cas de figure