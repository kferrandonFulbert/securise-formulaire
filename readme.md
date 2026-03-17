# TP Cybersécurité -- Analyse et Sécurisation d'un Formulaire Web

## Objectif du TP

Dans ce TP, vous allez analyser un système d'inscription à un service
musical en ligne.\
Deux sites sont fournis :

-   **Le site officiel** : formulaire d'inscription normal.
-   **Le site pirate** : copie du formulaire qui intercepte les mots de
    passe en clair avant de transmettre les données au site officiel.

L'objectif est de : 1. Comprendre comment une attaque peut fonctionner.
2. Identifier des failles de sécurité. 3. Corriger ces failles. 4.
Mettre en place plusieurs mécanismes de protection.

------------------------------------------------------------------------

# 1 -- Lancer les deux sites

Le TP contient deux dossiers :

-   `site_officiel`
-   `site_pirate`

## Lancer le site officiel

Dans un terminal, placez-vous dans le dossier du site officiel puis
lancez :

``` bash
php -S localhost:83
```

Le site sera accessible à l'adresse :

    http://localhost:83

## Lancer le site pirate

Dans un second terminal, placez-vous dans le dossier du site pirate puis
lancez :

``` bash
php -S localhost:84
```

Le site sera accessible à l'adresse :

    http://localhost:84

------------------------------------------------------------------------

# 2 -- Tester les formulaires

## Étape 1

1.  Ouvrez les deux sites dans votre navigateur :

    -   http://localhost:83 (site officiel)
    -   http://localhost:84 (site pirate)

2.  Testez les deux formulaires d'inscription.

3.  Comparez leur fonctionnement.

## Étape 2

Observez :

-   le **code HTML du formulaire**
-   le **code PHP**
-   la **base de données**

Questions :

-   Le site pirate ressemble-t-il au site officiel ?
-   Que fait réellement le site pirate avec les données ?
-   Comment les mots de passe sont-ils stockés ?
-   Les mots de passe sont-ils chiffrés ?

------------------------------------------------------------------------

# 3 -- Test d'injection de code (XSS)

Essayez d'entrer du **code HTML ou JavaScript** dans les champs du
formulaire.

Exemples :

``` html
<script>alert("XSS")</script>
```

ou

``` html
<b>Test</b>
```

## À faire

1.  Tester l'injection sur :
    -   le site officiel
    -   le site pirate
2.  Observer le résultat.

## Correction

Corrigez la faille dans le formulaire officiel en utilisant par exemple
:

-   `htmlspecialchars()`
-   validation des entrées utilisateur

Exemple :

``` php
htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
```

### Objectif

Empêcher l'exécution de code injecté par un utilisateur.

------------------------------------------------------------------------

# 4 -- Sécuriser l'origine du formulaire

Actuellement, le site officiel accepte des inscriptions provenant de
**n'importe quel site**.

Le site pirate exploite ce problème.

## Étape 1 : Vérifier le Referer

Dans le traitement PHP du formulaire, vérifiez que la requête provient
bien du site officiel.

Exemple :

``` php
if(strpos($_SERVER['HTTP_REFERER'], "localhost:83") === false){
    die("Requête refusée");
}
```

### Intérêt

Empêcher qu'un autre site envoie des données vers le formulaire.

------------------------------------------------------------------------

# 5 -- Ajouter un Token CSRF

Ajoutez un **token de session caché dans le formulaire**.

## Génération du token

Dans le PHP du site officiel :

``` php
$_SESSION['token'] = bin2hex(random_bytes(32));
```

## Ajout dans le formulaire

``` html
<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
```

## Vérification lors du traitement

``` php
if($_POST['token'] !== $_SESSION['token']){
    die("Token invalide");
}
```

### Intérêt

Ce mécanisme protège contre les attaques **CSRF (Cross-Site Request
Forgery)**.\
Un site externe ne peut pas envoyer de formulaire valide sans connaître
ce token.

------------------------------------------------------------------------

# 6 -- Ajouter un CAPTCHA

Pour éviter les inscriptions automatiques par des robots.

## Principe

Un CAPTCHA permet de vérifier que l'utilisateur est **un humain et non
un script automatisé**.

Exemples de solutions :

-   CAPTCHA simple (calcul mathématique)
-   Google reCAPTCHA
-   image avec texte à recopier

### Exemple simple

Afficher une question :

    Combien font 3 + 4 ?

Vérifier la réponse côté serveur.

### Intérêt

-   Éviter le spam
-   Empêcher la création massive de comptes
-   Limiter les attaques automatisées

------------------------------------------------------------------------

# 7 -- Questions finales

1.  Pourquoi stocker un mot de passe en clair est dangereux ?
2.  Quelle fonction PHP permet de **hasher** un mot de passe ?
3.  À quoi sert un **token CSRF** ?
4.  Pourquoi vérifier le **Referer** peut améliorer la sécurité ?
5.  Quel est le rôle d'un **CAPTCHA** ?

------------------------------------------------------------------------

# Conclusion

Dans ce TP, vous avez :

-   analysé une attaque de **phishing**
-   identifié des failles web
-   corrigé une **faille XSS**
-   ajouté une **protection CSRF**
-   sécurisé l'origine du formulaire
-   ajouté un **CAPTCHA anti‑spam**

Ces mécanismes sont essentiels pour sécuriser les applications web
modernes.
