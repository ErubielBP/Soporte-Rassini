<?php

namespace App\Models;

use CodeIgniter\Model;

class SoporteModel extends Model
{
    protected $table            = 'soporte';
    protected $primaryKey       = 'Id_Soporte';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'Fecha_Entrega',
        'Fecha_Devolucion',
        'Tipo_Soporte',
        'Descripcion',
        'Id_EmpleadoTec',
        'Id_activo',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'Fecha_Entrega'    => 'required|valid_date',
        'Fecha_Devolucion' => 'permit_empty|valid_date',
        'Tipo_Soporte'     => 'required|in_list[Preventivo,Correctivo,Sistema Operativo,Otros(Especificar)]',
        'Descripcion'      => 'permit_empty|max_length[2000]',
        'Id_EmpleadoTec'   => 'required|is_natural_no_zero',
        'Id_activo'        => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'Fecha_Entrega' => [
            'required'   => 'La fecha de entrega es obligatoria.',
            'valid_date' => 'La fecha de entrega no es válida.',
        ],
        'Fecha_Devolucion' => [
            'valid_date' => 'La fecha de devolución no es válida.',
        ],
        'Tipo_Soporte' => [
            'required' => 'El tipo de soporte es obligatorio.',
            'in_list'  => 'El tipo de soporte no es válido.',
        ],
        'Descripcion' => [
            'max_length' => 'La descripción es demasiado larga.',
        ],
        'Id_EmpleadoTec' => [
            'required' => 'El técnico es obligatorio.',
            'is_natural_no_zero' => 'El técnico seleccionado no es válido.',
        ],
        'Id_activo' => [
            'required' => 'El equipo es obligatorio.',
            'is_natural_no_zero' => 'El equipo seleccionado no es válido.',
        ],
    ];

    /**
     * Lista soportes con JOIN para mostrar Técnico y Equipo.
     */
    public function listarConJoin(): array
    {
        return $this->db->table('soporte s')
            ->select("
                s.Id_Soporte,
                s.Fecha_Entrega,
                s.Fecha_Devolucion,
                s.Tipo_Soporte,
                s.Descripcion,
                s.Id_EmpleadoTec,
                s.Id_activo,
                CONCAT(e.Nombres,' ',e.ApellidoP,' ',e.ApellidoM,' (',e.UserName,')') AS TecnicoNombre,
                ec.Nom_Activo,
                ec.Ip_equipo
            ")
            ->join('tecnico t', 't.Id_Empleado = s.Id_EmpleadoTec', 'inner')
            ->join('empleado e', 'e.Id_Empleado = t.Id_Empleado', 'inner')
            ->join('equipo_computo ec', 'ec.Id_activo = s.Id_activo', 'inner')
            ->orderBy('s.Id_Soporte', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Búsqueda con JOIN.
     */
    public function buscarConJoin(string $q): array
    {
        $q = trim($q);

        $builder = $this->db->table('soporte s')
            ->select("
                s.Id_Soporte,
                s.Fecha_Entrega,
                s.Fecha_Devolucion,
                s.Tipo_Soporte,
                s.Descripcion,
                s.Id_EmpleadoTec,
                s.Id_activo,
                CONCAT(e.Nombres,' ',e.ApellidoP,' ',e.ApellidoM,' (',e.UserName,')') AS TecnicoNombre,
                ec.Nom_Activo,
                ec.Ip_equipo
            ")
            ->join('tecnico t', 't.Id_Empleado = s.Id_EmpleadoTec', 'inner')
            ->join('empleado e', 'e.Id_Empleado = t.Id_Empleado', 'inner')
            ->join('equipo_computo ec', 'ec.Id_activo = s.Id_activo', 'inner');

        $builder->groupStart()
            ->like('e.Nombres', $q)
            ->orLike('e.ApellidoP', $q)
            ->orLike('e.ApellidoM', $q)
            ->orLike('e.UserName', $q)
            ->orLike('ec.Nom_Activo', $q)
            ->orLike('ec.Ip_equipo', $q)
            ->orLike('s.Tipo_Soporte', $q);

        if (ctype_digit($q)) {
            $builder->orWhere('s.Id_Soporte', (int)$q)
                    ->orWhere('s.Id_EmpleadoTec', (int)$q)
                    ->orWhere('s.Id_activo', (int)$q);
        }

        $builder->groupEnd();

        return $builder->orderBy('s.Id_Soporte', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Validación de existencia real para evitar errores por FK.
     * - Técnico debe existir en tabla tecnico.
     * - Equipo debe existir en equipo_computo.
     */
    public function existenTecnicoYEquipo(int $idTecnico, int $idActivo): bool
    {
        $existeTec = $this->db->table('tecnico')->where('Id_Empleado', $idTecnico)->countAllResults() > 0;
        if (!$existeTec) return false;

        $existeEq = $this->db->table('equipo_computo')->where('Id_activo', $idActivo)->countAllResults() > 0;
        return $existeEq;
    }
}
