<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
    rel="stylesheet">
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>

  <style type="text/tailwindcss">
    @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
    }
  </style>
</head>

<body class="font-roboto">
  <div class="flex min-h-screen">
    <div class="w-1/2 flex flex-col justify-center items-center bg-gray-100">
      <div class="text-center mb-8">
        <span class="text-4xl font-bold">A</span>
        <p class="text-lg">Accede a tu gestión de almacén con facilidad y eficiencia</p>
      </div>
      <img src="assets/trigal-login.png" alt="Login Image" class="max-w-full">
    </div>
    <div class="w-1/2 flex flex-col justify-center items-center">
      <form action="../controllers/loginController.php" method="POST" class="w-3/4">
        <div class="mb-6 text-center">
          <h1 class="text-3xl font-bold">¡Hola de nuevo!</h1>
          <p class="text-lg">Bienvenido</p>
        </div>
        <input type="text" placeholder="Usuario" id="user" name="username" class="w-full p-3 mb-4 border rounded-lg">
        <input type="password" placeholder="Contraseña" id="pass" name="password"
          class="w-full p-3 mb-4 border rounded-lg">
        <div class="flex justify-center">
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" type="submit">INGRESAR</button>
        </div>
      </form>
      <?php
      if (isset($_GET['error']) && $_GET['error'] === 'credenciales') {
        echo "<p class='text-red-500 mt-4'>Las credenciales son incorrectas. Por favor, intenta nuevamente.</p>";
      }
      ?>
    </div>
  </div>
</body>

</html>