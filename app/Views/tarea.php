<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalles de Tarea | Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    /* Estilos personalizados para reducir el tamaño de los botones del navbar */
    .navbar .nav-link {
      padding: 0.25rem 0.5rem !important;
      font-size: 0.875rem;
    }
    
    .navbar .navbar-nav {
      align-items: center;
    }
    
    .navbar-brand {
      font-size: 1rem;
    }
    
    .notification-dot {
      position: absolute;
      top: 0;
      right: 0;
      width: 8px;
      height: 8px;
      background-color: red;
      border-radius: 50%;
    }
    
    .notifications-btn {
      position: relative;
      padding: 0.25rem 0.5rem !important;
    }
    
    /* Reducir el espacio entre elementos */
    .navbar .nav-item {
      margin-right: 0.25rem !important;
    }
    
    /* Hacer que los iconos sean un poco más pequeños */
    .navbar .bi {
      font-size: 0.875rem;
    }
  </style>
</head>
<body class="bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
      <a class="navbar-brand" href="<?php echo site_url(); ?>">
        <i class="bi bi-check2-square me-1"></i>
        !Tus Tareas
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['mail'])): ?>
            <li class="nav-item me-1">
              <a class="nav-link" href="<?php echo site_url('archivar'); ?>">
                <i class="bi bi-plus-circle me-1"></i>Archivadas
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('login/logout'); ?>">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('login'); ?>">
                <i class="bi bi-box-arrow-in-right me-1"></i>Login
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container mb-5">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Detalles de la Tarea</h2>
      <a href="<?php echo site_url(); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Volver
      </a>
    </div>

    <!-- Tarea principal -->
    <div class="card w-100 mb-4 shadow-sm">
      <div class="row g-0">
        <!-- Barra de color lateral -->
        <div class="col-sm-1 col-2" style="background-color: <?php echo $tarea['color']; ?>;">
          <!-- Espacio para la barra de color -->
        </div>
        
        <!-- Contenido principal -->

        <?php if ($_SESSION['mail'] == $tarea['responsable'])
{ $dueño = true;
} else $dueño = false; ?>

<?php if($tarea['prioridad'] == 0)
{ $prioridad = "baja"; 
}else if($tarea['prioridad'] == 1)
{ $prioridad ="normal"; 
}else{ $prioridad = "alta"; } 
if($tarea['estado'] == 0)
{ $estado = "Definido"; 
}else if($tarea['estado'] == 1)
{ $estado ="En proceso"; }
else{ $estado = "Completo"; } ?>

        <div class="col-sm-9 col-7">
          <div class="card-body py-3">
            <h4 class="card-title mb-2"><?php echo $tarea['tema']; ?></h4>
            
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="badge <?php echo ($prioridad == 'alta') ? 'bg-danger' : (($prioridad == 'normal') ? 'bg-warning text-dark' : 'bg-success'); ?>">
                <i class="bi bi-flag-fill me-1"></i>
                <?php echo ucfirst($prioridad); ?>
              </span>
              <span class="badge <?php echo ($estado == 'Completo') ? 'bg-success' : (($estado == 'En proceso') ? 'bg-primary' : 'bg-secondary'); ?>">
                <i class="bi bi-check-circle-fill me-1"></i>
                <?php echo $estado; ?>
              </span>
              <span class="badge bg-info text-dark">
  <i class="bi bi-calendar-event me-1"></i>
  <?php echo $tarea['fecha_vencimiento']; ?>
</span>

<?php if(isset($tarea['fecha_recordatorio']) && !empty($tarea['fecha_recordatorio'])): ?>
<span class="badge bg-secondary text-white">
  <i class="bi bi-bell-fill me-1"></i>
  Recordatorio: <?php echo $tarea['fecha_recordatorio']; ?>
