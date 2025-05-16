<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modificar Tarea | !Tus Tareas</title>
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
    
    .task-container {
      max-width: 550px;
      width: 100%;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      padding: 2rem;
      position: relative;
    }
    
    .task-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .task-header h2 {
      color: #0d6efd;
      margin-bottom: 0.5rem;
      text-transform: capitalize;
    }
    
    .form-floating {
      margin-bottom: 1rem;
    }
    
    .btn-update {
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
    
    .priority-low {
      color: #198754;
    }
    
    .priority-medium {
      color: #fd7e14;
    }
    
    .priority-high {
      color: #dc3545;
    }
    
    .task-id {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background-color: #e9ecef;
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      font-size: 0.8rem;
      color: #6c757d;
    }
  </style>
</head>
<body>

<div class="task-container border-accent">

  
  <div class="task-header">
    <i class="bi bi-pencil-square text-primary" style="font-size: 3rem;"></i>
    <h2>Modificar Tarea</h2>
    <p class="text-muted">Actualiza la información de la tarea</p>
  </div>

  <?php echo form_open('tarea/modificart'); ?>
    
    <div class="form-floating mb-3">
      <?php echo form_input([
        'name' => 'tema',
        'type' => 'text',
        'class' => 'form-control',
        'id' => 'floatingTema',
        'placeholder' => 'Título de la tarea',
        'value' => $tarea['tema']
      ]); ?>
      <?php echo form_label('Tema', 'floatingTema'); ?>
    </div>

    <div class="form-floating mb-3">
      <?php echo form_textarea([
        'name' => 'descripcion',
        'class' => 'form-control',
        'id' => 'floatingDescripcion',
        'placeholder' => 'Descripción detallada de la tarea',
        'value' => $tarea['descripcion'],
        'style' => 'height: 100px'
      ]); ?>
      <?php echo form_label('Descripción', 'floatingDescripcion'); ?>
    </div>

    <div class="mb-3">
      <label for="selectPrioridad" class="form-label">Prioridad</label>
      <select name="prioridad" id="selectPrioridad" class="form-select">
        <option value="0" class="priority-low" <?php if ($tarea['prioridad'] == 0) echo 'selected'; ?>>Baja</option>
        <option value="1" class="priority-medium" <?php if ($tarea['prioridad'] == 1) echo 'selected'; ?>>Media</option>
        <option value="2" class="priority-high" <?php if ($tarea['prioridad'] == 2) echo 'selected'; ?>>Alta</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="inputFechaVencimiento" class="form-label">Fecha de vencimiento</label>
      <?php echo form_input([
        'name' => 'fecha_vencimiento',
        'type' => 'date',
        'class' => 'form-control' . (session('errors.fecha_vencimiento') ? ' is-invalid' : ''),
        'id' => 'inputFechaVencimiento',
        'value' => $tarea['fecha_vencimiento']
      ]); ?>
      <?php if (session('errors.fecha_vencimiento')): ?>
        <span class="error-text"><?= session('errors.fecha_vencimiento') ?></span>
      <?php endif; ?>
    </div>

    <div class="mb-4">
      <label for="inputFechaRecordatorio" class="form-label">Fecha de recordatorio (opcional)</label>
      <?php echo form_input([
        'name' => 'fecha_recordatorio',
        'type' => 'date',
        'class' => 'form-control' . (session('errors.fecha_recordatorio') ? ' is-invalid' : ''),
        'id' => 'inputFechaRecordatorio',
        'value' => $tarea['fecha_recordatorio']
      ]); ?>
      <?php if (session('errors.fecha_recordatorio')): ?>
        <span class="error-text"><?= session('errors.fecha_recordatorio') ?></span>
      <?php endif; ?>
    </div>

    <!-- Campo oculto para el ID de la tarea -->
    <input type="hidden" name="tarea_id" value="<?php echo $tarea['id_tarea']; ?>">

    <div class="d-grid gap-2 mb-3">
      <?php echo form_submit([
        'name' => 'enviar',
        'value' => 'Guardar Cambios',
        'class' => 'btn btn-primary btn-update'
      ]); ?>
    </div>
    
    <div class="d-flex justify-content-between mt-3">
      <a href="<?= site_url('tarea/vertarea/' . $tarea['id_tarea']) ?>" class="text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Volver a la tarea
      </a>
      
      <a href="<?= site_url() ?>" class="text-decoration-none">
        <i class="bi bi-house me-1"></i> Ir al inicio
      </a>
    </div>
    
  <?php echo form_close(); ?>
</div>

</body>
</html>