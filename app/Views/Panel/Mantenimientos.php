<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>">
  <title>Mantenimientos</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/fontawesome-free/css/all.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_DIST . '/css/adminlte.min.css') ?>">

  <!-- Sidebar sin “crecer” por contenido -->
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
            <a href="<?= base_url('usuario-equipo') ?>" class="nav-link">
              <i class="nav-icon fas fa-link"></i><p>Usuarios y equipos</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('mantenimientos') ?>" class="nav-link active">
              <i class="nav-icon fas fa-tools"></i><p>Mantenimientos</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <!-- /.sidebar -->

  <!-- Content -->
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mantenimientos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('Panel/index') ?>">Inicio</a></li>
              <li class="breadcrumb-item active">Mantenimientos</li>
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
                <h3 class="card-title">Listado de mantenimientos (soporte)</h3>

                <div class="card-tools d-flex align-items-center">

                  <!-- Buscador -->
                  <form action="<?= site_url('mantenimientos/buscar') ?>" method="get" class="mr-2">
                    <div class="input-group input-group-sm" style="width: 260px;">
                      <input
                        type="text"
                        name="q"
                        class="form-control"
                        placeholder="Buscar por técnico, equipo, IP..."
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
                  <button id="btnNuevo" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalSoporte">
                    <i class="fas fa-plus"></i> Nuevo mantenimiento
                  </button>

                </div>
              </div>

              <div class="card-body table-responsive p-0" style="max-height: calc(100vh - 260px);">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width: 120px;">Id_Soporte</th>
                      <th style="width: 120px;">Entrega</th>
                      <th style="width: 120px;">Devolución</th>
                      <th style="width: 170px;">Tipo</th>
                      <th>Técnico</th>
                      <th>Equipo</th>
                      <th style="width: 140px;">IP</th>
                      <th style="width: 160px;">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($soportes)): ?>
                      <?php foreach ($soportes as $s): ?>
                        <tr>
                          <td><?= esc($s['Id_Soporte']) ?></td>
                          <td><?= esc($s['Fecha_Entrega']) ?></td>
                          <td><?= esc($s['Fecha_Devolucion'] ?? '') ?></td>
                          <td><?= esc($s['Tipo_Soporte']) ?></td>
                          <td><?= esc($s['TecnicoNombre'] ?? $s['Id_EmpleadoTec']) ?></td>
                          <td><?= esc($s['Nom_Activo'] ?? $s['Id_activo']) ?></td>
                          <td><?= esc($s['Ip_equipo'] ?? '') ?></td>
                          <td>
                            <button
                              type="button"
                              class="btn btn-sm btn-warning btnEditar"
                              data-id="<?= esc($s['Id_Soporte']) ?>"
                              data-fecha_entrega="<?= esc($s['Fecha_Entrega']) ?>"
                              data-fecha_devolucion="<?= esc($s['Fecha_Devolucion'] ?? '') ?>"
                              data-tipo="<?= esc($s['Tipo_Soporte']) ?>"
                              data-descripcion="<?= esc($s['Descripcion'] ?? '') ?>"
                              data-id_tecnico="<?= esc($s['Id_EmpleadoTec']) ?>"
                              data-id_activo="<?= esc($s['Id_activo']) ?>"
                            >
                              <i class="fas fa-edit"></i>
                            </button>

                            <form action="<?= site_url('mantenimientos/eliminar/' . $s['Id_Soporte']) ?>" method="post" class="d-inline">
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
                        <td colspan="8" class="text-center">No hay mantenimientos registrados.</td>
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
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.1.2
    </div>
    <strong>Copyright &copy; 2025 <a href="https://www.rassini.com/frenos/">Rassini Frenos</a>.</strong>
    Todos los derechos reservados.
  </footer>
</div>

<!-- Modal Soporte -->
<div class="modal fade" id="modalSoporte" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formSoporte" method="post" action="<?= site_url('mantenimientos/guardar') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="Id_Soporte" id="Id_Soporte" value="">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Nuevo mantenimiento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label for="Fecha_Entrega">Fecha de entrega</label>
            <input type="date" class="form-control" name="Fecha_Entrega" id="Fecha_Entrega" required>
          </div>

          <div class="form-group">
            <label for="Fecha_Devolucion">Fecha de devolución (opcional)</label>
            <input type="date" class="form-control" name="Fecha_Devolucion" id="Fecha_Devolucion">
          </div>

          <div class="form-group">
            <label for="Tipo_Soporte">Tipo de soporte</label>
            <select class="form-control" name="Tipo_Soporte" id="Tipo_Soporte" required>
              <option value="">Seleccione una opción</option>
              <option value="Preventivo">Preventivo</option>
              <option value="Correctivo">Correctivo</option>
              <option value="Sistema Operativo">Sistema Operativo</option>
              <option value="Otros(Especificar)">Otros(Especificar)</option>
            </select>
          </div>

          <div class="form-group">
            <label for="Descripcion">Descripción (opcional)</label>
            <textarea class="form-control" name="Descripcion" id="Descripcion" rows="3" placeholder="Detalle del mantenimiento..."></textarea>
          </div>

          <div class="form-group">
            <label for="Id_EmpleadoTec">Técnico que realizó el soporte</label>
            <select class="form-control" name="Id_EmpleadoTec" id="Id_EmpleadoTec" required>
              <option value="">Seleccione un técnico</option>
              <?php if (!empty($tecnicos)): ?>
                <?php foreach ($tecnicos as $t): ?>
                  <option value="<?= esc($t['Id_Empleado']) ?>">
                    <?= esc($t['Id_Empleado'] . ' - ' . $t['TecnicoNombre']) ?>
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

    // Nuevo mantenimiento
    $('#btnNuevo').on('click', function () {
      $('#formSoporte').attr('action', "<?= site_url('mantenimientos/guardar') ?>");
      $('#modalTitle').text('Nuevo mantenimiento');
      $('#btnGuardar').text('Guardar');

      $('#Id_Soporte').val('');
      $('#Fecha_Entrega').val('');
      $('#Fecha_Devolucion').val('');
      $('#Tipo_Soporte').val('');
      $('#Descripcion').val('');
      $('#Id_EmpleadoTec').val('');
      $('#Id_activo').val('');
    });

    // Editar mantenimiento
    $('.btnEditar').on('click', function () {
      const id = $(this).data('id');

      $('#formSoporte').attr('action', "<?= site_url('mantenimientos/actualizar') ?>/" + id);
      $('#modalTitle').text('Editar mantenimiento');
      $('#btnGuardar').text('Actualizar');

      $('#Id_Soporte').val(id);
      $('#Fecha_Entrega').val($(this).data('fecha_entrega'));
      $('#Fecha_Devolucion').val($(this).data('fecha_devolucion'));
      $('#Tipo_Soporte').val($(this).data('tipo'));
      $('#Descripcion').val($(this).data('descripcion'));
      $('#Id_EmpleadoTec').val($(this).data('id_tecnico'));
      $('#Id_activo').val($(this).data('id_activo'));

      $('#modalSoporte').modal('show');
    });

    // Eliminar con confirmación
    $('.btnEliminar').on('click', function (e) {
      e.preventDefault();
      const form = $(this).closest('form');

      Swal.fire({
        title: '¿Eliminar mantenimiento?',
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
