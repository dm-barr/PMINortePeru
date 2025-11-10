<?php
// login.php - Sistema de Login para PMI Norte Perú
ob_start();
session_start();

// Redirigir si ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'config/Database.php';
use Config\Database;

$error = '';

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($correo) || empty($password)) {
        $error = 'Por favor completa todos los campos';
    } else {
        try {
            $database = new Database();
            $conn = $database->getConnection();
            
            $stmt = $conn->prepare("
                SELECT u.*, r.rol 
                FROM Usuario u 
                LEFT JOIN Rol r ON u.id_Rol = r.id_Rol 
                WHERE u.correo = ?
            ");
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario && password_verify($password, $usuario['contrasena'])) {
                // Login exitoso - establecer sesión
                $_SESSION['usuario_id'] = $usuario['id_Usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_correo'] = $usuario['correo'];
                $_SESSION['usuario_telefono'] = $usuario['telefono'] ?? '';
                $_SESSION['usuario_rol_id'] = $usuario['id_Rol'];
                $_SESSION['usuario_rol_nombre'] = $usuario['rol'] ?? 'Sin Rol';
                $_SESSION['usuario_estado'] = $usuario['estado'] ?? 'activo';
                
                // Limpiar buffer y redirigir
                ob_end_clean();
                header('Location: index.php');
                exit;
            } else {
                $error = 'Credenciales incorrectas';
            }
        } catch (PDOException $e) {
            $error = 'Error de base de datos: ' . $e->getMessage();
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* ========================================
           LOGIN PAGE - DISEÑO PMI NORTE PERÚ
        ======================================== */
        
        :root {
            --color-primary: #4F17A8;
            --color-secondary: #3FC0F0;
            --color-accent: #FF610F;
            --gradient-primary: linear-gradient(45deg, #4F17A8 0%, #2a0c5a 100%);
            --gradient-accent-highlight: linear-gradient(135deg, #FF610F 0%, #4F17A8 100%);
            --color-white: #ffffff;
            --color-text-dark: #040404;
            --color-text-medium: #555555;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.2);
            --transition-base: all 0.3s ease;
            --transition-fast: all 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0B1A24 0%, #0E2531 40%, #0C3442 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(63, 192, 240, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -15%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(79, 23, 168, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1100px;
            width: 90%;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Panel Izquierdo - Branding */
        .login-branding {
            background: var(--gradient-primary);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--color-white);
            position: relative;
            overflow: hidden;
        }

        .login-branding::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(63, 192, 240, 0.2), transparent);
            border-radius: 50%;
        }

        .branding-decoration {
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, rgba(255, 97, 15, 0.15), transparent);
            border-radius: 50%;
        }

        .login-logo {
            margin-bottom: 40px;
            z-index: 1;
        }

        .login-logo img {
            max-width: 180px;
            height: auto;
            filter: brightness(1.2) drop-shadow(0 4px 12px rgba(0, 0, 0, 0.3));
        }

        .login-branding h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(90deg, #FFFFFF, #BFE9F7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            z-index: 1;
        }

        .login-branding p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
            max-width: 350px;
            z-index: 1;
        }

        /* Panel Derecho - Formulario */
        .login-form-wrapper {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--color-white);
        }

        .login-form-box h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--color-primary);
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: var(--color-text-medium);
            margin-bottom: 35px;
            font-size: 1rem;
        }

        /* Alert de Error */
        .alert-error {
            background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
            color: white;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(255, 68, 68, 0.3);
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-error i {
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--color-text-dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-medium);
            font-size: 1.1rem;
            transition: var(--transition-fast);
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Open Sans', sans-serif;
            transition: var(--transition-base);
            background-color: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--color-secondary);
            background-color: var(--color-white);
            box-shadow: 0 0 0 4px rgba(63, 192, 240, 0.1);
            transform: translateY(-2px);
        }

        .form-group input:focus + .input-icon {
            color: var(--color-secondary);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--color-text-medium);
        }

        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--color-primary);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--color-secondary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition-fast);
        }

        .forgot-password:hover {
            color: var(--color-primary);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--gradient-primary);
            color: var(--color-white);
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-base);
            box-shadow: var(--shadow-md);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            background: var(--gradient-accent-highlight);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }

        .login-footer p {
            color: var(--color-text-medium);
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .login-branding {
                padding: 40px 30px;
            }

            .login-branding h1 {
                font-size: 2rem;
            }

            .login-form-wrapper {
                padding: 40px 30px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                width: 95%;
                border-radius: 20px;
            }

            .login-branding {
                padding: 30px 20px;
            }

            .login-logo img {
                max-width: 140px;
            }

            .login-branding h1 {
                font-size: 1.8rem;
            }

            .login-form-wrapper {
                padding: 30px 20px;
            }

            .login-form-box h2 {
                font-size: 1.8rem;
            }

            .form-options {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Panel Izquierdo con Branding -->
        <div class="login-branding">
            <div class="login-logo">
                <img src="img/logo/logo_PMI.png" alt="PMI Norte Perú">
            </div>
            <h1>Bienvenido</h1>
            <p>Accede al panel de administración de PMI Norte Perú</p>
            <div class="branding-decoration"></div>
        </div>

        <!-- Panel Derecho con Formulario -->
        <div class="login-form-wrapper">
            <div class="login-form-box">
                <h2>Iniciar Sesión</h2>
                <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
                
                <?php if (!empty($error)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="login.php" class="login-form">
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="correo" 
                                name="correo" 
                                placeholder="usuario@example.com" 
                                required
                                value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>"
                            >
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Ingresa tu contraseña" 
                                required
                            >
                            <i class="fas fa-lock input-icon"></i>
                        </div>
                    </div>

                    <!--<div class="form-options">
                        <label class="checkbox-container">
                            <input type="checkbox" name="recordar">
                            <span>Recordarme</span>
                        </label>
                        <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>-->

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </button>
                </form>

                <div class="login-footer">
                    <p>&copy; 2025 PMI Norte Perú. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
