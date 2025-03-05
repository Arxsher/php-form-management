<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $fileError = "";
  $fileName = "";
  $fileSize = 0;
  $fileUploaded = false;

  if (isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $fileSizeLimit = 1 * 1024 * 1024;

    if ($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
      $fileError = "File is too large. Maximum allowed size is 1MB.";
    } elseif ($file["size"] > $fileSizeLimit) {
      $fileError = "File is too large. Maximum allowed size is 1MB.";
    } else {
      $fileName = htmlspecialchars($file["name"]);
      $fileSize = $file["size"];
      $fileUploaded = true;
    }
  } else {
    $fileError = "Please upload a file.";
  }

  if (isset($_POST["send"]) && $fileUploaded) {
    $lastName = $firstName = $gender = $cours = "";
    $lastName = htmlspecialchars(trim($_POST["nom"]));
    $firstName = htmlspecialchars(trim($_POST["prenom"]));
    $gender = htmlspecialchars(trim($_POST["sexe"]));
    $cours = htmlspecialchars(trim($_POST["choix"]));

    $nom = $prenom = $sexe = $choix = "";

    if (!empty($lastName)) {
      $nom = "Nom: $lastName";
    }
    if (!empty($firstName)) {
      $prenom = "Prenom: $firstName";
    }
    if (!empty($gender)) {
      $sexe = "Sexe: $gender";
    }
    if (!empty($cours)) {
      $choix = "Choix: $cours";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Password Verification</title>
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
      background-color: rgba(130, 129, 129, 0.553);
      backdrop-filter: blur(10px);
      padding: 50px 20px;
      border-radius: 20px;
      text-align: center;
      display: flex;
      margin: auto;
      margin-block: 50px;
      width: min(400px, 90vw);
      gap: 15px;
      flex-wrap: wrap;
    }

    form input,
    form button,
    form select {
      all: unset;
      padding: 10px;
      border-radius: 15px;
      background-color: #1c1c1e;
      color: #ffffff64;
      box-shadow: 0 10px 30px #0005;
      border: 1px solid #71717188;
      transition: background-image 0.5s, opacity 0.5s, border 0.5s;
      width: 100% !important;
    }

    form input {
      color: #fff;
    }

    form input::selection {
      background-color: #fff;
      color: #000;
    }

    form button {
      cursor: pointer;
    }

    form button[type="submit"] {
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
      margin: auto;
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

  </style>
</head>

<body>
  <div class="container">
    <form id="loginForm" method="POST" enctype="multipart/form-data">
      <div>
        <h1>Hi, Hope you're ready!</h1>
        <p>
          First time here? <span class="text-white">Sign up for free</span>
        </p>
      </div>
      <input type="text" name="nom" placeholder="Your last name" required />
      <input
        type="text"
        id="prenom"
        name="prenom"
        placeholder="Your first name"
        minlength="6"
        required />
      <div class="radios">
        <input type="radio" id="male" name="sexe" value="male" />
        <label for="male">Male</label>
        <input type="radio" id="female" name="sexe" value="female" />
        <label for="female">Female</label>
      </div>
      <select id="options" name="choix">
        <option value="" disabled selected>Select your lesson</option>
        <option value="Simple">Simple</option>
        <option value="Moyen">Moyen</option>
        <option value="Difficult">Difficult</option>
      </select>
      <button type="submit" id="SignIn" name="send" disabled>
        Sign in
      </button>
      <div id="titles">
        <?php if (!empty($nom)) echo "<h4>$nom</h4>"; ?>
        <?php if (!empty($prenom)) echo "<h4>$prenom</h4>"; ?>
        <?php if (!empty($sexe)) echo "<h4>$sexe</h4>"; ?>
        <?php if (!empty($choix)) echo "<h4>$choix</h4>"; ?>
      </div>
      <div class="or">or</div>
      <button
        type="button"
        onclick="toggleFile()"
        id="uploadFileButton">
        Upload your File
      </button>
      <?php if (!empty($fileError)) echo "<p style='color: red;'>$fileError</p>"; ?>
      <div class="file-" id="fileDiv" style="display: none;">
        <p>Upload your ZIP file here:</p>
        <input type="file" id="fileInput" name="file" accept=".zip" />
        <label for="file" id="fileLabel"><?php echo $fileName; ?></label>
      </div>
      <?php if ($fileUploaded): ?>
        <div>
          <h2>Vous avez bien transféré le fichier</h2>
          <p>Le nom du fichier est : <?php echo $fileName; ?></p>
          <p>Votre fichier a une taille de <?php echo $fileSize; ?> octets</p>
        </div>
      <?php endif; ?>
      <p class="copyright">
        You acknowledge that you read, and agree, to our
        <a href="">Terms of Service</a> and our <a href="">Privacy Policy</a>.
      </p>
    </form>

  </div>

  <script>
    function toggleFile() {
      var fileDiv = document.getElementById("fileDiv");
      if (fileDiv.style.display === "none") {
        fileDiv.style.display = "block";
      } else {
        fileDiv.style.display = "none";
      }
    }

    document.getElementById('fileInput').addEventListener('change', function() {
      var signInButton = document.getElementById('SignIn');
      if (this.files.length > 0) {
        signInButton.disabled = false;
      } else {
        signInButton.disabled = true;
      }
    });
  </script>
</body>

</html>