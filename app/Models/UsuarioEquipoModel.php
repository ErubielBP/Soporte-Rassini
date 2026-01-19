<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioEquipoModel extends Model
{
    protected $table            = 'usuario_equipo';
    protected $primaryKey       = 'Id_EquipoUsuario';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'Id_Empleado',
        'Id_activo',
    ];

    protected $useTimestamps    = false;

    // Validación básica
    protected $validationRules = [
        'Id_Empleado' => 'required|is_natural_no_zero',
        'Id_activo'   => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'Id_Empleado' => [
            'required' => 'El usuario es obligatorio.',
            'is_natural_no_zero' => 'El usuario seleccionado no es válido.',
        ],
        'Id_activo' => [
            'required' => 'El equipo es obligatorio.',
            'is_natural_no_zero' => 'El equipo seleccionado no es válido.',
        ],
    ];

    /**
     * Lista con JOIN para mostrar nombre de empleado y datos del equipo.
     */
    public function listarConJoin()
    {
        return $this->db->table('usuario_equipo ue')
            ->select("
                ue.Id_EquipoUsuario,
                ue.Id_Empleado,
                ue.Id_activo,
                CONCAT(e.Nombres,' ',e.ApellidoP,' ',e.ApellidoM,' (',e.UserName,')') AS EmpleadoNombre,
                ec.Nom_Activo,
                ec.Ip_equipo
            ")
            ->join('empleado e', 'e.Id_Empleado = ue.Id_Empleado', 'inner')
            ->join('equipo_computo ec', 'ec.Id_activo = ue.Id_activo', 'inner')
            ->orderBy('ue.Id_EquipoUsuario', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Búsqueda con JOIN.
     */
    public function buscarConJoin(string $q)
    {
        $q = trim($q);

        $builder = $this->db->table('usuario_equipo ue')
            ->select("
                ue.Id_EquipoUsuario,
                ue.Id_Empleado,
                ue.Id_activo,
                CONCAT(e.Nombres,' ',e.ApellidoP,' ',e.ApellidoM,' (',e.UserName,')') AS EmpleadoNombre,
                ec.Nom_Activo,
                ec.Ip_equipo
            ")
            ->join('empleado e', 'e.Id_Empleado = ue.Id_Empleado', 'inner')
            ->join('equipo_computo ec', 'ec.Id_activo = ue.Id_activo', 'inner');

        // Agrupar OR LIKE para no romper el query
        $builder->groupStart()
            ->like('e.Nombres', $q)
            ->orLike('e.ApellidoP', $q)
            ->orLike('e.ApellidoM', $q)
            ->orLike('e.UserName', $q)
            ->orLike('ec.Nom_Activo', $q)
            ->orLike('ec.Ip_equipo', $q);

        // Si es número, buscar por IDs también
        if (ctype_digit($q)) {
            $builder->orWhere('ue.Id_Empleado', (int)$q)
                    ->orWhere('ue.Id_activo', (int)$q)
                    ->orWhere('ue.Id_EquipoUsuario', (int)$q);
        }

        $builder->groupEnd();

        return $builder->orderBy('ue.Id_EquipoUsuario', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Verifica que existan empleado y equipo (FK) antes de insertar/actualizar.
     */
    public function existenEmpleadoYEquipo(int $idEmpleado, int $idActivo): bool
    {
        $existeEmp = $this->db->table('empleado')->where('Id_Empleado', $idEmpleado)->countAllResults() > 0;
        if (!$existeEmp) return false;

        $existeEq = $this->db->table('equipo_computo')->where('Id_activo', $idActivo)->countAllResults() > 0;
        return $existeEq;
    }
}
