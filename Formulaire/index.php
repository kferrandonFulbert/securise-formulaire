<?php
$db = new PDO('sqlite:' . __DIR__ . '/utilisateurs.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Création de la table si elle n'existe pas
$db->exec("
    CREATE TABLE IF NOT EXISTS utilisateurs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL,
        prenom TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        mot_de_passe TEXT NOT NULL,
        date_naissance TEXT,
        telephone TEXT,
        date_inscription TEXT DEFAULT (datetime('now', 'localtime'))
    )
");

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom            = ($_POST['nom'] ?? '');
    $prenom         = ($_POST['prenom'] ?? '');
    $email          = ($_POST['email'] ?? '');
    $mot_de_passe   = $_POST['mot_de_passe'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $telephone      = ($_POST['telephone'] ?? '');

    if (!$nom || !$prenom || !$email || !$mot_de_passe) {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            $db->exec("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, date_naissance, telephone)
                VALUES ('$nom', '$prenom', '$email', '$hash', '$date_naissance', '$telephone')"
        );
            header('Location: succes.php');
            exit;
        } catch (PDOException $e) {
            if (str_contains($e->getMessage(), 'UNIQUE')) {
                $erreur = 'Cette adresse email est déjà utilisée.';
            } else {
                $erreur = 'Erreur serveur, veuillez réessayer.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscription</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 2.5rem;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }

    h1 { text-align: center; color: #3d3d3d; font-size: 1.8rem; margin-bottom: 0.4rem; }
    .subtitle { text-align: center; color: #888; font-size: 0.95rem; margin-bottom: 1.5rem; }

    .alert {
      background: #fdecea;
      color: #c0392b;
      border: 1px solid #f5c6cb;
      border-radius: 8px;
      padding: 0.75rem 1rem;
      margin-bottom: 1.2rem;
      font-size: 0.9rem;
    }

    .row { display: flex; gap: 1rem; }
    .row .group { flex: 1; }
    .group { margin-bottom: 1.2rem; }

    label {
      display: block;
      font-size: 0.875rem;
      font-weight: 600;
      color: #555;
      margin-bottom: 0.4rem;
    }

    label .req { color: #e74c3c; margin-left: 2px; }

    input {
      width: 100%;
      padding: 0.7rem 1rem;
      border: 1.5px solid #ddd;
      border-radius: 8px;
      font-size: 0.95rem;
      outline: none;
      color: #333;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    input:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
    }

    input::placeholder { color: #bbb; }

    .hint { font-size: 0.78rem; color: #aaa; margin-top: 0.3rem; }

    .btn {
      width: 100%;
      padding: 0.85rem;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      margin-top: 0.5rem;
      transition: opacity 0.2s, transform 0.1s;
    }

    .btn:hover { opacity: 0.92; transform: translateY(-1px); }
    .btn:active { transform: translateY(0); }

    .divider { height: 1px; background: #eee; margin: 1.5rem 0; }

    .login-link { text-align: center; font-size: 0.9rem; color: #888; }
    .login-link a { color: #667eea; text-decoration: none; font-weight: 600; }
    .login-link a:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="card">
  <h1>Créer un compte</h1>
  <p class="subtitle">Rejoignez-nous dès aujourd'hui</p>

  <?php if ($erreur): ?>
    <div class="alert"><?= ($erreur) ?></div>
  <?php endif; ?>

  <form method="POST" action="">

    <div class="row">
      <div class="group">
        <label for="prenom">Prénom <span class="req">*</span></label>
        <input type="text" id="prenom" name="prenom"
               placeholder="Jean"
               value="<?= ($_POST['prenom'] ?? '') ?>" required />
      </div>
      <div class="group">
        <label for="nom">Nom <span class="req">*</span></label>
        <input type="text" id="nom" name="nom"
               placeholder="Dupont"
               value="<?= ($_POST['nom'] ?? '') ?>" required />
      </div>
    </div>

    <div class="group">
      <label for="email">Adresse email <span class="req">*</span></label>
      <input type="email" id="email" name="email"
             placeholder="jean.dupont@email.com"
             value="<?= ($_POST['email'] ?? '') ?>" required />
    </div>

    <div class="group">
      <label for="telephone">Téléphone</label>
      <input type="tel" id="telephone" name="telephone"
             placeholder="+33 6 00 00 00 00"
             value="<?= ($_POST['telephone'] ?? '') ?>" />
    </div>

    <div class="group">
      <label for="date_naissance">Date de naissance</label>
      <input type="date" id="date_naissance" name="date_naissance"
             value="<?= ($_POST['date_naissance'] ?? '') ?>" />
    </div>

    <div class="group">
      <label for="mot_de_passe">Mot de passe <span class="req">*</span></label>
      <input type="password" id="mot_de_passe" name="mot_de_passe"
             placeholder="••••••••" required />
      <p class="hint">Au moins 8 caractères</p>
    </div>

    <button type="submit" class="btn">S'inscrire</button>

  </form>

  <div class="divider"></div>
  <p class="login-link">Déjà inscrit ? <a href="#">Se connecter</a></p>
</div>
</body>
</html>
