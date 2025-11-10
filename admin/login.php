<?php
session_start();

// Si ya está logueado, redirigir al panel
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/config/database.php';
    
    $correo = trim($_POST['correo'] ?? '');
    $documento = trim($_POST['documento'] ?? '');
    
    if (empty($correo) || empty($documento)) {
        $error = 'Por favor completa todos los campos';
    } else {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            
            // Consultar usuario por correo y documento
            $stmt = $conn->prepare("
                SELECT u.*, r.rol 
                FROM Usuario u 
                LEFT JOIN Rol r ON u.id_Rol = r.id_Rol 
                WHERE u.correo = ? AND u.documento_identidad = ?
            ");
            $stmt->execute([$correo, $documento]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario) {
                // Login exitoso - guardar datos en sesión
                $_SESSION['usuario_id'] = $usuario['id_Usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_correo'] = $usuario['correo'];
                $_SESSION['usuario_telefono'] = $usuario['telefono'];
                $_SESSION['usuario_rol_id'] = $usuario['id_Rol'];
                $_SESSION['usuario_rol_nombre'] = $usuario['rol'] ?? 'Sin Rol';
                $_SESSION['usuario_estado'] = $usuario['estado'];
                
                header('Location: index.php');
                exit;
            } else {
                $error = 'Credenciales incorrectas';
            }
        } catch (PDOException $e) {
            $error = 'Error de conexión: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - PMI Norte Perú</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* ESTILOS ESPECÍFICOS DEL LOGIN */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #0b2e3a 0%, #2a0c5a 50%, #15062b 100%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(63, 192, 240, 0.15), transparent);
            border-radius: 50%;
            top: -250px;
            left: -250px;
            animation: float 8s ease-in-out infinite;
        }

        .login-container::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 97, 15, 0.1), transparent);
            border-radius: 50%;
            bottom: -200px;
            right: -200px;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        .login-box {
            background: rgba(255, 255, 255, 0.98);
            padding: 50px 45px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo {
            width: 180px;
            margin-bottom: 25px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        .login-header h1 {
            color: #4F17A8;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #4F17A8, #3FC0F0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-header p {
            color: #718096;
            font-size: 1rem;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e6ed;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3FC0F0;
            box-shadow: 0 0 0 4px rgba(63, 192, 240, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .error-message {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 14px 18px;
            border-radius: 10px;
            font-weight: 600;
            text-align: center;
            animation: shake 0.5s ease;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .btn-login {
            padding: 16px;
            background: linear-gradient(135deg, #3FC0F0, #1a6c8c);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(63, 192, 240, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #54d2f5, #1a6c8c);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(63, 192, 240, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .input-icon {
            position: relative;
        }

        .input-icon::before {
            content: '';
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #718096;
        }

        .input-icon input {
            padding-left: 50px;
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 35px 25px;
            }

            .login-header h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="../img/logo/logo_PMI.png" alt="PMI Norte Perú" class="login-logo">
                <h1>Iniciar Sesión</h1>
                <p>Panel de Administración</p>
            </div>

            <?php if ($error): ?>
                <div class="error-message">⚠️ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="login-form">
                <div class="form-group">
                    <label for="correo">📧 Correo Electrónico</label>
                    <input 
                        type="email" 
                        id="correo" 
                        name="correo" 
                        placeholder="ejemplo@pminorteperu.org"
                        required
                        autofocus
                        value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="documento">🆔 Documento de Identidad</label>
                    <input 
                        type="text" 
                        id="documento" 
                        name="documento" 
                        placeholder="12345678"
                        maxlength="50"
                        required
                    >
                </div>

                <button type="submit" class="btn-login">🔐 Acceder</button>
            </form>
        </div>
    </div>
</body>
</html>
