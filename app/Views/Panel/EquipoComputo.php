<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>">
  <title>Equipos de Cómputo</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/fontawesome-free/css/all.min.css') ?>">

  <!-- Theme style -->
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

    <!-- Main Sidebar Container -->
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
              <a href="<?= base_url('') ?>" class="nav-link">
                <i class="nav-icon fas fa-tools"></i>
                <p>Mantenimientos</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Equipos de Cómputo</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url('Panel/index') ?>">Inicio</a></li>


                <li class="breadcrumb-item active">Equipos de Cómputo</li>


              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">

          <?php if (session('errors')): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                  <li><?= esc($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
              <?= esc(session()->getFlashdata('success')) ?>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-12">
              <div class="card">

                <!-- CABECERA DE LA TARJETA -->
                <div class="card-header">
                  <h3 class="card-title">Listado de equipos de cómputo</h3>

                  <!-- Herramientas alineadas a la derecha -->
                  <div class="card-tools d-flex align-items-center">

                    <!-- Buscador (lupa) -->
                    <form action="<?= site_url('equipos') ?>" method="get" class="mr-2">
                      <div class="input-group input-group-sm" style="width: 200px;">
                        <input
                          type="text"
                          name="q"
                          class="form-control"
                          placeholder="Buscar..."
                          value="<?= isset($q) ? esc($q) : '' ?>">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>

                    <!-- Botón nuevo equipo -->
                    <button id="btnNuevo" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEquipo">
                      <i class="fas fa-plus"></i> Nuevo equipo
                    </button>

                  </div>
                </div>

                <!-- /.card-header -->

                <div class="card-body table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width: 100px;">Activo fijo</th>
                        <th>Nombre del activo</th>
                        <th>IP del equipo</th>
                        <th style="width: 150px;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (! empty($equipos)): ?>
                        <?php foreach ($equipos as $equipo): ?>
                          <tr>
                            <td><?= esc($equipo['Id_activo']) ?></td>
                            <td><?= esc($equipo['Nom_Activo']) ?></td>
                            <td><?= esc($equipo['Ip_equipo']) ?></td>
                            <td>
                              <button
                                type="button"
                                class="btn btn-sm btn-warning btnEditar"
                                data-id="<?= esc($equipo['Id_activo']) ?>"
                                data-nombre="<?= esc($equipo['Nom_Activo']) ?>"
                                data-ip="<?= esc($equipo['Ip_equipo']) ?>">
                                <i class="fas fa-edit"></i>
                              </button>

                              <form action="<?= site_url('equipos/eliminar/' . $equipo['Id_activo']) ?>" method="post" class="d-inline">
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
                          <td colspan="4" class="text-center">No hay equipos registrados.</td>
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
        <b>Version</b> 1.1.2
      </div>
      <strong>Copyright &copy; 2025 <a href="https://www.rassini.com/frenos/">Rassini Frenos</a>.</strong> Todos los derechos reservados.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- Modal para crear/editar equipo -->
  <div class="modal fade" id="modalEquipo" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formEquipo" method="post" action="<?= site_url('equipos/guardar') ?>">
        <?= csrf_field() ?>

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Nuevo equipo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <div class="form-group">
              <label for="Id_activo">Activo fijo (Id_activo)</label>
              <input
                type="number"
                class="form-control"
                name="Id_activo"
                id="Id_activo"
                min="1"
                required
                value="<?= old('Id_activo') ?>">
            </div>

            <div class="form-group">
              <label for="Nom_Activo">Nombre del activo</label>
              <input
                type="text"
                class="form-control"
                name="Nom_Activo"
                id="Nom_Activo"
                maxlength="80"
                required
                value="<?= old('Nom_Activo') ?>">
            </div>

            <div class="form-group">
              <label for="Ip_equipo">IP del equipo (opcional)</label>
              <input
                type="text"
                class="form-control"
                name="Ip_equipo"
                id="Ip_equipo"
                value="<?= old('Ip_equipo') ?>"
                placeholder="Ejemplo: 192.168.1.10">
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
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
      // Nuevo equipo
      $('#btnNuevo').on('click', function() {
        $('#formEquipo').attr('action', "<?= site_url('equipos/guardar') ?>");
        $('#modalTitle').text('Nuevo equipo');

        $('#Id_activo').val('');
        $('#Nom_Activo').val('');
        $('#Ip_equipo').val('');
      });

      // Editar equipo
      $('.btnEditar').on('click', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const ip = $(this).data('ip');

        $('#formEquipo').attr('action', "<?= site_url('equipos/actualizar') ?>/" + id);
        $('#modalTitle').text('Editar equipo');

        $('#Id_activo').val(id);
        $('#Nom_Activo').val(nombre);
        $('#Ip_equipo').val(ip);

        $('#modalEquipo').modal('show');
      });

      // Eliminar equipo con confirmación
      $('.btnEliminar').on('click', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
          title: '¿Eliminar equipo?',
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