</span>
<?php endif; ?>
            </div>
            
            <p class="card-text mb-3"><?php echo $tarea['descripcion']; ?></p>
            
            <div class="mb-3">
              <strong><i class="bi bi-person-fill me-1"></i> Responsable:</strong> 
              <?php echo $tarea['responsable']; ?>
            </div>
            
            <!-- Integrantes de la tarea -->
            <div class="mb-3">
              <strong><i class="bi bi-people-fill me-1"></i> Integrantes:</strong>
              <div class="mt-2 d-flex flex-wrap gap-2">
                <?php if(isset($colaboradores) && is_array($colaboradores)): ?>
                  <?php foreach($colaboradores as $colaborador): ?>
                    <span class="badge bg-light text-dark p-2">
                      <i class="bi bi-person-circle me-1"></i>
                      <?php echo $colaborador['usuario_colaborador']; ?>
                    </span>
                  <?php endforeach; ?>
                <?php else: ?>
                  <span class="text-muted">No hay colaboradores adicionales</span>
                <?php endif; ?>
              </div>
            </div>
            
            <!-- Formulario para cambiar el estado -->
            <?php if($dueño && $tarea['estado'] < 3): ?>
              <?php echo form_open('tarea/cambiarestado', ['class' => 'mb-3']); ?>
                <div class="row g-2 align-items-center">
                  <div class="col-auto">
                    <label for="cambiarEstado" class="col-form-label">Cambiar estado:</label>
                  </div>
                  <div class="col-auto">
                    <select name="estado" id="cambiarEstado" class="form-select form-select-sm">
                      <option value="0" <?php if($tarea['estado'] == 0) echo 'selected'; ?>>Definido</option>
                      <option value="1" <?php if($tarea['estado'] == 1) echo 'selected'; ?>>En proceso</option>
                      <option value="2" <?php if($tarea['estado'] >= 2) echo 'selected'; ?>>Completo</option>
                    </select>
                  </div>
                  <div class="col-auto">
                    <input type="hidden" name="tarea_id" value="<?php echo $tarea['id_tarea']; ?>">
                    <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                  </div>
                </div>
              <?php echo form_close(); ?>
              <?php if(session()->getFlashdata('no_completo')): ?>
          <div class="alert alert-danger mt-3 mb-0">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo session()->getFlashdata('no_completo'); ?>
          </div>
        <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
        
        <!-- Botones de acción -->
        <div class="col-sm-2 col-3 d-flex flex-column justify-content-center align-items-center gap-2 p-2">
          <?php if($dueño): ?>
            <a class="btn btn-sm btn-outline-danger w-100" href="<?php echo site_url('tarea/borrar/'.$tarea['id_tarea']); ?>" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
              <i class="bi bi-trash"></i>
              <span class="d-none d-md-inline">Borrar</span>
            </a>
            <a class="btn btn-sm btn-outline-primary w-100" href="<?php echo site_url('tarea/modificar/'.$tarea['id_tarea']); ?>" role="button">
              <i class="bi bi-pencil"></i>
              <span class="d-none d-md-inline">Modificar</span>
              <?php if($tarea['estado'] != 3){?>
            </a><a class="btn btn-sm btn-outline-success w-100" href="<?php echo site_url('creartarea/crearsub/'.$tarea['id_tarea']); ?>" role="button">
            <i class="bi bi-plus-circle"></i> 
              <span class="d-none d-md-inline">Subtarea</span>
              <?php }?>
          </a>
          
          <?php 
          if($tarea['estado'] == 2) :?>
          <a class="btn btn-sm btn-outline-secondary w-100" href="<?php echo site_url('tarea/archivar/'.$tarea['id_tarea']); ?>" role="button">
  <i class="bi bi-archive"></i>
  <span class="d-none d-md-inline">Archivar</span>
</a>
<?php endif; ?>
          <?php endif; ?>
          <?php if(session()->getFlashdata('archivada')): ?>
          <div class="alert alert-success mt-3 mb-0">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo session()->getFlashdata('archivada'); ?>
          </div>
          <?php endif;?>
         
        </div>
      </div>
    </div>
<!-- Formulario para invitar colaboradores -->
<?php if($dueño): ?>
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-light">
      <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Invitar colaboradores</h5>
    </div>
    <div class="card-body">
      <?php echo form_open('tarea/invitarcolaborador'); ?>
        <div class="row g-3 align-items-center">
          <div class="col-md-8">
            <label for="emailColaborador" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="emailColaborador" name="email_colaborador" placeholder="ejemplo@correo.com" required>
            <div class="form-text">El usuario debe estar registrado en el sistema.</div>
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <input type="hidden" name="tarea_id" value="<?php echo $tarea['id_tarea']; ?>">
            <button type="submit" class="btn btn-primary w-100 mt-md-0 mt-2">
              <i class="bi bi-send me-1"></i> Enviar invitación
            </button>
          </div>
        </div>
        <?php if(session()->getFlashdata('no_existe')): ?>
          <div class="alert alert-danger mt-3 mb-0">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo session()->getFlashdata('no_existe'); ?>
          </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('exito_invitacion')): ?>
          <div class="alert alert-success mt-3 mb-0">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo session()->getFlashdata('exito_invitacion'); ?>
          </div>
        <?php endif; ?>
      <?php echo form_close(); ?>
    </div>
  </div>
