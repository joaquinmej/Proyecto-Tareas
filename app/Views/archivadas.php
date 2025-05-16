<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>!Tus Tareas</title>
  <link rel="stylesheet" href="<?= base_url('estilos/estiloInicio.css') ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
   /* Contenedor principal para la barra lateral */
   .notifications-container {
    position: fixed;
    top: 0;
    right: -320px;
    width: 320px;
    height: 100%;
    background-color: white;
    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    transition: right 0.3s ease;
    z-index: 1050;
    overflow-y: auto;
  }
  
  /* Checkbox oculto que controla la visibilidad */
  #notifications-toggle {
    display: none;
  }
  
  /* Cuando el checkbox está marcado, muestra la barra lateral */
  #notifications-toggle:checked ~ .notifications-container {
    right: 0;
  }
  
  /* Overlay oscuro cuando la barra está abierta */
  .notifications-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    display: none;
  }
  
  #notifications-toggle:checked ~ .notifications-overlay {
    display: block;
  }
  
  /* Estilos para el encabezado de la barra lateral */
  .notifications-header {
    padding: 1rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  /* Estilos para los elementos de notificación */
  .notification-item {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    transition: background-color 0.2s;
  }
  
  .notification-item:hover {
    background-color: #f8f9fa;
  }
  
  .notification-unread {
    border-left: 4px solid #0d6efd;
  }
  
  .notification-time {
    font-size: 0.8rem;
    color: #6c757d;
  }
  
  /* Contador de notificaciones */
  .notifications-badge {
    position: absolute;
    top: 0;
    right: 0;
    transform: translate(25%, -25%);
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    font-weight: bold;
  }
  
  /* Botón de cerrar en la barra lateral */
  .close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6c757d;
  }
  
  .close-btn:hover {
    color: #212529;
  }
  
  /* Estilos para el botón de notificaciones en la navbar */
  .notifications-btn {
    position: relative;
  }
  
  /* Estilos para los botones de aceptar/rechazar */
  .invitation-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
  }
  
  .invitation-actions form {
    flex: 1;
  }
  
  .invitation-actions button {
    width: 100%;
  }
  .notification-dot {
  position: absolute;
  top: 0;
  right: 0;
  width: 10px;
  height: 10px;
  background-color: #ff0000;
  border-radius: 50%;
}
</style>
</head>
<body class="bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?php echo site_url(); ?>">
      <i class="bi bi-check2-square me-2"></i>
      !Tus Tareas
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['mail'])): ?>
          <!-- Botón de notificaciones -->
          <li class="nav-item me-2">
  <label for="notifications-toggle" class="nav-link notifications-btn" style="cursor: pointer;">
    <i class="bi bi-envelope-fill"></i>
    <?php if (isset($invitaciones) && !empty($invitaciones)): ?>
      <span class="notification-dot"></span>
    <?php endif; ?>
  </label>
    </li>
          
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('tarea/archivadas'); ?>">
              <i class="bi bi-plus-circle me-1"></i> Tareas Archivadas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('login/logout'); ?>">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('login'); ?>">
              <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Checkbox oculto y barra lateral de notificaciones -->
<input type="checkbox" id="notifications-toggle">
<div class="notifications-overlay">
  <label for="notifications-toggle"></label>
