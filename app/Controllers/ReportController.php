<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function usuarios()
    {
        $usuarios = $this->userModel->findAll();

        return view('report/users', ['usuarios' => $usuarios]);
    }

    public function exportUsuarios()
    {
        $usuarios = $this->userModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usuarios');

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre Completo');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Teléfono');
        $sheet->setCellValue('E1', 'Sexo');
        $sheet->setCellValue('F1', 'Estatus');
        $sheet->setCellValue('G1', 'Fecha Registro');

        $row = 2;
        foreach ($usuarios as $usuario) {
            $sheet->setCellValue("A{$row}", $usuario['id']);
            $sheet->setCellValue("B{$row}", $usuario['nombre'] . ' ' . $usuario['apellidos']);
            $sheet->setCellValue("C{$row}", $usuario['email']);
            $sheet->setCellValue("D{$row}", $usuario['telefono']);
            $sheet->setCellValue("E{$row}", $usuario['sexo']);
            $sheet->setCellValue("F{$row}", ucfirst($usuario['estatus']));
            $sheet->setCellValue("G{$row}", date('d/m/Y', strtotime($usuario['fecha_registro'])));
            $row++;
        }

        $filename = 'usuarios_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