<?php endif; ?>
    <!-- Subtareas -->
    <h3 class="mb-3">Subtareas</h3>
    
    <?php if(empty($subtareas)): ?>
      <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i> No hay subtareas disponibles. ¡Crea una nueva subtarea para comenzar!
      </div>
    <?php else: ?>
      <?php foreach($subtareas as $subtarea):
        // Control de variables
        if($subtarea['prioridad'] == 0) {
          $prioridad = "sin prioridad";
          $badgeClass = "bg-secondary";
        } else if($subtarea['prioridad'] == 1) {
          $prioridad = "baja";
          $badgeClass = "bg-success";
        } else if($subtarea['prioridad'] == 2) {
          $prioridad = "media";
          $badgeClass = "bg-warning text-dark";
        } else {
          $prioridad = "alta";
          $badgeClass = "bg-danger";
        }

        if($subtarea['estado'] == 0) {
          $estado = "Definido";
          $estadoClass = "bg-secondary";
        } else if($subtarea['estado'] == 1) {
          $estado = "En Proceso";
          $estadoClass = "bg-primary";
        } else if($subtarea['estado'] == 2) {
          $estado = "Completada";
          $estadoClass = "bg-success";
        }

        $responsable = $subtarea['responsable'] ?? "Sin Responsable";
        $fecha = $subtarea['fecha_vencimiento'] ?? "Sin fecha de vencimiento";
        $comentario = $subtarea['comentario'] ?? "Sin comentario";
      ?>
        <div class="card w-100 mb-3 shadow-sm">
          <div class="row g-0">
            <!-- Barra de color lateral (gris para subtareas) -->
            <div class="col-sm-1 col-2" style="background-color: #6c757d;">
              <!-- Espacio para la barra de color -->
            </div>
            
            <!-- Contenido principal -->
            <div class="col-sm-9 col-7">
              <div class="card-body py-2">
                <h5 class="card-title mb-1"><?php echo $subtarea['tema']; ?></h5>
                
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="badge <?php echo $badgeClass; ?>">
                    <i class="bi bi-flag-fill me-1"></i>
                    <?php echo $prioridad; ?>
                  </span>
                  <span class="badge <?php echo $estadoClass; ?>">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    <?php echo $estado; ?>
                  </span>
                </div>
                
                <p class="card-text small mb-1"><strong>Descripción:</strong> <?php echo $subtarea['descripcion']; ?></p>
                <p class="card-text small mb-1"><strong>Comentario:</strong> <?php echo $comentario; ?></p>
                <p class="card-text small mb-1"><strong>Responsable:</strong> <?php echo $responsable; ?></p>
                <p class="card-text small mb-1"><strong>Vencimiento:</strong> <?php echo $fecha; ?></p>
               
                
                <!-- Formulario para cambiar el estado de la subtarea -->
                <?php if($dueño || $subtarea['responsable'] == $_SESSION['mail']): ?>
                  <?php echo form_open('tarea/cambiarestadosub', ['class' => 'mt-2']); ?>
                    <div class="row g-2 align-items-center">
                      <div class="col-auto">
                        <select name="estado" class="form-select form-select-sm" style="width: auto;">
                          <option value="0" <?php if($subtarea['estado'] == 0) echo 'selected'; ?>>Definido</option>
                          <option value="1" <?php if($subtarea['estado'] == 1) echo 'selected'; ?>>En proceso</option>
                          <option value="2" <?php if($subtarea['estado'] == 2) echo 'selected'; ?>>Completada</option>
                        </select>
                      </div>
                      <div class="col-auto">
                        <input type="hidden" name="subtarea_id" value="<?php echo $subtarea['id_sub']; ?>">
                        <input type="hidden" name="tarea_id" value="<?php echo $tarea['id_tarea']; ?>">
                         <input type="hidden" name="estadot" value="<?php echo $tarea['estado']; ?>">
                        <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                      </div>
                    </div>
                  <?php echo form_close(); ?>
                <?php endif; ?>
              </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="col-sm-2 col-3 d-flex flex-column justify-content-center align-items-center gap-2 p-2">
              <?php if($dueño): ?>
                <a class="btn btn-sm btn-outline-danger w-100" href="<?php echo site_url('tarea/borrarsub/'.$subtarea['id_sub'].'/'.$tarea['id_tarea']); ?>" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta subtarea?')">
                  <i class="bi bi-trash"></i>
                  <span class="d-none d-md-inline">Borrar</span>
                </a>
                <a class="btn btn-sm btn-outline-primary w-100" href="<?php echo site_url('tarea/modificarsub/'.$tarea['id_tarea'].'/'.$subtarea['id_sub']); ?>" role="button">
                  <i class="bi bi-pencil"></i>
                  <span class="d-none d-md-inline">Modificar</span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4 mt-auto">
    <div class="container text-center">
      <p class="mb-0">!Tus Tareas | Joaquin Muñoz &copy; <?php echo date('Y'); ?></p>
    </div>
  </footer>
</body>
</html>