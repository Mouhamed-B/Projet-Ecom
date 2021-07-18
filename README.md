Description

Quelques fonctionnalites souhaitées manquantes (notes,commentaires,suivi commande et livraison,statistiques)

Nom du site : LePapyrus

Contenu : Produits d’une papeterie

PHP version 7.4.1

MySQL Server version 8.0.18

Codé avec le Framework Bootstrap(v4.4.1 dependant de jQuery et Popper.js v.1.16.0) et du javascript avec jQuery v3.4.1

Integration du pack d’icones FontAwesome et de favicons et logo crées a cet effet

Code basé sur 3 pages templates bootstrap:
-https://blackrockdigital.github.io/startbootstrap-shop-homepage/
-https://blackrockdigital.github.io/startbootstrap-shop-item/
-https://getbootstrap.com/docs/4.4/examples/checkout/

Le panier repose sur des cookies.(LE Panier disparait a la suppression des donnees de navigation)


user(iduser, email,password,create_time,nom,prenom,telephone,sexe,datenaiss)\
agent(idAgent, nom, prenom, adresse, tel, sexe, dateNaiss)\
category(idcat,libellecat)\
client(idClient,addresse,#iduser)\
produit(idProduit,#idcat,libelle,prix,stock,img,caract)\
commande(idCommande,#idClient,dateCommande,#idAgent)\
lignecommande(idLigneCommande,#idCommande,#idProduit,quantite)\


