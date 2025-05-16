<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesión | !Tus Tareas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url('estilos/login.css') ?>">
  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }
    
    .login-container {
      max-width: 450px;
      width: 100%;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      padding: 2rem;
      position: relative;
    }
    
    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .login-header h2 {
      color: #0d6efd;
      margin-bottom: 0.5rem;
    }
    
    .form-floating {
      margin-bottom: 1rem;
    }
    
    .btn-login {
      width: 100%;
      padding: 0.75rem;
      font-weight: 500;
    }
    
    .btn-reset {
      width: 100%;
      padding: 0.75rem;
      font-weight: 500;
    }
    
    .register-link {
      text-align: center;
      margin-top: 1.5rem;
    }
    
    .error-message {
      background-color: #f8d7da;
      color: #842029;
      padding: 0.75rem;
      border-radius: 5px;
      margin-bottom: 1rem;
      text-align: center;
    }
    
    .border-accent {
      position: relative;
    }
    
    .border-accent::before {
      content: '';
      position: absolute;
      top: -10px;
      left: -10px;
      right: -10px;
      bottom: -10px;
      border: 3px dashed #0d6efd;
      border-radius: 15px;
      z-index: -1;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-header">
    <i class="bi bi-check2-square text-primary" style="font-size: 3rem;"></i>
    <h2>!Tus Tareas</h2>
    <p class="text-muted">Inicia sesión para acceder a tus tareas</p>
  </div>

  <?php if(isset($error)): ?>
    <div class="error-message">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      El correo o la contraseña son incorrectos
    </div>
  <?php endif; ?>

  <?php echo form_open('login/exito'); ?>
    
    <div class="form-floating mb-3">
      <?php echo form_input([
        'name' => 'email',
        'type' => 'email',
        'class' => 'form-control',
        'id' => 'floatingEmail',
        'placeholder' => 'nombre@ejemplo.com',
        'value' => old('email')
      ]); ?>
      <?php echo form_label('Correo electrónico', 'floatingEmail'); ?>
    </div>

    <div class="form-floating mb-4">
      <?php echo form_password([
        'name' => 'contraseña',
        'class' => 'form-control',
        'id' => 'floatingPassword',
        'placeholder' => 'Contraseña'
      ]); ?>
      <?php echo form_label('Contraseña', 'floatingPassword'); ?>
    </div>

    <div class="d-grid gap-2 mb-3">
      <?php echo form_submit([
        'name' => 'enviar',
        'value' => 'Iniciar sesión',
        'class' => 'btn btn-primary btn-login'
      ]); ?>
    </div>
    
    <div class="d-grid gap-2">
      <?php echo form_reset([
        'name' => 'reset',
        'value' => 'Limpiar formulario',
        'class' => 'btn btn-outline-secondary btn-reset'
      ]); ?>
    </div>
    
    <div class="register-link">
      <p class="mb-0">¿No tienes una cuenta? <a href="<?= base_url('registrar') ?>" class="text-decoration-none fw-bold">Regístrate aquí</a></p>
    </div>
    
  <?php echo form_close(); ?>
</div>

</body>
</html>
