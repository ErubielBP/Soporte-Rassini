<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>">
  <title>Dashboard</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_DIST . '/css/adminlte.min.css') ?>">

  <!-- Sidebar no se afecta por contenido -->
  <style>
    html,
    body {
      height: 100%;
    }

    .main-sidebar {
      height: 100vh;
      overflow: hidden;
    }

    .main-sidebar .sidebar {
      height: calc(100vh - 57px);
      overflow-y: auto;
    }
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
              <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
            </div>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?= base_url('Panel/index') ?>" class="nav-link active">
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
    <!-- /.sidebar -->

    <!-- Content -->
    <div class="content-wrapper">

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url('Panel/index') ?>">Inicio</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">

          <?php
          $kpis = $kpis ?? [
            'usuarios' => 0,
            'equipos' => 0,
            'asignaciones' => 0,
            'mantenimientos' => 0,
            'mantenimientos_mes' => 0,
            'mes_objetivo' => 20
          ];

          $obj = (int)($kpis['mes_objetivo'] ?? 20);
          if ($obj <= 0) $obj = 20;
          $mes = (int)($kpis['mantenimientos_mes'] ?? 0);
          $porc = (int) round(min(100, ($mes / $obj) * 100));
          ?>

          <!-- KPI Boxes -->
          <div class="row">

            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= esc($kpis['usuarios']) ?></h3>
                  <p>Usuarios registrados</p>
                </div>
                <div class="icon">
                  <i class="fas fa-users"></i>
                </div>
                <a href="<?= base_url('empleado') ?>" class="small-box-footer">
                  Ir a usuarios <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?= esc($kpis['equipos']) ?></h3>
                  <p>Equipos registrados</p>
                </div>
                <div class="icon">
                  <i class="fas fa-desktop"></i>
                </div>
                <a href="<?= base_url('equipos') ?>" class="small-box-footer">
                  Ir a equipos <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?= esc($kpis['asignaciones']) ?></h3>
                  <p>Asignaciones activas</p>
                </div>
                <div class="icon">
                  <i class="fas fa-link"></i>
                </div>
                <a href="<?= base_url('usuario-equipo') ?>" class="small-box-footer">
                  Ir a asignaciones <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= esc($kpis['mantenimientos']) ?></h3>
                  <p>Mantenimientos totales</p>
                </div>
                <div class="icon">
                  <i class="fas fa-tools"></i>
                </div>
                <a href="<?= base_url('mantenimientos') ?>" class="small-box-footer">
                  Ir a mantenimientos <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

          </div>

          <!-- Progress + Quick actions -->
          <div class="row">

            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Actividad del mes</h3>
                  <div class="card-tools">
                    <span class="badge badge-info">Objetivo: <?= esc($obj) ?> mantenimientos</span>
                  </div>
                </div>

                <div class="card-body">
                  <p class="mb-2">
                    Mantenimientos registrados este mes: <b><?= esc($mes) ?></b> / <?= esc($obj) ?> (<?= esc($porc) ?>%)
                  </p>

                  <div class="progress progress-sm">
                    <div class="progress-bar" role="progressbar"
                      aria-valuenow="<?= esc($porc) ?>" aria-valuemin="0" aria-valuemax="100"
                      style="width: <?= esc($porc) ?>%;">
                    </div>
                  </div>

                  <hr>

                  <div class="row text-center">
                    <div class="col-sm-4">
                      <a href="<?= base_url('mantenimientos') ?>" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-plus"></i> Registrar mantenimiento
                      </a>
                    </div>
                    <div class="col-sm-4">
                      <a href="<?= base_url('equipos') ?>" class="btn btn-success btn-sm btn-block">
                        <i class="fas fa-desktop"></i> Registrar equipo
                      </a>
                    </div>
                    <div class="col-sm-4">
                      <a href="<?= base_url('usuario-equipo') ?>" class="btn btn-warning btn-sm btn-block">
                        <i class="fas fa-link"></i> Asignar equipo
                      </a>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card card-outline card-primary">
                <div class="card-header">
                  <h3 class="card-title">Resumen rápido</h3>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Usuarios</b> <span class="float-right"><?= esc($kpis['usuarios']) ?></span>
                    </li>
                    <li class="list-group-item">
                      <b>Equipos</b> <span class="float-right"><?= esc($kpis['equipos']) ?></span>
                    </li>
                    <li class="list-group-item">
                      <b>Asignaciones</b> <span class="float-right"><?= esc($kpis['asignaciones']) ?></span>
                    </li>
                    <li class="list-group-item">
                      <b>Mantenimientos</b> <span class="float-right"><?= esc($kpis['mantenimientos']) ?></span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

          </div>

          <!-- Tables -->
          <div class="row">

            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Últimos mantenimientos</h3>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 380px;">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 110px;">ID</th>
                        <th style="width: 120px;">Fecha</th>
                        <th style="width: 170px;">Tipo</th>
                        <th>Equipo</th>
                        <th>Técnico</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($ultimosSoportes)): ?>
                        <?php foreach ($ultimosSoportes as $s): ?>
                          <tr>
                            <td><?= esc($s['Id_Soporte']) ?></td>
                            <td><?= esc($s['Fecha_Entrega']) ?></td>
                            <td><?= esc($s['Tipo_Soporte']) ?></td>
                            <td><?= esc(($s['Nom_Activo'] ?? '') . (($s['Ip_equipo'] ?? '') ? ' (' . $s['Ip_equipo'] . ')' : '')) ?></td>
                            <td><?= esc($s['TecnicoNombre'] ?? '') ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="5" class="text-center">Sin registros recientes.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer text-right">
                  <a href="<?= base_url('mantenimientos') ?>" class="btn btn-sm btn-primary">
                    Ver todos <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Top equipos con más mantenimientos</h3>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 380px;">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 120px;">Id_activo</th>
                        <th>Equipo</th>
                        <th style="width: 110px;">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($topEquipos)): ?>
                        <?php foreach ($topEquipos as $e): ?>
                          <tr>
                            <td><?= esc($e['Id_activo']) ?></td>
                            <td><?= esc($e['Nom_Activo'] ?? '') ?></td>
                            <td><span class="badge badge-danger"><?= esc($e['total']) ?></span></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="3" class="text-center">Sin datos.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Top técnicos más activos</h3>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 320px;">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 140px;">Id_Técnico</th>
                        <th>Técnico</th>
                        <th style="width: 110px;">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($topTecnicos)): ?>
                        <?php foreach ($topTecnicos as $t): ?>
                          <tr>
                            <td><?= esc($t['Id_EmpleadoTec']) ?></td>
                            <td><?= esc($t['TecnicoNombre'] ?? '') ?></td>
                            <td><span class="badge badge-success"><?= esc($t['total']) ?></span></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="3" class="text-center">Sin datos.</td>
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

  <script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url(RECURSO_PANEL_DIST . '/js/adminlte.min.js') ?>"></script>
  <script src="<?= base_url(RECURSO_PANEL_DIST . '/js/demo.js') ?>"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php if (session()->getFlashdata('success')): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: '¡Bienvenido!',
        text: '<?= esc(session()->getFlashdata('success')) ?>',
        confirmButtonText: 'Continuar'
      });
    </script>
  <?php endif; ?>
</body>

</html>