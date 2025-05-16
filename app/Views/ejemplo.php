<!DOCTYPE html>  
<html lang="es">  
    <link rel="stylesheet" href="<?= base_url('estilos/ej.css') ?>">

<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="styles.css"><title>Gestión de Tareas</title>  
</head>  
<body><div class="container"><h1>Gestión de Tareas</h1><form id="task-form"><input type="text" id="task-description" placeholder="Descripción de la tarea" required><select id="task-priority"><option value="alta">Alta</option><option value="media">Media</option><option value="baja">Baja</option></select><input type="date" id="task-deadline" required><button type="submit">Agregar Tarea</button></form><div class="task-list"><h2>Lista de Tareas</h2><ul id="tasks"><!-- Las tareas se agregarán aquí dinámicamente --></ul></div></div><script src="script.js"></script>  
</body>  
</html>   
