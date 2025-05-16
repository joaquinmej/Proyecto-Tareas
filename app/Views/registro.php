<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro | Task Manager</title>
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
    
    .register-container {
      max-width: 500px;
      width: 100%;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      padding: 2rem;
      position: relative;
    }
    
    .register-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .register-header h2 {
      color: #0d6efd;
      margin-bottom: 0.5rem;
    }
    
    .form-floating {
      margin-bottom: 1rem;
    }
    
    .btn-register {
      width: 100%;
      padding: 0.75rem;
      font-weight: 500;
    }
    
    .login-link {
      text-align: center;
      margin-top: 1.5rem;
    }
    
    .error-text {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
      display: block;
    }
    
    .border-accent {
      position: relative;
    }
    
   
  </style>
</head>
<body>

<div class="register-container border-accent">
  <div class="register-header">
    <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
    <h2>Crear cuenta</h2>
    <p class="text-muted">Regístrate para comenzar a gestionar tus tareas</p>
  </div>

  <?php echo form_open('registrar/guardar'); ?>
    
    <div class="form-floating mb-3">
      <?php echo form_input([
        'name' => 'email',
        'type' => 'email',
        'class' => 'form-control' . (session('errors.email') ? ' is-invalid' : ''),
        'id' => 'floatingEmail',
        'placeholder' => 'nombre@ejemplo.com',
        'value' => old('email')
      ]); ?>
      <?php echo form_label('Correo electrónico', 'floatingEmail'); ?>
      <?php if (session('errors.email')): ?>
        <span class="error-text"><?= session('errors.email') ?></span>
      <?php endif; ?>
    </div>


    <div class="form-floating mb-3">
      <?php echo form_password([
        'name' => 'contraseña',
        'class' => 'form-control' . (session('errors.contraseña') ? ' is-invalid' : ''),
        'id' => 'floatingPassword',
        'placeholder' => 'Contraseña'
      ]); ?>
      <?php echo form_label('Contraseña', 'floatingPassword'); ?>
      <?php if (session('errors.contraseña')): ?>
        <span class="error-text"><?= session('errors.contraseña') ?></span>
      <?php endif; ?>
    </div>

    <div class="form-floating mb-4">
      <?php echo form_password([
        'name' => 'recontraseña',
        'class' => 'form-control' . (session('errors.recontraseña') ? ' is-invalid' : ''),
        'id' => 'floatingConfirmPassword',
        'placeholder' => 'Confirmar contraseña'
      ]); ?>
      <?php echo form_label('Confirmar contraseña', 'floatingConfirmPassword'); ?>
      <?php if (session('errors.recontraseña')): ?>
        <span class="error-text"><?= session('errors.recontraseña') ?></span>
      <?php endif; ?>
    </div>

    <div class="d-grid gap-2">
      <?php echo form_submit([
        'name' => 'enviar',
        'value' => 'Crear cuenta',
        'class' => 'btn btn-primary btn-register'
      ]); ?>
    </div>
    
    <div class="login-link">
      <p class="mb-0">¿Ya tienes una cuenta? <a href="<?= base_url('login') ?>" class="text-decoration-none fw-bold">Inicia sesión aquí</a></p>
    </div>
    
  <?php echo form_close(); ?>
</div>

</body>
</html>