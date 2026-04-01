<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>">
  <title>Usuarios</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_DIST . '/css/adminlte.min.css') ?>">
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
        <img src="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>" alt="Rassini Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?= base_url('Panel/index') ?>" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Inicio</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('empleado') ?>" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Usuarios</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('equipos') ?>" class="nav-link">
                <i class="nav-icon fas fa-desktop"></i>
                <p>Equipos de computo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('usuario-equipo') ?>" class="nav-link">
                <i class="nav-icon fas fa-link"></i>
                <p>Usuarios y equipos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('mantenimientos') ?>" class="nav-link">
                <i class="nav-icon fas fa-tools"></i>
                <p>Mantenimientos</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Usuarios</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url('Panel/index') ?>">Inicio</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
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

                <!-- HEADER (idéntico a Equipos) -->
                <div class="card-header">
                  <h3 class="card-title">Listado de usuarios</h3>

                  <div class="card-tools d-flex align-items-center">

                    <!-- Buscador (pegado a la derecha, a lado del botón) -->
                    <form action="<?= site_url('empleado') ?>" method="get" class="mr-2">
                      <div class="input-group input-group-sm" style="width: 220px;">
                        <input
                          type="text"
                          name="q"
                          class="form-control float-right"
                          placeholder="Buscar..."
                          value="<?= isset($q) ? esc($q) : '' ?>">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>

                    <!-- Botón nuevo -->
                    <button id="btnNuevo" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEmpleado">
                      <i class="fas fa-plus"></i> Nuevo usuario
                    </button>

                  </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width: 120px;">Clave</th>
                        <th>Nombre completo</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th style="width: 150px;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($empleados)): ?>
                        <?php foreach ($empleados as $emp): ?>
                          <tr>
                            <td><?= esc($emp['Id_Empleado']) ?></td>
                            <td><?= esc($emp['Nombres'] . ' ' . $emp['ApellidoP'] . ' ' . $emp['ApellidoM']) ?></td>
                            <td><?= esc($emp['UserName']) ?></td>
                            <td><?= esc($emp['Correo']) ?></td>
                            <td>
                              <button
                                type="button"
                                class="btn btn-sm btn-warning btnEditar"
                                data-id="<?= esc($emp['Id_Empleado']) ?>"
                                data-nombres="<?= esc($emp['Nombres']) ?>"
                                data-apellidop="<?= esc($emp['ApellidoP']) ?>"
                                data-apellidom="<?= esc($emp['ApellidoM']) ?>"
                                data-username="<?= esc($emp['UserName']) ?>"
                                data-correo="<?= esc($emp['Correo']) ?>">
                                <i class="fas fa-edit"></i>
                              </button>

                              <form action="<?= site_url('empleado/delete/' . $emp['Id_Empleado']) ?>" method="post" class="d-inline">
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
                          <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>

        </div>
      </section>
    </div>

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.1.2
      </div>
      <strong>Copyright &copy; 2025 <a href="https://www.rassini.com/frenos/">Rassini Frenos</a>.</strong>
      Todos los derechos reservados.
    </footer>
  </div>

  <!-- Modal Empleado -->
  <div class="modal fade" id="modalEmpleado" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formEmpleado" method="post" action="<?= site_url('empleado/store') ?>">
        <?= csrf_field() ?>

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Nuevo usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label for="Nombres">Nombres</label>
              <input type="text" class="form-control" name="Nombres" id="Nombres" required>
            </div>

            <div class="form-group">
              <label for="ApellidoP">Apellido paterno</label>
              <input type="text" class="form-control" name="ApellidoP" id="ApellidoP" required>
            </div>

            <div class="form-group">
              <label for="ApellidoM">Apellido materno</label>
              <input type="text" class="form-control" name="ApellidoM" id="ApellidoM" required>
            </div>

            <div class="form-group">
              <label for="UserName">Usuario</label>
              <input type="text" class="form-control" name="UserName" id="UserName" required>
            </div>

            <div class="form-group">
              <label for="Correo">Correo</label>
              <input type="email" class="form-control" name="Correo" id="Correo">
            </div>

            <div class="form-group">
              <label for="Password" id="lblPassword">Contraseña</label>
              <input type="password" class="form-control" name="Password" id="Password" required>
            </div>

            <div class="form-group">
              <label for="Password2" id="lblPassword2">Confirmar contraseña</label>
              <input type="password" class="form-control" name="Password2" id="Password2" required>
            </div>
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
    $(function() {
      // Nuevo usuario
      $('#btnNuevo').on('click', function() {
        $('#formEmpleado').attr('action', "<?= site_url('empleado/store') ?>");
        $('#modalTitle').text('Nuevo usuario');
        $('#btnGuardar').text('Guardar');

        $('#Nombres').val('');
        $('#ApellidoP').val('');
        $('#ApellidoM').val('');
        $('#UserName').val('');
        $('#Correo').val('');

        // Password requerido al crear
        $('#lblPassword').text('Contraseña');
        $('#lblPassword2').show();
        $('#Password2').closest('.form-group').show();
        $('#Password').prop('required', true).val('');
        $('#Password2').prop('required', true).val('');
      });

      // Editar usuario
      $('.btnEditar').on('click', function() {
        const id = $(this).data('id');

        $('#formEmpleado').attr('action', "<?= site_url('empleado/update') ?>/" + id);
        $('#modalTitle').text('Editar usuario');
        $('#btnGuardar').text('Actualizar');

        $('#Nombres').val($(this).data('nombres'));
        $('#ApellidoP').val($(this).data('apellidop'));
        $('#ApellidoM').val($(this).data('apellidom'));
        $('#UserName').val($(this).data('username'));
        $('#Correo').val($(this).data('correo'));

        // Password opcional al editar
        $('#lblPassword').text('Nueva contraseña (opcional)');
        $('#lblPassword2').hide();
        $('#Password2').closest('.form-group').hide();
        $('#Password').prop('required', false).val('');
        $('#Password2').prop('required', false).val('');

        $('#modalEmpleado').modal('show');
      });

      // Eliminar con confirmación
      $('.btnEliminar').on('click', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
          title: '¿Eliminar usuario?',
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