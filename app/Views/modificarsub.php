<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear Subtarea | Task Manager</title>
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
    
    .subtask-container {
      max-width: 550px;
      width: 100%;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      padding: 2rem;
      position: relative;
    }
    
    .subtask-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .subtask-header h2 {
      color: #0d6efd;
      margin-bottom: 0.5rem;
      text-transform: capitalize;
    }
    
    .form-floating {
      margin-bottom: 1rem;
    }
    
    .btn-create {
      width: 100%;
      padding: 0.75rem;
      font-weight: 500;
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
    
    .priority-none {
      color: #6c757d;
    }
    
    .priority-low {
      color: #198754;
    }
    
    .priority-medium {
      color: #fd7e14;
    }
    
    .priority-high {
      color: #dc3545;
    }
    
    .parent-task-info {
      background-color: #e9ecef;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>

<div class="subtask-container ">
  <div class="subtask-header">
    <i class="bi bi-list-check text-primary" style="font-size: 3rem;"></i>
    <h2>Modificar Subtarea</h2>
    <p class="text-muted">modifica una subtarea de la tarea principal</p>
  </div>
  
  <!-- Información de la tarea padre -->
  <div class="parent-task-info">
    <h6 class="mb-2"><i class="bi bi-arrow-return-right me-2"></i>Tarea principal:</h6>
    <p class="mb-0 fw-bold"><?php echo $tarea['tema'] ?? 'Tarea principal'; ?></p>
  </div>

  <?php echo form_open('tarea/guardarmod'); ?>
    
    <div class="form-floating mb-3">
      <?php echo form_input([
        'name' => 'tema',
        'type' => 'text',
        'class' => 'form-control' . (session('errors.tema') ? ' is-invalid' : ''),
        'id' => 'floatingTema',
        'placeholder' => 'Título de la subtarea',
        'value' => $subtarea['tema'],
      ]); ?>
      <?php echo form_label('Tema', 'floatingTema'); ?>
      <?php if (session('errors.tema')): ?>
        <span class="error-text"><?= session('errors.tema') ?></span>
      <?php endif; ?>
    </div>

    <div class="form-floating mb-3">
      <?php echo form_textarea([
        'name' => 'descripcion',
        'class' => 'form-control' . (session('errors.descripcion') ? ' is-invalid' : ''),
        'id' => 'floatingDescripcion',
        'placeholder' => 'Descripción detallada de la subtarea',
        'value' => $subtarea['descripcion'],
        'style' => 'height: 100px'
      ]); ?>
      <?php echo form_label('Descripción', 'floatingDescripcion'); ?>
      <?php if (session('errors.descripcion')): ?>
        <span class="error-text"><?= session('errors.descripcion') ?></span>
      <?php endif; ?>
    </div>

    <div class="form-floating mb-3">
      <?php echo form_textarea([
        'name' => 'comentario',
        'class' => 'form-control',
        'id' => 'floatingComentario',
        'placeholder' => 'Comentarios adicionales (opcional)',
        'value' => $subtarea['comentario'],
        'style' => 'height: 80px'
      ]); ?>
      <?php echo form_label('Comentario (opcional)', 'floatingComentario'); ?>
    </div>

    <div class="mb-3">
      <label for="selectPrioridad" class="form-label">Prioridad</label>
      <select name="prioridad" id="selectPrioridad" class="form-select">
        <option value="0" class="priority-none" <?php if ($subtarea['prioridad'] == 0) echo 'selected';?>>Sin prioridad</option>
        <option value="1" class="priority-low" <?php if ($subtarea['prioridad'] == 1) echo 'selected';?>>Baja</option>
        <option value="2" class="priority-medium" <?php if ($subtarea['prioridad'] == 2) echo 'selected';?>>Media</option>
        <option value="3" class="priority-high" <?php if ($subtarea['prioridad'] == 3) echo 'selected';?>>Alta</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="selectResponsable" class="form-label">Responsable</label>
      <select name="responsable" id="selectResponsable" class="form-select">
        <option value="null">Sin responsable</option>
        <?php foreach($colaboradores as $colaborador): ?>
          <option value="<?php echo $colaborador['usuario_colaborador']; ?>"
            <?php if ($colaborador['usuario_colaborador'] == $subtarea['responsable']) echo 'selected'; ?>>
            <?php echo $colaborador['usuario_colaborador']; ?>
          </option>  
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-4">
      <label for="inputFechaVencimiento" class="form-label">Fecha de vencimiento (opcional)</label>
      <?php echo form_input([
        'name' => 'fecha_vencimiento',
        'type' => 'date',
        'class' => 'form-control' . (session('errors.fecha_vencimiento') ? ' is-invalid' : ''),
        'id' => 'inputFechaVencimiento',
        'value' => $subtarea['fecha_vencimiento'],
      ]); ?>
      <?php if (session('errors.fecha_vencimiento')): ?>
        <span class="error-text"><?= session('errors.fecha_vencimiento') ?></span>
      <?php endif; ?>
    </div>

    <!-- Campo oculto para el ID de la tarea padre -->
    <input type="hidden" name="id_subtarea" value="<?php echo $subtarea['id_sub']; ?>">
<input type="hidden" name="id_tarea" value="<?php echo $tarea['id_tarea']; ?>">
    <div class="d-grid gap-2">
      <?php echo form_submit([
        'name' => 'enviar',
        'value' => 'Crear Subtarea',
        'class' => 'btn btn-primary btn-create'
      ]); ?>
    </div>
    
    <div class="text-center mt-3">
      <a href="<?= site_url('tarea/vertarea/' . $tarea['id_tarea']) ?>" class="text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Volver a la tarea principal
      </a>
    </div>
    
  <?php echo form_close(); ?>
</div>

</body>
</html>