<?php



class Cetak extends JI_Controller
{
	var $media_pengguna = 'media/';
	var $is_log = 0;

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'print';
		$this->current_page = 'print';
		$this->load('a_jpenilaian_concern');
		$this->load('a_indikator_concern');
		$this->load('b_user_concern');
		$this->load('c_asesmen_concern');
		$this->load('d_value_concern');

		$this->load("api_front/a_jpenilaian_model", 'ajm');
		$this->load("api_front/a_indikator_model", 'aim');
		$this->load("api_front/b_user_model", 'bum');
		$this->load("api_front/c_asesmen_model", 'cam');
		$this->load("api_front/d_value_model", 'dvm');

		$this->lib('seme_dompdf', 'dompdf');
		$this->lib('seme_spreadsheet', 'ss');
		$this->lib("seme_log");
	}

	public function index()
	{
		$data = $this->__init();
		dd($_REQUEST);
		echo 'Page for printing';
		die();
	}

	public function _list_for_print()
	{
		$d = $this->__init();
		$data = array();
		$this->_api_auth_required($data, 'user');

		$data['status'] = 200;
		$data['message'] = API_ADMIN_ERROR_CODES[$data['status']];

		/** advanced filter is_active */
		$a_jpenilaian_id = $this->input->request('a_jpenilaian_id', '');
		$a_ruangan_id = $this->input->request('a_ruangan_id', '');
		$b_user_id = $this->input->request('b_user_id', '');
		$b_user_id_penilai = $this->input->request('b_user_id_penilai', '');
		$is_active = $this->input->request('is_active', '');
		$sdate = $this->input->request('sdate', '');
		$bulan = $this->input->request('bulan', '');
		$edate = $this->input->request('edate', '');
		$page = $this->input->request('page', 0);
		$pagesize = $this->input->request('pagesize', 10);
		$sort_column = $this->input->request('sort_column', 'id');
		$sort_direction = $this->input->request('sort_direction', 'desc');
		$keyword = $this->input->request('keyword', '');

		if ($d['sess']->user->profesi == 'IPCN' || $d['sess']->user->profesi == 'Komite Mutu') {
			$b_user_id_penilai = '';
		}
		if (strlen($bulan)) {
			$sdate = $bulan;
			$dates = explode('-', $sdate);
			$edate = date($dates[0] . '-' . $dates[1] . '-t');
		}

		$data['mindate'] = $sdate;
		$data['maxdate'] = $edate;

		$ajm = $this->ajm->id($a_jpenilaian_id);
		if (!isset($ajm->id)) {
			$data['status'] = 400;
			$data['message'] = "Data tidak ditemukan";
			return $data;
			die();
		}
		$data['ajm'] = $ajm;

		$aim = $this->aim->getByPenilaianId($ajm->id);
		if (!isset($aim[0]->id)) {
			$data['status'] = 400;
			$data['message'] = "Data tidak ditemukan";
			return $data;
			die();
		}
		$data['aim'] = $aim;

		if ($ajm->slug == 'monitoring-kegiatan-harian-pencegahan-pengendalian-infeksi-ppi') {
			$ddata = $this->dvm->print_ppi(
				$page,
				$pagesize,
				$sort_column,
				$sort_direction,
				$b_user_id,
				$b_user_id_penilai,
				$a_jpenilaian_id,
				$a_ruangan_id,
				$sdate,
				$edate,
				$keyword,
				$is_active
			);
			$calculate = $this->dvm->calculate_ppi(
				$page,
				$pagesize,
				$sort_column,
				$sort_direction,
				$b_user_id,
				$b_user_id_penilai,
				$a_jpenilaian_id,
				$a_ruangan_id,
				$sdate,
				$edate,
				$keyword,
				$is_active
			);
		} else {
			$ddata = $this->cam->print(
				$page,
				$pagesize,
				$sort_column,
				$sort_direction,
				$b_user_id,
				$b_user_id_penilai,
				$a_jpenilaian_id,
				$a_ruangan_id,
				$sdate,
				$edate,
				$keyword,
				$is_active
			);
		}

		// dd($calculate);
		if (isset($calculate)) {
			$dcal = [];
			foreach ($calculate as $k => $v) {
				$dcal[$v->ruangan . ' - ' . $v->kategori] = $v;
			}
		}

		foreach ($ddata as &$gd) {
			if (isset($gd->is_active)) {
				$gd->is_active = $this->cam->label('is_active', $gd->is_active);
			}

			if (isset($gd->cdate)) {
				$gd->tgl = (int) date('d', strtotime($gd->cdate));
			}

			if (isset($gd->cdate)) {
				$gd->bulan_tahun = $this->__dateIndonesia($gd->cdate, 'bulan_tahun');
			}


			if (isset($gd->cdate)) {
				$gd->cdate = $this->__dateIndonesia($gd->cdate);
			}


			if (isset($gd->value)) {
				$gd->value = json_decode($gd->value);
			}

			if (isset($gd->durasi)) {
				$durasis = explode('.', $gd->durasi);

				$gd->durasi = '';
				if ((int) $durasis[0]) $gd->durasi .= $durasis[0] . ' jam ';
				if ((int) $durasis[1]) $gd->durasi .= $durasis[1] . ' menit';
			}

			if (isset($dcal) && isset($gd->ruangan) && strlen($gd->ruangan) && isset($gd->indikator_kategori) && strlen($gd->indikator_kategori)) {
				$gd->aksi_y = 0;
				$gd->aksi_n = 0;
				$gd->aksi_jumlah = 0;
				$gd->aksi_persentase = 0;
				if (isset($dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->y)) $gd->aksi_y = $dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->y;
				if (isset($dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->n)) $gd->aksi_n = $dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->n;
				if (isset($dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->jumlah)) $gd->aksi_jumlah = $dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->jumlah;
				if ($gd->aksi_y && $gd->aksi_n && $gd->aksi_jumlah) {
					$gd->aksi_persentase = $gd->aksi_y ? ceil($gd->aksi_y / $gd->aksi_jumlah * 100) : 0;
				}
			} else {
				$gd->aksi_y = 0;
				$gd->aksi_n = 0;
				$gd->aksi_jumlah = 0;
				$gd->aksi_persentase = 0;
			}
		}
		unset($aim);
		unset($ajm);
		$data['list'] = $ddata;
		return $data;
	}

	public function _content_pdf($res)
	{
		$s = '<h4 class="text-center mb-n1">FORMULIR AUDIT HAND HYGIENE RSU BINA SEHAT</h4><br>';
		$s .= '<table style="width: 100%;">';
		$s .= '<tbody>';
		$n = 0;
		foreach ($res['list'] as $k => $v) {
			if ($k == 0) {
				$s .= '<tr>';
			}
			if ($n == 3) {
				$s .= '</tr><tr>';
				$n = 0;
			}
			$s .= '<td>
				<table class="my_table">
					<tbody>
						<tr>
							<td>Profesi</td>
							<td colspan="2">' . $v->profesi . '</td>
						</tr>
						<tr>
							<td>Nama</td>
							<td colspan="2">' . $v->nama . '</td>
						</tr>
						<tr>
							<td>Unit</td>
							<td colspan="2">' . $v->ruangan . '</td>
						</tr>
						<tr>
							<td>Penilai</td>
							<td colspan="2">' . $v->nama_penilai . ' - ' . $v->jabatan_penilai . '</td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td colspan="2">' . $v->cdate . '</td>
						</tr>
						<tr>
							<td>Lama Audit</td>
							<td colspan="2">' . $v->durasi . '</td>
						</tr>
					</tbody>
					<tbody>
						<tr style="background-color: #08686738;">
							<td>Opp</td>
							<td>Indikasi</td>
							<td>Action</td>
						</tr>';
			foreach ($v->value as $kvalue => $vvalue) {
				$isPageBreak = $kvalue == 4 ? '' : '';
				$s .= '<tr class="' . $isPageBreak . '">
						<td>' . ($kvalue + 1) . '</td>
						<td>';
				foreach ($res['aim'] as $kaim => $vaim) {
					if ($vaim->type == 'indikator') {
						$ischecked = $vvalue->indikator == $vaim->id ? 'checked' : '';
						$s .= '<div class="form-check">
												<input class="form-check-input" type="checkbox" ' . $ischecked . '>
												<label class="form-check-label" >
													' . $vaim->nama . '
												</label>
											</div>';
						// <!-- $s .= '<label><input type="checkbox" ${ischecked}> ${vaim.nama}</label>' -->
					}
				}
				$s .= '</td>';
				$s .= '<td>';
				foreach ($res['aim'] as $kaim2 => $vaim2) {
					if ($vaim2->type == 'aksi') {
						$ischecked = $vvalue->aksi == $vaim2->id ? 'checked' : '';
						$s .= '<div class="form-check">
												<input class="form-check-input" type="checkbox" ' . $ischecked . '>
												<label class="form-check-label" >
													' . $vaim2->nama . '
												</label>
											</div>';
						// <!-- $s .= '<label><input type="checkbox" ${ischecked}> ${vaim.nama}</label>' -->
					}
				}
				$s .= '</td>
							</tr>';
			}

			$s .= '</tbody>
				</table>
			</td>';
			if ($k == count($res['list']) - 1) {
				$s .= '</tr>';
			}
			$n++;
		}

		$s .= '</tbody>';
		$s .= '</table>';
		return $s;
	}

	public function hh()
	{
		$res = $this->_list_for_print();
		$data = [];
		if ($res['status'] != 200) {
			$this->status = $res['status'];
			$this->message = $res['message'];
			echo $data;
			die();
		}

		$html = '<!DOCTYPE html>
		<html lang="en">
		
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Document</title>
		</head>
		
		<body>';
		$html .= '<style>
					@page { margin: 25px; }
					body { 
						margin-left: 25px; 
						margin-right: 25px; 
						margin-top: 25px; 
						font-family: "Helvetica", "Arial", sans-serif;
					}
					.text-center {
						text-align: center;
					}

					h4{
						margin-bottom:0px;
					}

					.my_table {
						margin-bottom: 0.5rem;
						width: 100%;
						border-collapse: collapse;
					}

					td{
						vertical-align: top !important;
					}

					.my_table td {
						border: 1px solid #121212;
						padding-left: 0.5rem;
						padding-bottom: 0.4rem;
						vertical-align: top;
					}

					.my_table th {
						border: 1px solid #121212;
						padding: 0.1rem;
					}

					.check {
						border: 1px solid #bebebe;
						width: 1rem;
						height: 1rem;
						border-radius: 6px;
					}

					.checked {
						border: 1px solid #bebebe;
						width: 1rem;
						height: 1rem;
						border-radius: 6px;
						background-color: #5e72e4;
					}

					body {
						font-size: x-small;
					}

					.page-break {
						page-break-after: always;
					}

					.form-check {
						display: block;
						padding-left: 2.3em;
						margin-bottom: 0.125rem;
					}

					.form-check-label, .form-check-input[type="checkbox"] {
						cursor: pointer;
					}
					.form-check-input[type="checkbox"] {
						border-radius: 0.25em !important;
					}
					.form-check .form-check-input {
						float: left;
						margin-left: -1.73em;
					}
					.form-check-input {
						width: 1.23em;
						height: 1.23em;
						border-radius: 3px;
						vertical-align: top;
						background-color: #fff;
						background-repeat: no-repeat;
						background-position: center;
						background-size: contain;
						
						appearance: none;
						color-adjust: exact;
					}
					.form-check-label {
						font-size: x-small;
					}
					.form-check-label, .form-check-input[type="checkbox"] {
						cursor: pointer;
					}
				</style>';

		$html .= $this->_content_pdf($res);

		$html .= '</body>
		</html>';

		$filename = 'audit-hand-hygiene.pdf';
		$data = $this->dompdf->download([
			'filename' => $filename,
			'html' => $html,
			'ukuran' => 'A3',
			'rotasi' => 'Potrait'
		]);
		// $this->status = 200;
		// $this->message = 'OK';
		// $json_data = [];
		// $json_data['pdf'] = $data;
		// $json_data['filename'] = $filename;
		// $this->__json_out($json_data);

		// if (isset($data['status']) && $data['status'] != 200) {
		// 	echo $data['message'];
		// }
	}

	public function monev()
	{
		error_reporting(E_ALL);
		try {
			if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Get Data");
			$content = $this->_list_for_print();
		} catch (Exception $e) {
			if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Get Data Error : " . $e->getMessage());
		}
		$json_data = [];
		if ($content['status'] != 200) {
			$this->status = $content['status'];
			$this->message = $content['message'];
			$this->__json_out($json_data);
			die();
		}
		// $_SESSION['content'] = null;
		$ajm = $content['ajm'];
		$aim = $content['aim'];
		$list = $content['list'];
		$maxdate = $content['maxdate'];
		$mindate = $content['mindate'];
		$newAim = [];
		try {
			if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Manipulate Data ");
			foreach ($aim as $k => $v) {
				$newAim[$v->id] = $v;
			}
		} catch (Exception $e) {
			if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Manipulate Data Error : " . $e->getMessage());
		}

		$aim = $newAim;

		$sh = 0;
		$tempRuangan = '';
		$tempTgl = '';
		$tempKategori = '';
		$tempSubKategori = '';
		$countSheet = [];

		// Init Spreadsheet
		$ssheet = $this->ss->newSpreadSheet();
		$ssheet->setActiveSheetIndex(0);

		// Get columns excel
		$colAlpha = $this->ss->colAlpha;

		$rowIdx = 10;
		$colIdx = 0;
		$rowTgl = 10;
		$lastRowTgl = 0;
		$isFirst = true;
		$nomor = 1;

		$countY = 0;
		$countN = 0;
		$countItem = 0;

		$colTgl = [];
		$columnTgl = 2;
		$tgl = 1;
		for ($i = 0; $i < 62; $i++) {
			if ($columnTgl % 2 == 0) {
				$colTgl[$tgl]['y'] = $colAlpha[$columnTgl];
			} else {
				$colTgl[$tgl]['n'] = $colAlpha[$columnTgl];
				$tgl++;
			}
			$columnTgl++;
		}
		if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Jumlah Data " . count($list));
		foreach ($list as $k => $v) {
			try {
				// if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Init Data $k");
				if ($k == 0) {

					$tempRuangan = $v->ruangan;
					$tempTgl = $v->tgl;
					$tempKategori = $v->indikator_kategori;
					$tempSubKategori = $v->indikator_subkategori;

					//Header
					$countSheet[$sh] = $ssheet->getActiveSheet();
					$objDrawing = $this->ss->newDrawing();
					$objDrawing->setPath('media/logo.png');
					$objDrawing->setWidth(50);
					$objDrawing->setHeight(50);
					$objDrawing->setOffsetX(150);
					$objDrawing->setCoordinates('B2');
					$objDrawing->setWorksheet($countSheet[$sh]);
					$ruangan = str_replace('/', '-', $v->ruangan);
					$countSheet[$sh]->setTitle($ruangan);
					$countSheet[$sh]->setCellValue($colAlpha[0] . 2, 'MONITORING KEGIATAN HARIAN PENCEGAHAN PENGENDALIAN INFEKSI DI RUMAH SAKIT UMUM BINA SEHAT')->mergeCells('A' . 2 . ':BL' . 2);
					$countSheet[$sh]->getStyle('A' . 2 . ':BL' . 2)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
					$countSheet[$sh]->setCellValue($colAlpha[0] . 4, 'Ruangan');
					$countSheet[$sh]->setCellValue($colAlpha[1] . 4, ': ' . $v->ruangan);
					$countSheet[$sh]->setCellValue($colAlpha[0] . 5, 'Bulan');
					$countSheet[$sh]->setCellValue($colAlpha[1] . 5, ': ' . $v->bulan_tahun);

					$countSheet[$sh]->setCellValue($colAlpha[0] . 7, 'NO')->mergeCells('A' . 7 . ':A' . 9);
					$countSheet[$sh]->getStyle('A' . 7 . ':A' . 9)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
					$countSheet[$sh]->setCellValue($colAlpha[1] . 7, 'INDIKATOR')->mergeCells('B' . 7 . ':B' . 9);
					$countSheet[$sh]->getStyle('B' . 7 . ':B' . 9)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
					$countSheet[$sh]->setCellValue($colAlpha[2] . 7, 'TANGGAL')->mergeCells('C' . 7 . ':BL' . 7);
					$countSheet[$sh]->getStyle('C' . 7 . ':BL' . 7)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());

					$columnTgl = 2;
					$tgl = 1;
					for ($i = 0; $i < 62; $i++) {
						if ($columnTgl % 2 == 0) {
							$countSheet[$sh]->setCellValue($colAlpha[$columnTgl] . 8, $tgl)->mergeCells($colAlpha[$columnTgl] . 8 . ':' . $colAlpha[($columnTgl + 1)] . 8);
							$countSheet[$sh]->getStyle($colAlpha[$columnTgl] . 8 . ':' . $colAlpha[($columnTgl + 1)] . 8)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
							$countSheet[$sh]->setCellValue($colAlpha[$columnTgl] . 9, 'Y');
							$countSheet[$sh]->getStyle($colAlpha[$columnTgl] . 9, 'Y')->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
							$tgl++;
						} else {
							$countSheet[$sh]->setCellValue($colAlpha[$columnTgl] . 9, 'T');
							$countSheet[$sh]->getStyle($colAlpha[$columnTgl] . 9, 'T')->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						}
						$columnTgl++;
					}

					//Indikator
					$countSheet[$sh]->setCellValue($colAlpha[0] . $rowIdx, $v->indikator_kategori)->mergeCells('A' . $rowIdx . ':BF' . $rowIdx);
					$countSheet[$sh]->setCellValue('BG' . $rowIdx, 'HASIL')->mergeCells('BG' . $rowIdx . ':BJ' . $rowIdx);
					$countSheet[$sh]->setCellValue('BK' . $rowIdx, $v->aksi_persentase)->mergeCells('BK' . $rowIdx . ':BL' . $rowIdx);
					$countSheet[$sh]->getStyle('A' . $rowIdx . ':BL' . $rowIdx)->applyFromArray($this->ss->_textBorderBold());
					$countSheet[$sh]->getStyle('A' . $rowIdx . ':BL' . $rowIdx)->getFill()->setFillType('solid')->getStartColor()->setARGB('66bb6a');
					$rowIdx++;
					$rowTgl++;

					// auto fit columns
					foreach ($countSheet[$sh]->getColumnIterator() as $column) {
						if ($column->getColumnIndex() != 'B') {
							$countSheet[$sh]->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
						} else {
							$countSheet[$sh]->getColumnDimension($column->getColumnIndex())->setWidth(35);
							$countSheet[$sh]->getStyle('B')->getAlignment()->setWrapText(true);
						}
					}
				} else {

					if ($tempTgl != $v->tgl) {
						if ($isFirst) {
							$lastRowTgl = $rowTgl;
							$columnTgl = 2;
							for ($i = 0; $i <= 62; $i++) {
								if ($i != 62) {
									$countSheet[$sh]->getStyle($colAlpha[$columnTgl] . 10 . ':' . $colAlpha[$columnTgl] . ($lastRowTgl - 1))->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
								}
								$columnTgl++;
							}
						}
					}
					if ($tempRuangan != $v->ruangan) {
						$rowIdx++;
						$countSheet[$sh]->setCellValue('AQ' . $rowIdx, 'IPCN')->mergeCells('AQ' . $rowIdx . ':BB' . $rowIdx);
						$countSheet[$sh]->getStyle('AQ' . $rowIdx . ':BB' . $rowIdx)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						$rowIdx++;
						$rowIdx++;
						$rowIdx++;
						$rowIdx++;
						$countSheet[$sh]->setCellValue('AQ' . $rowIdx, '(………………………………………)')->mergeCells('AQ' . $rowIdx . ':BB' . $rowIdx);
						$countSheet[$sh]->getStyle('AQ' . $rowIdx . ':BB' . $rowIdx)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());

						$nomor = 1;
						$rowIdx = 10;
						$rowTgl = 10;
						$isFirst = true;
						$tempRuangan = $v->ruangan;
						$tempTgl = $v->tgl;
						$tempKategori = $v->indikator_kategori;
						$tempSubKategori = $v->indikator_subkategori;
						$sh++;
						$countSheet[$sh] = $ssheet->createSheet();
						$objDrawing = $this->ss->newDrawing();
						$objDrawing->setPath('media/logo.png');
						$objDrawing->setWidth(50);
						$objDrawing->setHeight(50);
						$objDrawing->setOffsetX(150);
						$objDrawing->setCoordinates('B2');
						$objDrawing->setWorksheet($countSheet[$sh]);
						$ruangan = str_replace('/', '-', $v->ruangan);
						$countSheet[$sh]->setTitle($ruangan);
						$countSheet[$sh]->setCellValue($colAlpha[0] . 2, 'MONITORING KEGIATAN HARIAN PENCEGAHAN PENGENDALIAN INFEKSI DI RUMAH SAKIT UMUM BINA SEHAT')->mergeCells('A' . 2 . ':BL' . 2);
						$countSheet[$sh]->getStyle('A' . 2 . ':BL' . 2)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						$countSheet[$sh]->setCellValue($colAlpha[0] . 4, 'Ruangan');
						$countSheet[$sh]->setCellValue($colAlpha[1] . 4, ': ' . $v->ruangan);
						$countSheet[$sh]->setCellValue($colAlpha[0] . 5, 'Bulan');
						$countSheet[$sh]->setCellValue($colAlpha[1] . 5, ': ' . $v->bulan_tahun);

						$countSheet[$sh]->setCellValue($colAlpha[0] . 7, 'NO')->mergeCells('A' . 7 . ':A' . 9);
						$countSheet[$sh]->getStyle('A' . 7 . ':A' . 9)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						$countSheet[$sh]->setCellValue($colAlpha[1] . 7, 'INDIKATOR')->mergeCells('B' . 7 . ':B' . 9);
						$countSheet[$sh]->getStyle('B' . 7 . ':B' . 9)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						$countSheet[$sh]->setCellValue($colAlpha[2] . 7, 'TANGGAL')->mergeCells('C' . 7 . ':BL' . 7);
						$countSheet[$sh]->getStyle('C' . 7 . ':BL' . 7)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());

						$columnTgl = 2;
						$tgl = 1;
						for ($i = 0; $i < 62; $i++) {
							if ($columnTgl % 2 == 0) {
								$countSheet[$sh]->setCellValue($colAlpha[$columnTgl] . 8, $tgl)->mergeCells($colAlpha[$columnTgl] . 8 . ':' . $colAlpha[($columnTgl + 1)] . 8);
								$countSheet[$sh]->getStyle($colAlpha[$columnTgl] . 8 . ':' . $colAlpha[($columnTgl + 1)] . 8)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
								$countSheet[$sh]->setCellValue($colAlpha[$columnTgl] . 9, 'Y');
								$countSheet[$sh]->getStyle($colAlpha[$columnTgl] . 9, 'Y')->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
								$tgl++;
							} else {
								$countSheet[$sh]->setCellValue($colAlpha[$columnTgl] . 9, 'T');
								$countSheet[$sh]->getStyle($colAlpha[$columnTgl] . 9, 'T')->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
							}
							$columnTgl++;
						}

						//Indikator
						$countSheet[$sh]->setCellValue($colAlpha[0] . $rowIdx, $v->indikator_kategori)->mergeCells('A' . $rowIdx . ':BF' . $rowIdx);
						$countSheet[$sh]->setCellValue('BG' . $rowIdx, 'HASIL')->mergeCells('BG' . $rowIdx . ':BJ' . $rowIdx);
						$countSheet[$sh]->setCellValue('BK' . $rowIdx, $v->aksi_persentase)->mergeCells('BK' . $rowIdx . ':BL' . $rowIdx);
						$countSheet[$sh]->getStyle('A' . $rowIdx . ':BL' . $rowIdx)->applyFromArray($this->ss->_textBorderBold());
						$countSheet[$sh]->getStyle('A' . $rowIdx . ':BL' . $rowIdx)->getFill()->setFillType('solid')->getStartColor()->setARGB('66bb6a');
						$rowIdx++;
						$rowTgl++;

						// auto fit columns
						foreach ($countSheet[$sh]->getColumnIterator() as $column) {
							if ($column->getColumnIndex() != 'B') {
								$countSheet[$sh]->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
							} else {
								$countSheet[$sh]->getColumnDimension($column->getColumnIndex())->setWidth(35);
								$countSheet[$sh]->getStyle('B')->getAlignment()->setWrapText(true);
							}
						}
					}
					if ($tempTgl != $v->tgl) {
						$tempTgl = $v->tgl;
						$rowTgl = 10;
						$isFirst = false;
					}
					if ($tempKategori != $v->indikator_kategori) {
						$tempKategori = $v->indikator_kategori;
						if ($isFirst) {
							$nomor = 1;
							//Indikator
							$countSheet[$sh]->setCellValue($colAlpha[0] . $rowIdx, $v->indikator_kategori)->mergeCells('A' . $rowIdx . ':BF' . $rowIdx);
							$countSheet[$sh]->setCellValue('BG' . $rowIdx, 'HASIL')->mergeCells('BG' . $rowIdx . ':BJ' . $rowIdx);
							$countSheet[$sh]->setCellValue('BK' . $rowIdx, $v->aksi_persentase)->mergeCells('BK' . $rowIdx . ':BL' . $rowIdx);
							$countSheet[$sh]->getStyle('A' . $rowIdx . ':BL' . $rowIdx)->applyFromArray($this->ss->_textBorderBold());
							$countSheet[$sh]->getStyle('A' . $rowIdx . ':BL' . $rowIdx)->getFill()->setFillType('solid')->getStartColor()->setARGB('66bb6a');
							$rowIdx++;
						}
						$rowTgl++;
					}
				}

				if ($isFirst) {
					$countSheet[$sh]->getStyle('C' . $rowIdx . ':BL' . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
					$countSheet[$sh]->setCellValue($colAlpha[1] . $rowIdx, $v->indikator_nama);
					$countSheet[$sh]->getStyle($colAlpha[1] . $rowIdx)->applyFromArray($this->ss->_textBorderBold());
					$countSheet[$sh]->setCellValue($colAlpha[0] . $rowIdx, $nomor);
					$countSheet[$sh]->getStyle($colAlpha[0] . $rowIdx)->applyFromArray($this->ss->_textBorderBold());
					$rowIdx++;
					$nomor++;
				}
				$countSheet[$sh]->setCellValue($colTgl[$v->tgl][$v->aksi] . $rowTgl, '√');
				$rowTgl++;

				if ($k == count($list) - 1) {
					$rowIdx++;
					$countSheet[$sh]->setCellValue('AQ' . $rowIdx, 'IPCN')->mergeCells('AQ' . $rowIdx . ':BB' . $rowIdx);
					$countSheet[$sh]->getStyle('AQ' . $rowIdx . ':BB' . $rowIdx)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
					$rowIdx++;
					$rowIdx++;
					$rowIdx++;
					$rowIdx++;
					$countSheet[$sh]->setCellValue('AQ' . $rowIdx, '(………………………………………)')->mergeCells('AQ' . $rowIdx . ':BB' . $rowIdx);
					$countSheet[$sh]->getStyle('AQ' . $rowIdx . ':BB' . $rowIdx)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
					$ssheet->setActiveSheetIndex(0);
				}
			} catch (Exception $e) {
				if ($this->is_log) {
					$this->seme_log->write("Cetak::Monev -- Init Data $k Error" . $e->getMessage());
				}
			}
		}

		if ($ajm->slug == 'audit-kepatuhan-apd') {
			$media_dir = 'apd';
		} else {
			$media_dir = 'monev';
		}

		//save file
		if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Menyimpan Excel ");
		$save_dir = $this->__checkDir(date("Y/m"), "media/$media_dir/");
		if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Save DIR: " . $save_dir);
		$save_file = $ajm->slug;
		if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Save File: " . $save_file);
		if ($mindate != $maxdate) {
			$save_file = $save_file . str_replace('-', '', $mindate) . '-' . str_replace('-', '', $maxdate);
		} else {
			$save_file = $save_file . str_replace('-', '', $mindate);
		}
		$save_file = str_replace(' ', '', str_replace('/', '', $save_file));
		if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Save File Edited: " . $save_file);

		if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Init Writer");
		$swriter = $this->ss->newWriter($ssheet);
		if (file_exists($save_dir . '/' . $save_file . '.xlsx')) {
			if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Unlink Existed File: " . $save_dir . '/' . $save_file . '.xlsx');
			unlink($save_dir . '/' . $save_file . '.xlsx');
		}
		try {
			if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Saving File: " . $save_dir . '/' . $save_file . '.xlsx');
			$swriter->save($save_dir . '/' . $save_file . '.xlsx');
		} catch (Exception $e) {
			if ($this->is_log) $this->seme_log->write("Cetak::Monev -- Saving File Error: " . $e->getMessage());
		}
		$download_path = str_replace(SEMEROOT, '', $save_dir . '/' . $save_file . '.xlsx');
		// echo '<a href="' . base_url($download_path) . '">' . base_url($download_path) . '</a>';
		$json_data = [];
		$json_data['url'] = base_url($download_path);
		$this->status = 200;
		$this->message = 'OK';
		if ($this->is_log) $this->seme_log->write("Cetak::Monev -- JSON data: " . json_encode($json_data));
		$this->__json_out($json_data);
	}

	public function apd()
	{
		$json_data = [];
		$content = $this->_list_for_print();
		if ($content['status'] != 200) {
			$this->status = $content['status'];
			$this->message = $content['message'];
			$this->__json_out($json_data);
			die();
		}
		// $_SESSION['content'] = null;
		$ajm = $content['ajm'];
		$aim = $content['aim'];
		$list = $content['list'];
		$maxdate = $content['maxdate'];
		$mindate = $content['mindate'];
		// dd($list);
		$newAim = [];
		foreach ($aim as $k => $v) {
			$newAim[$v->id] = $v;
		}
		$aim = $newAim;

		// Init Spreadsheet
		$ssheet = $this->ss->newSpreadSheet();
		$ssheet->setActiveSheetIndex(0);
		$sheet = $ssheet->getActiveSheet();
		// $sheet->setTitle($ajm->nama);

		$aksi = [];
		if (isset($aim) && is_array($aim) && count($aim)) {
			foreach ($aim as $ka => $va) {
				if ($va->type == 'indikator') {
					continue;
				}
				$aksi[] = $va;
			}
		}


		// Get columns excel
		$colAlpha = $this->ss->colAlpha;

		$rowIdx = 1;

		if (isset($list) &&  is_array($list) && count($list)) {

			foreach ($list as $k => $v) {
				$colIdx = 0;

				$sheet->setCellValue($colAlpha[0] . $rowIdx, strtoupper($ajm->nama))->mergeCells('A' . $rowIdx . ':H' . $rowIdx);
				$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$rowIdx++;
				$rowIdx++;
				$sheet->setCellValue($colAlpha[0] . $rowIdx, 'Nama');
				$sheet->setCellValue($colAlpha[1] . $rowIdx, ':');
				$sheet->setCellValue($colAlpha[2] . $rowIdx, $v->nama);
				$rowIdx++;
				$sheet->setCellValue($colAlpha[0] . $rowIdx, 'Profesi');
				$sheet->setCellValue($colAlpha[1] . $rowIdx, ':');
				$sheet->setCellValue($colAlpha[2] . $rowIdx, $v->profesi);
				$rowIdx++;
				$sheet->setCellValue($colAlpha[0] . $rowIdx, 'Unit');
				$sheet->setCellValue($colAlpha[1] . $rowIdx, ':');
				$sheet->setCellValue($colAlpha[2] . $rowIdx, $v->ruangan);
				$rowIdx++;
				$sheet->setCellValue($colAlpha[0] . $rowIdx, 'Penilai');
				$sheet->setCellValue($colAlpha[1] . $rowIdx, ':');
				$sheet->setCellValue($colAlpha[2] . $rowIdx, $v->nama_penilai . ' - ' . $v->jabatan_penilai);
				$rowIdx++;
				$sheet->setCellValue($colAlpha[0] . $rowIdx, 'Tanggal Audit');
				$sheet->setCellValue($colAlpha[1] . $rowIdx, ':');
				$sheet->setCellValue($colAlpha[2] . $rowIdx, $v->cdate);
				$rowIdx++;

				//Add table
				// Header
				$rowIdx++;
				$sheet->setCellValue($colAlpha[$colIdx] . $rowIdx, 'Jenis Tindakan');
				$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$colIdx++;
				if (isset($aksi) && is_array($aksi) && count($aksi)) {
					foreach ($aksi as $ka => $va) {
						$sheet->setCellValue($colAlpha[$colIdx] . $rowIdx, $va->nama);
						$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						$colIdx++;
					}
				}

				$sheet->setCellValue($colAlpha[$colIdx] . $rowIdx, 'Persentase');
				$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$colIdx++;
				$sheet->setCellValue($colAlpha[$colIdx] . $rowIdx, 'Keterangan');
				$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$sheet->getStyle('A' . $rowIdx . ':H' . $rowIdx)->getFill()->setFillType('solid')->getStartColor()->setARGB('66bb6a');
				// Content
				$rowIdx++;
				if (isset($v->value) && is_array($v->value) && count($v->value)) {
					$sumPersen = 0;
					foreach ($v->value as $kvalue => $vvalue) {
						$colIdx = 0;
						$sheet->setCellValue($colAlpha[$colIdx] . $rowIdx, $aim[$vvalue->indikator]->nama);
						$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold());
						$colIdx++;
						$persentase = 0;
						$ya = 0;
						foreach ($aksi as $ka => $va) {
							if (in_array($va->id, $vvalue->aksi)) {
								$ya++;
								$value = 'IYA';
							} else {
								$value = 'TIDAK';
							}
							$sheet->setCellValue($colAlpha[$colIdx] . $rowIdx, $value);
							$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
							$colIdx++;
						}
						if ($ya) {
							$persentase = $ya / count($aksi) * 100;
							$sumPersen += $persentase;
						}
						$sheet->setCellValue($colAlpha[$colIdx] . $rowIdx, $persentase);
						$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						$colIdx++;
						$sheet->getStyle($colAlpha[$colIdx] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
						$colIdx++;

						$rowIdx++;
					}
				}

				$totalPersentase = $sumPersen ? ceil($sumPersen / (count($v->value) * 100) * 100) : 0;
				$sheet->setCellValue($colAlpha[0] . $rowIdx, 'TOTAL')->mergeCells('A' . $rowIdx . ':F' . $rowIdx);
				$sheet->setCellValue('G' . $rowIdx, $totalPersentase)->mergeCells('G' . $rowIdx . ':H' . $rowIdx);
				$sheet->getStyle('A' . $rowIdx . ':H' . $rowIdx)->getFill()->setFillType('solid')->getStartColor()->setARGB('d7a510');
				$sheet->getStyle('A' . $rowIdx . ':F' . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$sheet->getStyle('G' . $rowIdx . ':H' . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$rowIdx++;


				$rowIdx++;
				$sheet->setCellValue('G' . $rowIdx, 'IPCN')->mergeCells('G' . $rowIdx . ':H' . $rowIdx);
				$sheet->getStyle('G' . $rowIdx . ':H' . $rowIdx)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$rowIdx++;
				$rowIdx++;
				$sheet->setCellValue('G' . $rowIdx, '(………………………………………)')->mergeCells('G' . $rowIdx . ':H' . $rowIdx);
				$sheet->getStyle('G' . $rowIdx . ':H' . $rowIdx)->applyFromArray($this->ss->_textBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
				$rowIdx++;
				$rowIdx++;

				// $sheet->getStyle($colAlpha[0] . $rowIdx)->applyFromArray($this->ss->_textBorderBold())->getAlignment()->applyFromArray($this->ss->_textCenter());
			}
		}

		// auto fit columns
		foreach ($sheet->getColumnIterator() as $column) {
			$sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
		}

		if ($ajm->slug == 'audit-kepatuhan-apd') {
			$media_dir = 'apd';
		} else {
			$media_dir = 'monev';
		}

		//save file
		$save_dir = $this->__checkDir(date("Y/m"), "media/$media_dir/");
		$save_file = $ajm->slug;
		if ($mindate != $maxdate) {
			$save_file = $save_file . str_replace('-', '', $mindate) . '-' . str_replace('-', '', $maxdate);
		} else {
			$save_file = $save_file . str_replace('-', '', $mindate);
		}
		$save_file = str_replace(' ', '', str_replace('/', '', $save_file));

		$swriter = $this->ss->newWriter($ssheet);
		if (file_exists($save_dir . '/' . $save_file . '.xlsx')) unlink($save_dir . '/' . $save_file . '.xlsx');
		$swriter->save($save_dir . '/' . $save_file . '.xlsx');

		$download_path = str_replace(SEMEROOT, '', $save_dir . '/' . $save_file . '.xlsx');
		// echo '<a href="' . base_url($download_path) . '">' . base_url($download_path) . '</a>';
		$json_data = [];
		$json_data['url'] = base_url($download_path);
		$this->status = 200;
		$this->message = 'OK';
		$this->__json_out($json_data);
		// $this->__forceDownload(base_url($download_path));
	}
}
