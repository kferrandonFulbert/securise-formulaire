<?php
$db = new PDO('sqlite:' . __DIR__ . '/utilisateurs.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$utilisateurs = $db->query("
    SELECT id, prenom, nom, email, telephone, date_naissance, date_inscription
    FROM utilisateurs
    ORDER BY date_inscription DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin — Utilisateurs</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f2f5;
      padding: 2rem;
    }

    h1 {
      color: #2d3436;
      font-size: 1.6rem;
      margin-bottom: 0.4rem;
    }

    .meta {
      color: #888;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9rem;
    }

    thead {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
    }

    th {
      padding: 0.9rem 1rem;
      text-align: left;
      font-weight: 600;
      font-size: 0.82rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    td {
      padding: 0.85rem 1rem;
      color: #444;
      border-bottom: 1px solid #f0f0f0;
    }

    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafbff; }

    .badge {
      display: inline-block;
      padding: 0.2rem 0.6rem;
      background: #eef2ff;
      color: #667eea;
      border-radius: 20px;
      font-size: 0.78rem;
      font-weight: 600;
    }

    .empty {
      text-align: center;
      padding: 3rem;
      color: #aaa;
      font-size: 1rem;
    }

    .btn-back {
      display: inline-block;
      margin-top: 1.2rem;
      padding: 0.55rem 1.2rem;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-size: 0.88rem;
      font-weight: 600;
    }

    .btn-back:hover { opacity: 0.88; }
  </style>
</head>
<body>

  <h1>Utilisateurs inscrits</h1>
  <p class="meta"><?= count($utilisateurs) ?> compte(s) enregistré(s)</p>

  <div class="card">
    <?php if (empty($utilisateurs)): ?>
      <p class="empty">Aucun utilisateur inscrit pour le moment.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date de naissance</th>
            <th>Inscription</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($utilisateurs as $u): ?>
          <tr>
            <td><span class="badge"><?= $u['id'] ?></span></td>
            <td><?= ($u['prenom']) ?></td>
            <td><?= ($u['nom']) ?></td>
            <td><?= ($u['email']) ?></td>
            <td><?= ($u['telephone'] ?? '—') ?></td>
            <td><?= ($u['date_naissance'] ?? '—') ?></td>
            <td><?= ($u['date_inscription']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <a href="index.php" class="btn-back">Retour au formulaire</a>

</body>
</html>
