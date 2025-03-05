<?php
session_start();

if (!isset($_SESSION['feedback'])) {
    $_SESSION['feedback'] = array();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["send"])) {
    $name = htmlspecialchars(trim($_POST["nom"]));
    $email = htmlspecialchars(trim($_POST["mail"]));
    $comment = htmlspecialchars(trim($_POST["commentaire"]));

    $newMessage = array(
        'de' => $name,
        'le' => date('d/m/Y H:i:s'),
        'commentaire' => $comment
    );
    array_unshift($_SESSION['feedback'], $newMessage);

    $_SESSION['feedback'] = array_slice($_SESSION['feedback'], 0, 5);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PHP feedback</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    ::selection {
      background-color: #000;
      color: #fff;
    }

    body {
      height: 100%;
      width: 100%;
      background-color: #000;
      overflow-x: hidden;
    }

    form {
      position: relative;
      font-family: Arial, Helvetica, sans-serif;
      background-color: rgba(255, 247, 0, 0.55);
      backdrop-filter: blur(10px);
      padding: 20px;
      border-radius: 20px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: auto;
      margin-top: 50px;
      width: min(400px, 90vw);
    }

    form input,
    form textarea,
    form button {
      all: unset;
      padding: 10px;
      border-radius: 15px;
      background-color: #1c1c1e;
      color: #ffffff64;
      box-shadow: 0 10px 30px #0005;
      border: 1px solid #71717188;
      transition: background-image 0.5s, opacity 0.5s, border 0.5s;
      width: 100% !important;
      margin-top: 10px;
    }

    form input {
      color: #fff;
      margin: 10px 0;
    }

    form input::selection {
      background-color: #fff;
      color: #000;
    }

    form button {
      cursor: pointer;
      background-color: #fff;
      color: #d8d8d8;
    }

    .or {
      position: relative;
      width: 100%;
    }

    .or::before {
      position: absolute;
      width: 100%;
      height: 1px;
      content: "";
      left: 0;
      top: 45%;
      background-image: linear-gradient(to right,
          #9b9595 0 40%,
          transparent 40% 60%,
          #9b9595 60%);
    }

    form p a {
      border-bottom: 1px solid rgba(254, 10, 10, 0.553);
    }

    form input+p {
      font-size: small;
      text-align: left;
    }

    .sso {
      color: #4d4c4c;
      margin-bottom: 30px;
      transition: 0.4s;
    }

    .text-white {
      color: #ffb1b1;
    }

    .sso:hover {
      color: #9b9595;
    }

    .sso+p {
      font-size: small;
    }

    #SignIn {
      background-color: #afafaf !important;
      color: #1c1c1e;
      max-width: 200px;
      max-height: 20px !important;
      margin: 10px auto;
    }

    form a {
      color: rgba(254, 10, 10, 0.803);
      text-decoration: none;
      transition: color 0.5s;
    }

    #passwordResult {
      font-family: monospace;
      font-weight: 900;
      font-size: 16px;
      text-align: center;
    }

    input#password:placeholder-shown+p {
      display: none;
    }

    .radios {
      display: flex;
      gap: 10px;
      justify-content: center;
      height: 5px;
      margin-bottom: 20px;
      margin: auto;
    }

    .radios input[type="radio"] {
      appearance: none;
      background-color: #1c1c1e;
      border: 1px solid #ffffff64;
      cursor: pointer;
    }

    .radios input[type="radio"]:checked {
      background-color: #ffffff64;
    }

    .radios label {
      color: #fff;
      cursor: pointer;
    }

    #options {
      margin-top: 15px;
    }

    #fileDiv {
      display: none;
    }

    #fileInput {
      width: 340px !important;
      height: 25px !important;
    }

    form .copyright {
      font-size: small;
    }

    #titles {
      text-align: left;
    }

    .message {
      background-color: #1c1c1e;
      color: #fff;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 10px;
      width: 75%;
      margin: 10px auto;
    }
  </style>
</head>

<body>
  <div class="container">
    <form id="loginForm" method="POST" enctype="multipart/form-data">
      <h1>Donnez votre avis sur PHP 8 !</h1>
      <label for="nom">Nom :</label>
      <input type="text" id="nom" name="nom" required />
      <label for="mail">Mail :</label>
      <input type="email" id="mail" name="mail" required />
      <label for="commentaire">Vos commentaires sur le site</label>
      <textarea id="commentaire" name="commentaire" rows="4" required></textarea>
      <button type="submit" id="SignIn" name="send">
        Envoyer
      </button>
    </form>

    <h3>Derniers avis</h3>
    <div id="feedback">
      <?php if (!empty($_SESSION['feedback'])): ?>
        <?php foreach (array_reverse($_SESSION['feedback']) as $message): ?>
          <div class="message">
            <p><strong>de: </strong><?php echo $message['de']; ?></p>
            <p><strong>le: </strong><?php echo $message['le']; ?></p>
            <p><?php echo $message['commentaire']; ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Il n'y a aucun de commentaires.</p>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>