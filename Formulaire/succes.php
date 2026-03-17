<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscription réussie</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background: white;
      border-radius: 16px;
      padding: 3rem 2.5rem;
      max-width: 420px;
      width: 90%;
      text-align: center;
      box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }
    .icon {
      width: 72px; height: 72px;
      background: #2ecc71;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2rem; color: white;
    }
    h1 { color: #2d3436; font-size: 1.7rem; margin-bottom: 0.8rem; }
    p { color: #636e72; line-height: 1.6; margin-bottom: 2rem; }
    a {
      display: inline-block;
      padding: 0.8rem 2rem;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: opacity 0.2s;
    }
    a:hover { opacity: 0.88; }
  </style>
</head>
<body>
  <div class="card">
    <div class="icon">&#10003;</div>
    <h1>Inscription réussie !</h1>
    <p>Votre compte a été créé avec succès.<br>Bienvenue parmi nous !</p>
    <a href="index.php">Retour à l'accueil</a>
  </div>
</body>
</html>
