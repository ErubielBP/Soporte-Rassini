<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SoporteModel;
use App\Models\EquipoComputoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Mantenimientos extends BaseController
{
    protected $soporteModel;
    protected $equipoModel;
    protected $db;

    public function __construct()
    {
        $this->soporteModel = new SoporteModel();
        $this->equipoModel  = new EquipoComputoModel();
        $this->db           = db_connect();

        helper(['form', 'url']);
    }

    /**
     * Lista de técnicos SIN model extra:
     * tecnico -> empleado para nombre
     */
    private function obtenerTecnicos(): array
    {
        return $this->db->table('tecnico t')
            ->select("
                t.Id_Empleado,
                CONCAT(e.Nombres,' ',e.ApellidoP,' ',e.ApellidoM,' (',e.UserName,')') AS TecnicoNombre,
                r.Tipo_Rol
            ")
            ->join('empleado e', 'e.Id_Empleado = t.Id_Empleado', 'inner')
            ->join('rol r', 'r.Id_Rol = t.Id_Rol', 'inner')
            ->orderBy('e.Nombres', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function index()
    {
        $data = [
            'soportes' => $this->soporteModel->listarConJoin(),
            'tecnicos' => $this->obtenerTecnicos(),
            'equipos'  => $this->equipoModel->orderBy('Id_activo', 'DESC')->findAll(),
            'q'        => null,
        ];

        return view('Panel/Mantenimientos', $data);
    }

    public function buscar()
    {
        $q = (string) $this->request->getGet('q');

        $data = [
            'soportes' => $this->soporteModel->buscarConJoin($q),
            'tecnicos' => $this->obtenerTecnicos(),
            'equipos'  => $this->equipoModel->orderBy('Id_activo', 'DESC')->findAll(),
            'q'        => $q,
        ];

        return view('Panel/Mantenimientos', $data);
    }

    public function guardar()
    {
        $rules = [
            'Fecha_Entrega'    => 'required|valid_date',
            'Fecha_Devolucion' => 'permit_empty|valid_date',
            'Tipo_Soporte'     => 'required|in_list[Preventivo,Correctivo,Sistema Operativo,Otros(Especificar)]',
            'Descripcion'      => 'permit_empty|max_length[2000]',
            'Id_EmpleadoTec'   => 'required|is_natural_no_zero',
            'Id_activo'        => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idTecnico = (int) $this->request->getPost('Id_EmpleadoTec');
        $idActivo  = (int) $this->request->getPost('Id_activo');

        if (!$this->soporteModel->existenTecnicoYEquipo($idTecnico, $idActivo)) {
            return redirect()->back()->withInput()->with('errors', [
                'No se puede guardar: el técnico seleccionado no existe en la tabla "tecnico" o el equipo no existe.'
            ]);
        }

        $this->soporteModel->insert([
            'Fecha_Entrega'    => $this->request->getPost('Fecha_Entrega'),
            'Fecha_Devolucion' => $this->request->getPost('Fecha_Devolucion') ?: null,
            'Tipo_Soporte'     => $this->request->getPost('Tipo_Soporte'),
            'Descripcion'      => $this->request->getPost('Descripcion') ?: null,
            'Id_EmpleadoTec'   => $idTecnico,
            'Id_activo'        => $idActivo,
        ]);

        return redirect()->to(site_url('mantenimientos'))
            ->with('success', 'Mantenimiento registrado correctamente.');
    }

    public function actualizar($id = null)
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound('Mantenimiento no encontrado.');
        }

        $row = $this->soporteModel->find($id);
        if (!$row) {
            throw PageNotFoundException::forPageNotFound('Mantenimiento no encontrado.');
        }

        $rules = [
            'Fecha_Entrega'    => 'required|valid_date',
            'Fecha_Devolucion' => 'permit_empty|valid_date',
            'Tipo_Soporte'     => 'required|in_list[Preventivo,Correctivo,Sistema Operativo,Otros(Especificar)]',
            'Descripcion'      => 'permit_empty|max_length[2000]',
            'Id_EmpleadoTec'   => 'required|is_natural_no_zero',
            'Id_activo'        => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idTecnico = (int) $this->request->getPost('Id_EmpleadoTec');
        $idActivo  = (int) $this->request->getPost('Id_activo');

        if (!$this->soporteModel->existenTecnicoYEquipo($idTecnico, $idActivo)) {
            return redirect()->back()->withInput()->with('errors', [
                'No se puede actualizar: el técnico seleccionado no existe en la tabla "tecnico" o el equipo no existe.'
            ]);
        }

        $this->soporteModel->update($id, [
            'Fecha_Entrega'    => $this->request->getPost('Fecha_Entrega'),
            'Fecha_Devolucion' => $this->request->getPost('Fecha_Devolucion') ?: null,
            'Tipo_Soporte'     => $this->request->getPost('Tipo_Soporte'),
            'Descripcion'      => $this->request->getPost('Descripcion') ?: null,
            'Id_EmpleadoTec'   => $idTecnico,
            'Id_activo'        => $idActivo,
        ]);

        return redirect()->to(site_url('mantenimientos'))
            ->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function eliminar($id = null)
    {
        if ($id === null || !$this->soporteModel->find($id)) {
            throw PageNotFoundException::forPageNotFound('Mantenimiento no encontrado.');
        }

        $this->soporteModel->delete($id);

        return redirect()->to(site_url('mantenimientos'))
            ->with('success', 'Mantenimiento eliminado correctamente.');
    }
}
