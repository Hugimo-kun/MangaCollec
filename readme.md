Pour commencer pensez à faire votre .env.local et de le configurer afin de créer une base de données.

Pour vous connectez voici les identifiants après avoir charger les fixtures :
admin :

- email: admin@mangacollec.com
- password: admin1234

  user:

- email: user@mangacollec.com
- password: imbatman

Sinon vous pouvez toujours créez un nouvel utilisateur via le bouton d'inscription.

Il faudra activer le docker mailtrap ainsi que de rentrer la commande "php bin/console messenger:consume async -vv" dans la console pour pouvoir récuperer les emails qui vont être envoyer.

Il y a donc plusieurs façons de recevoir un email, déja l'admin peut recevoir des emails quand un utilisateur souhaite que le site rajoute un manga, il y a un bouton dans l'email. Aussi l'utilisateur peut recevoir un email lors de son inscription et à son inscription au newsletter.

L'admin peut ajouter/supprimer/modifier un manga quand il est connecté via l'url "/admin".

Un utilisateur peut ajouter/enlever un volume d'un manga à sa collection (personnelle) et aussi dire si il l'a lu ou non lorsqu'il va sur un manga en particulier.

PS : Il y a un message flash quand on essaye de s'inscrire avec un email qui est déja inscrit.
