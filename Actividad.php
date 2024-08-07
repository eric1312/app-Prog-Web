<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Dinámico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            color: #333;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulario de Contacto</h2>
        <?php
        $name = $email = "";
        $nameErr = $emailErr = "";
        $isSubmitted = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $nameErr = "El nombre es requerido";
            } else {
                $name = test_input($_POST["name"]);
            }

            if (empty($_POST["email"])) {
                $emailErr = "El correo electrónico es requerido";
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Formato de correo electrónico inválido";
                }
            }

            if (empty($nameErr) && empty($emailErr)) {
                $isSubmitted = true;
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>

        <?php if ($isSubmitted): ?>
            <p class="success">¡Gracias, <?php echo $name; ?>! Hemos recibido tu información.</p>
        <?php else: ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                    <span class="error"><?php echo $nameErr;?></span>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                    <span class="error"><?php echo $emailErr;?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Enviar">
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
