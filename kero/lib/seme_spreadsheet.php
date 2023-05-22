<?php

//loading library
$vendorDirPath = (SEMEROOT . 'kero/lib/phpoffice/vendor/');
$vendorDirPath = realpath($vendorDirPath);
require_once $vendorDirPath . '/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing as XlsxDrawing;

class Seme_Spreadsheet extends JI_Controller
{
    public $colAlpha = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
        'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
        'U', 'V', 'W', 'X', 'Y', 'Z',
        'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ',
        'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT',
        'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
        'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ',
        'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT',
        'BU', 'BV', 'BW', 'BX', 'BY', 'BZ',
        'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ',
        'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT',
        'CU', 'CV', 'CW', 'CX', 'CY', 'CZ',
        'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ',
        'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT',
        'DU', 'DV', 'DW', 'DX', 'DY', 'DZ',
        'EA', 'EB', 'EC', 'ED', 'EE', 'EF', 'EG', 'EH', 'EI', 'EJ',
        'EK', 'EL', 'EM', 'EN', 'EO', 'EP', 'EQ', 'ER', 'ES', 'ET',
        'EU', 'EV', 'EW', 'EX', 'EY', 'EZ',
    ];

    public function __construct()
    {
    }

    public function _textCenter()
    {
        return array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }
    public function _textBold()
    {
        return array(
            'font'  => array(
                'bold'  => true
            ),
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        );
    }
    public function _textBorderBold()
    {
        return array(
            'font'  => array(
                'bold'  => true
            ),
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            ),
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        );
    }
    public function _cellBordered()
    {
        return array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            )
        );
    }

    public function newReader()
    {
        return new XlsxReader();
    }

    public function newSpreadSheet()
    {
        return new Spreadsheet();
    }

    public function newWriter($ssheet)
    {
        return new XlsxWriter($ssheet);
    }

    public function newDrawing()
    {
        return new XlsxDrawing();
    }

    public function setDataCell($sheet, $colIdx, $rowIdx, $value)
    {
        $sheet->setCellValue($this->colAlpha[$colIdx] . $rowIdx, $value);
        $sheet->getStyle($this->colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->_textBorderBold())->getAlignment()->applyFromArray($this->_textCenter());
    }

    /*
    Request: 
        - title*
        - filename*
        - head*
        - data*
        - footer
        - text_size
        - font_family
        - mindate
        - maxdate
    */
    public function download_basic($request)
    {
        if (!isset($request->head) || !isset($request->data) || !isset($request->title) || !isset($request->filename)) {
            echo "Beberapa parameter belum terisi";
            die();
        }

        $mindate = $request->mindate ?? '';
        if (strlen($mindate) != 10) $mindate = '';

        $maxdate = $request->maxdate ?? '';
        if (strlen($maxdate) != 10) $maxdate = '';
        $title = $request->title;
        $head = $request->head;
        $data = $request->data;
        $filename = $request->filename;

        if (count($head) > count($this->colAlpha)) {
            echo "Outbound data";
            die();
        }

        //create object xls
        $ssheet = new Spreadsheet();
        if (isset($request->font_family)) $ssheet->getDefaultStyle()->getFont()->setName($request->font_family);
        if (isset($request->text_size)) $ssheet->getDefaultStyle()->getFont()->setSize($request->text_size);
        if (isset($request->footer)) $ssheet->getActiveSheet()->getHeaderFooter()->setOddFooter($request->footer);

        //create sheet-1 and define columns widht
        $ssheet->setActiveSheetIndex(0);
        $sheet = $ssheet->getActiveSheet();
        $sheet->setTitle($title);

        $rowIdx = 1;
        $colIdx = 0;

        $sheet->setCellValue($this->colAlpha[$colIdx] . $rowIdx, 'No');
        $sheet->getStyle($this->colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->_textBorderBold())->getAlignment()->applyFromArray($this->_textCenter());
        $colIdx++;
        foreach ($head as $k => $v) {
            $sheet->setCellValue($this->colAlpha[$colIdx] . $rowIdx, $v);
            $sheet->getStyle($this->colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->_textBorderBold())->getAlignment()->applyFromArray($this->_textCenter());
            $colIdx++;
        }
        unset($head);

        $nomor = 1;
        $rowIdx++;

        foreach ($data as $dt) {
            $colIdx = 0;
            $sheet->setCellValue($this->colAlpha[$colIdx] . $rowIdx, $nomor);
            $sheet->getStyle($this->colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->_cellBordered());
            $colIdx++;
            foreach ($dt as $k => $v) {
                $sheet->setCellValue($this->colAlpha[$colIdx] . $rowIdx, (isset($v) ? $v : ''));
                $sheet->getStyle($this->colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->_cellBordered());
                $colIdx++;
            }
            $nomor++;
            $rowIdx++;
        }
        unset($data);

        // auto fit columns
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        //save file
        $save_dir = $this->__checkDir(date("Y/m"));
        $save_file = $filename;
        if ($mindate != $maxdate) {
            $save_file = $save_file . str_replace('-', '', $mindate) . '-' . str_replace('-', '', $maxdate);
        } else {
            $save_file = $save_file . str_replace('-', '', $mindate);
        }
        $save_file = str_replace(' ', '', str_replace('/', '', $save_file));

        $swriter = new XlsxWriter($ssheet);
        if (file_exists($save_dir . '/' . $save_file . '.xlsx')) unlink($save_dir . '/' . $save_file . '.xlsx');
        $swriter->save($save_dir . '/' . $save_file . '.xlsx');

        $download_path = str_replace(SEMEROOT, '/', $save_dir . '/' . $save_file . '.xlsx');
        // echo '<a href="' . base_url($download_path) . '">' . base_url($download_path) . '</a>';
        $this->__forceDownload($save_dir . '/' . $save_file . '.xlsx');
    }
}
