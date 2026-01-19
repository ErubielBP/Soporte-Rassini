<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Panel extends BaseController
{
    public function index()
    {
        $db = db_connect();

        /* ===============================
         * KPIs PRINCIPALES
         * =============================== */
        $kpis = [
            'usuarios'       => $db->table('empleado')->countAllResults(),
            'equipos'        => $db->table('equipo_computo')->countAllResults(),
            'asignaciones'   => $db->table('usuario_equipo')->countAllResults(),
            'mantenimientos' => $db->table('soporte')->countAllResults(),
        ];

        /* ===============================
         * MANTENIMIENTOS DEL MES
         * =============================== */
        $mesActual  = date('m');
        $anioActual = date('Y');

        $kpis['mantenimientos_mes'] = $db->table('soporte')
            ->where('MONTH(Fecha_Entrega)', $mesActual, false)
            ->where('YEAR(Fecha_Entrega)', $anioActual, false)
            ->countAllResults();

        // Meta mensual configurable
        $kpis['mes_objetivo'] = 10;

        /* ===============================
         * ÚLTIMOS MANTENIMIENTOS
         * =============================== */
        $ultimosSoportes = $db->table('soporte s')
            ->select("
                s.Id_Soporte,
                s.Fecha_Entrega,
                s.Tipo_Soporte,
                ec.Nom_Activo,
                ec.Ip_equipo,
                CONCAT(
                    e.Nombres, ' ',
                    e.ApellidoP, ' ',
                    e.ApellidoM, ' (', e.UserName, ')'
                ) AS TecnicoNombre
            ")
            ->join('equipo_computo ec', 'ec.Id_activo = s.Id_activo', 'inner')
            ->join('tecnico t', 't.Id_Empleado = s.Id_EmpleadoTec', 'inner')
            ->join('empleado e', 'e.Id_Empleado = t.Id_Empleado', 'inner')
            ->orderBy('s.Id_Soporte', 'DESC')
            ->limit(8)
            ->get()
            ->getResultArray();

        /* ===============================
         * TOP EQUIPOS CON MÁS SOPORTES
         * =============================== */
        $topEquipos = $db->table('soporte s')
            ->select('
                s.Id_activo,
                ec.Nom_Activo,
                COUNT(*) AS total
            ')
            ->join('equipo_computo ec', 'ec.Id_activo = s.Id_activo', 'inner')
            ->groupBy('s.Id_activo')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        /* ===============================
         * TOP TÉCNICOS MÁS ACTIVOS
         * =============================== */
        $topTecnicos = $db->table('soporte s')
            ->select("
                s.Id_EmpleadoTec,
                CONCAT(
                    e.Nombres, ' ',
                    e.ApellidoP, ' ',
                    e.ApellidoM, ' (', e.UserName, ')'
                ) AS TecnicoNombre,
                COUNT(*) AS total
            ")
            ->join('tecnico t', 't.Id_Empleado = s.Id_EmpleadoTec', 'inner')
            ->join('empleado e', 'e.Id_Empleado = t.Id_Empleado', 'inner')
            ->groupBy('s.Id_EmpleadoTec')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        /* ===============================
         * CARGAR DASHBOARD
         * =============================== */
        return view('Panel/index', [
            'kpis'            => $kpis,
            'ultimosSoportes' => $ultimosSoportes,
            'topEquipos'      => $topEquipos,
            'topTecnicos'     => $topTecnicos,
        ]);
    }
}
