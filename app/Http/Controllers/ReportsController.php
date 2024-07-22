<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportsController extends Controller
{
    public function generateExcelReport()
    {
        /** @var User $user */
        $user = auth()->user();
        $tables = $user->tables()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("Diccionario de Datos");

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(30);

        $row = 1;

        /** @var Table $table */
        foreach ($tables as $table) {
            $start = $row;

            // Table header
            $sheet->mergeCells("A$row:F$row");
            $sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
            $sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A$row:F$row")
                ->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB(Color::COLOR_YELLOW);
            $sheet->setCellValue('A' . $row++, $table->nombre);

            // Table column names
            $sheet->setCellValue('A' . $row, 'NOMBRE DEL CAMPO');
            $sheet->setCellValue('B' . $row, 'TIPO DE DATO');
            $sheet->setCellValue('C' . $row, 'PK/FK');
            $sheet->setCellValue('D' . $row, 'IS NOT NULL');
            $sheet->setCellValue('E' . $row, 'VALOR POR DEFECTO');
            $sheet->setCellValue('F' . $row, 'DESCRIPCIÓN');

            $sheet->getStyle("A$row:F$row")
                ->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB(Color::COLOR_YELLOW);
            $sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
            $sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row += 1;

            // Table rows
            foreach ($table->columns()->get() as $col) {
                $sheet->setCellValue("A$row", $col->nombre);
                $sheet->setCellValue("B$row", $col->tipo_dato);
                $sheet->setCellValue("C$row", $col->es_pk ? 'PK' : ($col->es_fk ? 'FK' : '-'));
                $sheet->setCellValue("D$row", $col->es_null ? 'Sí' : 'No');
                $sheet->setCellValue("E$row", $col->valor_defecto ?? '-');
                $sheet->setCellValue("F$row", $col->descripcion);

                $sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("F$row")->getAlignment()->setWrapText(true);

                $row += 1;
            }

            $sheet->getStyle("A$start:F$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $row += 1;
        }

        $reportsDirectory = storage_path('reports');
        $reportsFile = storage_path('reports/diccionarioDatos.xlsx');

        if (!is_dir($reportsDirectory)) {
            mkdir($reportsDirectory);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($reportsFile);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename=diccionarioDatos.xlsx',
        ];

        return response()->download($reportsFile, 'diccionarioDatos.xlsx', $headers);
    }
}
