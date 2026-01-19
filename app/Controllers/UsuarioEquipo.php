<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioEquipoModel;
use App\Models\EmpleadoModel;
use App\Models\EquipoComputoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class UsuarioEquipo extends BaseController
{
    protected $usuarioEquipoModel;
    protected $empleadoModel;
    protected $equipoModel;

    public function __construct()
    {
        $this->usuarioEquipoModel = new UsuarioEquipoModel();
        $this->empleadoModel      = new EmpleadoModel();
        $this->equipoModel        = new EquipoComputoModel();

        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'asignaciones' => $this->usuarioEquipoModel->listarConJoin(),
            'empleados'    => $this->empleadoModel->orderBy('Id_Empleado', 'DESC')->findAll(),
            'equipos'      => $this->equipoModel->orderBy('Id_activo', 'DESC')->findAll(),
            'q'            => null,
        ];

        return view('Panel/UsuarioEquipo', $data);
    }

    public function buscar()
    {
        $q = (string) $this->request->getGet('q');

        $data = [
            'asignaciones' => $this->usuarioEquipoModel->buscarConJoin($q),
            'empleados'    => $this->empleadoModel->orderBy('Id_Empleado', 'DESC')->findAll(),
            'equipos'      => $this->equipoModel->orderBy('Id_activo', 'DESC')->findAll(),
            'q'            => $q,
        ];

        return view('Panel/UsuarioEquipo', $data);
    }

    public function guardar()
    {
        $idEmpleado = (int) $this->request->getPost('Id_Empleado');
        $idActivo   = (int) $this->request->getPost('Id_activo');

        $rules = [
            'Id_Empleado' => 'required|is_natural_no_zero',
            'Id_activo'   => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Validar existencia (evitar error por FK)
        if (!$this->usuarioEquipoModel->existenEmpleadoYEquipo($idEmpleado, $idActivo)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['La asignación no se pudo guardar porque el empleado o el equipo no existe.']);
        }

        $this->usuarioEquipoModel->insert([
            'Id_Empleado' => $idEmpleado,
            'Id_activo'   => $idActivo,
        ]);

        return redirect()->to(site_url('usuario-equipo'))
            ->with('success', 'Asignación registrada correctamente.');
    }

    public function actualizar($id = null)
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound('Asignación no encontrada.');
        }

        $asig = $this->usuarioEquipoModel->find($id);
        if (!$asig) {
            throw PageNotFoundException::forPageNotFound('Asignación no encontrada.');
        }

        $idEmpleado = (int) $this->request->getPost('Id_Empleado');
        $idActivo   = (int) $this->request->getPost('Id_activo');

        $rules = [
            'Id_Empleado' => 'required|is_natural_no_zero',
            'Id_activo'   => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        if (!$this->usuarioEquipoModel->existenEmpleadoYEquipo($idEmpleado, $idActivo)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['La asignación no se pudo actualizar porque el empleado o el equipo no existe.']);
        }

        $this->usuarioEquipoModel->update($id, [
            'Id_Empleado' => $idEmpleado,
            'Id_activo'   => $idActivo,
        ]);

        return redirect()->to(site_url('usuario-equipo'))
            ->with('success', 'Asignación actualizada correctamente.');
    }

    public function eliminar($id = null)
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound('Asignación no encontrada.');
        }

        if (!$this->usuarioEquipoModel->find($id)) {
            throw PageNotFoundException::forPageNotFound('Asignación no encontrada.');
        }

        $this->usuarioEquipoModel->delete($id);

        return redirect()->to(site_url('usuario-equipo'))
            ->with('success', 'Asignación eliminada correctamente.');
    }
}
