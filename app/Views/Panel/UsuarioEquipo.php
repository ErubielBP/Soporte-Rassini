<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>">
  <title>Usuarios y Equipos</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/fontawesome-free/css/all.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_DIST . '/css/adminlte.min.css') ?>">

  <style>
    html, body { height: 100%; }
    .wrapper { min-height: 100%; }
    .main-sidebar { height: 100vh; overflow: hidden; }
    .main-sidebar .sidebar { height: calc(100vh - 57px); overflow-y: auto; }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url('Panel/index') ?>" class="nav-link">Inicio</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-flex align-items-center">
        <span class="nav-link">Hola, <?= session()->get('nombreCompleto') ?></span>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('logout') ?>">Salir</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img src="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>" alt="Rassini Logo"
           class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Rassini Frenos</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a><?= session()->get('nombreCompleto') ?></a>
        </div>
      </div>

      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="Search" placeholder="Buscar" aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
          </div>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= base_url('Panel/index') ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i><p>Inicio</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('empleado') ?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i><p>Usuarios</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('equipos') ?>" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i><p>Equipos de computo</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('usuario-equipo') ?>" class="nav-link active">
              <i class="nav-icon fas fa-link"></i><p>Usuarios y equipos</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('mantenimientos') ?>" class="nav-link">
             <i class="nav-icon fas fa-tools"></i><p>Mantenimientos</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <!-- /.sidebar -->

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Usuarios y equipos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('Panel/index') ?>">Inicio</a></li>
              <li class="breadcrumb-item active">Usuarios y equipos</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">

        <!-- Errores -->
        <?php if (session('errors')): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <!-- Éxito -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
          </div>
        <?php endif; ?>

        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Asignaciones de equipos a usuarios</h3>

                <!-- Mantener estilo como Equipos -->
                <div class="card-tools d-flex align-items-center">

                  <!-- Buscador -->
                  <form action="<?= site_url('usuario-equipo/buscar') ?>" method="get" class="mr-2">
                    <div class="input-group input-group-sm" style="width: 240px;">
                      <input
                        type="text"
                        name="q"
                        class="form-control"
                        placeholder="Buscar usuario o equipo..."
                        value="<?= isset($q) ? esc($q) : '' ?>"
                      >
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>

                  <!-- Botón nuevo -->
                  <button id="btnNuevo" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAsignacion">
                    <i class="fas fa-plus"></i> Asignar equipo
                  </button>

                </div>
              </div>
              <!-- /.card-header -->

              <div class="card-body table-responsive p-0" style="max-height: calc(100vh - 260px);">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width:120px;">Id_EquipoUsuario</th>
                      <th style="width:120px;">Id_Empleado</th>
                      <th>Empleado</th>
                      <th style="width:120px;">Id_activo</th>
                      <th>Equipo</th>
                      <th>IP</th>
                      <th style="width:150px;">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($asignaciones)): ?>
                      <?php foreach ($asignaciones as $a): ?>
                        <tr>
                          <td><?= esc($a['Id_EquipoUsuario']) ?></td>
                          <td><?= esc($a['Id_Empleado']) ?></td>
                          <td><?= esc($a['EmpleadoNombre']) ?></td>
                          <td><?= esc($a['Id_activo']) ?></td>
                          <td><?= esc($a['Nom_Activo']) ?></td>
                          <td><?= esc($a['Ip_equipo']) ?></td>
                          <td>
                            <button
                              type="button"
                              class="btn btn-sm btn-warning btnEditar"
                              data-id="<?= esc($a['Id_EquipoUsuario']) ?>"
                              data-id_empleado="<?= esc($a['Id_Empleado']) ?>"
                              data-id_activo="<?= esc($a['Id_activo']) ?>"
                            >
                              <i class="fas fa-edit"></i>
                            </button>

                            <form action="<?= site_url('usuario-equipo/eliminar/' . $a['Id_EquipoUsuario']) ?>" method="post" class="d-inline">
                              <?= csrf_field() ?>
                              <button type="submit" class="btn btn-sm btn-danger btnEliminar">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="7" class="text-center">No hay asignaciones registradas.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.1
    </div>
    <strong>Copyright &copy; 2025 <a href="https://www.rassini.com/frenos/">Rassini Frenos</a>.</strong>
    Todos los derechos reservados.
  </footer>
</div>

<!-- Modal Asignación -->
<div class="modal fade" id="modalAsignacion" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formAsignacion" method="post" action="<?= site_url('usuario-equipo/guardar') ?>">
      <?= csrf_field() ?>
      <input type="hidden" id="Id_EquipoUsuario" name="Id_EquipoUsuario" value="">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Asignar equipo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label for="Id_Empleado">Usuario (Empleado)</label>
            <select class="form-control" name="Id_Empleado" id="Id_Empleado" required>
              <option value="">Seleccione un usuario</option>
              <?php if (!empty($empleados)): ?>
                <?php foreach ($empleados as $emp): ?>
                  <option value="<?= esc($emp['Id_Empleado']) ?>">
                    <?= esc($emp['Id_Empleado'] . ' - ' . $emp['Nombres'] . ' ' . $emp['ApellidoP'] . ' ' . $emp['ApellidoM'] . ' (' . $emp['UserName'] . ')') ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="Id_activo">Equipo (Id_activo)</label>
            <select class="form-control" name="Id_activo" id="Id_activo" required>
              <option value="">Seleccione un equipo</option>
              <?php if (!empty($equipos)): ?>
                <?php foreach ($equipos as $eq): ?>
                  <option value="<?= esc($eq['Id_activo']) ?>">
                    <?= esc($eq['Id_activo'] . ' - ' . $eq['Nom_Activo'] . ($eq['Ip_equipo'] ? ' ('.$eq['Ip_equipo'].')' : '')) ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <small class="text-muted">
            Nota: la asignación se guarda en <b>usuario_equipo</b> con un <b>Id_EquipoUsuario</b> autoincremental.
          </small>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url(RECURSO_PANEL_DIST . '/js/adminlte.min.js') ?>"></script>
<script src="<?= base_url(RECURSO_PANEL_DIST . '/js/demo.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('success')): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Operación exitosa',
    text: '<?= esc(session()->getFlashdata('success')) ?>',
    confirmButtonText: 'Aceptar'
  });
</script>
<?php endif; ?>

<script>
  $(function () {

    // Nuevo (asignar)
    $('#btnNuevo').on('click', function () {
      $('#formAsignacion').attr('action', "<?= site_url('usuario-equipo/guardar') ?>");
      $('#modalTitle').text('Asignar equipo');
      $('#btnGuardar').text('Guardar');

      $('#Id_EquipoUsuario').val('');
      $('#Id_Empleado').val('');
      $('#Id_activo').val('');
    });

    // Editar (cambiar asignación)
    $('.btnEditar').on('click', function () {
      const id = $(this).data('id');
      const idEmpleado = $(this).data('id_empleado');
      const idActivo = $(this).data('id_activo');

      $('#formAsignacion').attr('action', "<?= site_url('usuario-equipo/actualizar') ?>/" + id);
      $('#modalTitle').text('Modificar asignación');
      $('#btnGuardar').text('Actualizar');

      $('#Id_EquipoUsuario').val(id);
      $('#Id_Empleado').val(idEmpleado);
      $('#Id_activo').val(idActivo);

      $('#modalAsignacion').modal('show');
    });

    // Eliminar con confirmación
    $('.btnEliminar').on('click', function (e) {
      e.preventDefault();
      const form = $(this).closest('form');

      Swal.fire({
        title: '¿Eliminar asignación?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });

  });
</script>

</body>
</html>