</div>
<div class="notifications-container">
  <div class="notifications-header">
    <h5 class="mb-0">Invitaciones</h5>
    <label for="notifications-toggle" class="close-btn">&times;</label>
  </div>
  
  <div class="notifications-content">
    <?php 
  
      if (empty($invitaciones)):
    ?>
      <div class="p-4 text-center text-muted">
        <i class="bi bi-envelope-open fs-4 mb-2"></i>
        <p>No tienes invitaciones pendientes</p>
      </div>
    <?php else: ?>
      <?php foreach ($invitaciones as $invitacion): ?>
        <div class="notification-item notification-unread">
          <div>
            <p class="mb-1">
              <strong><?php echo $invitacion['responsable']; ?></strong> 
              te ha invitado a colaborar en la tarea
            </p>
            <p class="mb-1 fw-bold">"<?php echo $invitacion['tema']; ?>"</p>

          </div>
          
          <!-- Botones de aceptar o rechazar -->
          <div class="invitation-actions">
            <form method="post" action="<?php echo site_url('invitaciones/aceptar'); ?>">
              <input type="hidden" name="id_colaborador" value="<?php echo $invitacion['id_colaborador']; ?>">
              <button type="submit" class="btn btn-sm btn-success">
                <i class="bi bi-check-lg me-1"></i> Aceptar
              </button>
            </form>
            
            <form method="post" action="<?php echo site_url('invitaciones/rechazar'); ?>">
              <input type="hidden" name="invitacion_id" value="<?php echo $invitacion['id_colaborador']; ?>">
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-x-lg me-1"></i> Rechazar
              </button>
            </form>
          </div>
  
          
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
  <!-- Main Content -->
  <main class="container mb-5">
    <!-- Header with actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3">Mis Tareas Archivadas</h1>
      <div>
        <a class="btn btn-primary" href="<?php echo site_url('creartarea'); ?>" role="button">
          <i class="bi bi-plus-circle me-1"></i> Crear tarea
        </a>
      </div>
    </div>

    <!-- Filter options -->
    
    <!-- Task list -->
    <div id="taskList">
      <?php if (empty($tareas)): ?>
        <div class="alert alert-info">
          <i class="bi bi-info-circle me-2"></i> No hay tareas disponibles. ¡Crea una nueva tarea para comenzar!
        </div>
      <?php endif; ?>

      <?php foreach($tareas as $tarea):
      
        if($tarea['prioridad'] == 0){
          $prioridad = "baja";
          $badgeClass = "bg-success";
        } else if($tarea['prioridad'] == 1){
          $prioridad = "media";
          $badgeClass = "bg-warning text-dark";
        } else {
          $prioridad = "alta";
          $badgeClass = "bg-danger";
        }
        if($tarea['estado'] == 0)
{ $estado = "Definido"; 
}else if($tarea['estado'] == 1)
{ $estado ="En proceso"; }
else{ $estado = "Completo"; }
      ?>
        <div class="card w-100 mb-3 shadow-sm task-card" data-priority="<?php echo $prioridad; ?>">
          <div class="row g-0">
            <!-- Barra de color lateral -->
            <div class="col-sm-1 col-2" style="background-color: <?php echo $tarea['color']; ?>;">
              <!-- Espacio para la barra de color -->
            </div>
            
            <!-- Contenido principal -->
            <div class="col-sm-9 col-7 position-relative">
              <div class="card-body py-2">
                <h5 class="card-title mb-1"><?php echo $tarea['tema']; ?></h5>
                
                <div class="d-flex flex-wrap gap-2 mb-1">
                  <span class="badge <?php echo $badgeClass; ?>">
                    <i class="bi bi-flag-fill me-1"></i>
                    <?php echo $prioridad; ?>
                  </span>
                  <span class="badge <?php echo ($estado == 'Completo') ? 'bg-success' : (($estado == 'En proceso') ? 'bg-primary' : 'bg-secondary'); ?>">
                <i class="bi bi-check-circle-fill me-1"></i>
                <?php echo $estado; ?>
              </span>
                  <span class="badge bg-info text-dark">
                    <i class="bi bi-calendar-event me-1"></i>
                    <?php echo $tarea['fecha_vencimiento']; ?>
                  </span>
                </div>
                
                <!-- Link que cubre solo esta sección, no toda la card -->
                <a href="<?php echo site_url('tarea/vertarea/' .$tarea['id_tarea']); ?>" class="stretched-link"></a>
              </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="col-sm-2 col-3 d-flex flex-column justify-content-center align-items-center gap-2 p-2">
              <a class="btn btn-sm btn-outline-danger w-100" href="<?php echo site_url('tarea/borrar/'.$tarea['id_tarea']); ?>" role="button" 
                 onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
                <i class="bi bi-trash"></i>
                <span class="d-none d-md-inline">Borrar</span>
              </a>
              <a class="btn btn-sm btn-outline-primary w-100" href="<?php echo site_url('tarea/modificar/'.$tarea['id_tarea']); ?>" role="button">
                <i class="bi bi-pencil"></i>
                <span class="d-none d-md-inline">Modificar</span>
              </a>
            </div>
          </div>
        </div> 

      <?php 
    endforeach; ?>
  
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4 mt-auto">
    <div class="container text-center">
      <p class="mb-0">!TusTareas | Joaquin Muñoz &copy; <?php echo date('Y'); ?></p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>

</body>
</html>