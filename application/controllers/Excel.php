<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/third_party/phpoffice/autoload.php";

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');
    }

    public function excel() {

        $fecha = new DateTime();
        $fecha->format('Y-m-d H:i:s');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $cont = 1;
        $num = 1;


        $datos = array(
            'estado_nombre' => 'EN PROCESO'
        );

        $estados = $this->Modelo->getEstadosExcel($datos);

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 10,
            ],
        ];

        $estiloBorde = [
            'font' => [
                'bold' => true,
                'size' => 10,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],  
        ];

        $borde = [
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'size' => 8,
            ],
        ];

        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(FALSE);



        $spreadsheet->getActiveSheet()->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
//        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        $sheet->getCell('A' . $cont)->setValue('N°');
        $sheet->getCell('B' . $cont)->setValue('RUT');
        $sheet->getCell('C' . $cont)->setValue('APELLIDO');
        $sheet->getCell('D' . $cont)->setValue('NOMBRE');
        $sheet->getCell('E' . $cont)->setValue('DEPTO');
        $sheet->getCell('F' . $cont)->setValue('CODIGO');
        $sheet->getCell('G' . $cont)->setValue('NOMBRE DOC');
        $sheet->getCell('H' . $cont)->setValue('FECHA INGRESO');
        $sheet->getCell('I' . $cont)->setValue('FECHA ACTUAL');
        $sheet->getCell('J' . $cont)->setValue('RETRASO');

        $spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setWrapText(true);





        foreach ($estados as $estado) {
            $cont++;

            $spreadsheet->getActiveSheet()->getStyle('F' . $cont)->getAlignment()->setWrapText(true);

//            $date1 = date_create("2013-03-15");
//            $date2 = date_create("2013-12-12");

            $fecha11 = explode(' ', $estado->estado_fecha_ingreso);
            $fecha111 = explode('-', $fecha11[0]);
            $fecha1Ano = $fecha111[0];
            $fecha2Ano = $fecha111[1];
            $fecha3Ano = $fecha111[2];


            $fecha1 = $fecha111[0] . '-' . $fecha111[1] . '-' . $fecha111[2];
            $fecha1 = date_create($fecha1);

            $fecha22 = $fecha->format('Y-m-d');
            $fecha222 = explode('-', $fecha22);

            $fecha2 = $fecha222[0] . '-' . $fecha222[1] . '-' . $fecha222[2];
            $fecha2 = date_create($fecha2);

            $fechaDif = date_diff($fecha1, $fecha2);

//
            $fechaFinal = $fechaDif->format("%R%a Dias");

            $sheet->getCell('A' . $cont)->setValue($num . '');
            $sheet->getCell('B' . $cont)->setValue($estado->usu_rut);
            $sheet->getCell('C' . $cont)->setValue($estado->usuario_apellido_pat);
            $sheet->getCell('D' . $cont)->setValue($estado->usuario_nombre_pri);
            $sheet->getCell('E' . $cont)->setValue($estado->depto_nombre);
            $sheet->getCell('F' . $cont)->setValue($estado->docu_tipo . '-' . $estado->iddocumento);
            $sheet->getCell('G' . $cont)->setValue($estado->docu_nombre);
            $sheet->getCell('H' . $cont)->setValue($estado->estado_fecha_ingreso);
            $sheet->getCell('I' . $cont)->setValue($fecha);
            $sheet->getCell('J' . $cont)->setValue($fechaFinal);


            $spreadsheet->getActiveSheet()->getStyle('A' . $cont)->applyFromArray($estiloBorde);
            $spreadsheet->getActiveSheet()->getStyle('B' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('C' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('D' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('E' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('F' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('G' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('H' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('I' . $cont)->applyFromArray($borde);
            $spreadsheet->getActiveSheet()->getStyle('J' . $cont)->applyFromArray($borde);

            $num++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ListaUsuariosPendiente.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
