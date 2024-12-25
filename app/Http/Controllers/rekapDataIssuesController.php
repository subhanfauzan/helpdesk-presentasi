<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use File;
use Excel;
use App\Exports\ExportExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeExport;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class rekapDataIssuesController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            if(in_array(get_nama_current_path_root_group(), get_sub_menu())){
                return $next($request);
            }else{
                return response()->view('tidak_ditemukan.pages_404');
            }
        });
    }

    public function index()
    {
        $data['judul'] = "Rekap Data";
        $data['m_layanan'] =  DB::table('m_layanan')
            ->select(DB::raw('m_layanan.nama_layanan, m_layanan.id, m_kategori.nama_kategori as kategori'))
            ->join('m_kategori', 'm_layanan.m_kategori_id', '=', 'm_kategori.id')
            ->orderBy('m_layanan.nama_layanan', 'asc')
            ->get();
        $data['helpdesk'] = DB::table('pegawai')
            ->select(DB::raw('pegawai.nama as pegawai'))
            ->where('pegawai.unitid', '=', 'PBD200')
            ->get();
        $data['units'] = DB::table('v_unit_kerja')
            ->select(DB::raw('v_unit_kerja.*'))
            ->orderBy('v_unit_kerja.nama', 'asc')
            ->get();
        return view('pages.rekap_data_issues.index', $data);
    }

    public function getDataIssues(Request $request)
    {
        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
            $awal = $request->tanggalawal;
            $akhir = $request->tanggalakhir;
            $status = $request->status_issue;
            $layanan = $request->layanan;
            $unitkerja = $request->unitkerja;
            

            if ($unitkerja != "semua") {
                if ($status == "openprogress") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getIssuesDataEachUnit($awal, $akhir, $unitkerja, 1, 2);
                    } else {
                        $tb_issues =  getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 1, 2);
                    }
                }
                if ($status == "doneclosed") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getIssuesDataEachUnit($awal, $akhir, $unitkerja, 3, 4);
                    } else {
                        $tb_issues =  getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 3, 4);
                    }
                }
                if ($status == "onhold") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getIssuesDataEachUnit($awal, $akhir, $unitkerja, 6, 0);
                    } else {
                        $tb_issues =  getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 6, 0);
                    }
                }
                if ($status == "semua") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getAllIssuesDataEachUnit($awal, $akhir, $unitkerja);
                    } else {
                        $tb_issues =  getAllIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan);
                    }
                }
            } else {
                if ($status == "openprogress") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getIssuesData($awal, $akhir, 1, 2);
                    } else {
                        $tb_issues =  getIssuesDataByLayanan($awal, $akhir, $layanan, 1, 2);
                    }
                }
                if ($status == "doneclosed") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getIssuesData($awal, $akhir, 3, 4);
                    } else {
                        $tb_issues =  getIssuesDataByLayanan($awal, $akhir, $layanan, 3, 4);
                    }
                }
                if ($status == "onhold") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getIssuesData($awal, $akhir, 6, 0);
                    } else {
                        $tb_issues =  getIssuesDataByLayanan($awal, $akhir, $layanan, 6, 0);
                    }
                }
                if ($status == "semua") {
                    if ($layanan == 'semua') {
                        $tb_issues =  getAllIssuesData($awal, $akhir);
                    } else {
                        $tb_issues =  getAllIssuesDataByLayanan($awal, $akhir, $layanan);
                    }
                }
            }

            $total_data = $tb_issues->count();
            $issues = $tb_issues
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];

            $no = $offset + 1;

            // dd($tb_issues->first());

            if (count($issues) > 0) {
                $tiket_simasti = [];

                foreach ($issues as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $kamus =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);


                foreach ($issues as $value) {


                    if ($value->k_id == 'K11' && $value->tiket_simasti != "" && $value->tiket_simasti != null) {
                        $subjects = explode('~', $value->tiket_simasti);
                        $note = 'Subject simasti:<br>';

                        for ($numb = 0; $numb < count($subjects); $numb++) {
                            if(!isset($kamus[$subjects[$numb]]['no_aset'])){
                                $note = '';
                            }else{
                                $note .= ' ( ' . 
                                $kamus[$subjects[$numb]]['no_aset'] . ' - ' . 
                                $kamus[$subjects[$numb]]['model'] . ' - ' . 
                                $kamus[$subjects[$numb]]['nama_kategori'] . ' ) - ' . 
                                $kamus[$subjects[$numb]]['status_perbaikan'] . '; <br>';
                            }
                            
                        }
                    } else {
                        $note = '';
                    }
                    //mapping status
                    $tgldone = $value->lastupdate;
                    if ($value->status == 1) {
                        $status = 'Open';
                        $tgldone = Date('Y-m-d H:i:s');
                    } elseif ($value->status == 2) {
                        $status = 'Progress';
                        $tgldone = Date('Y-m-d H:i:s');
                    } elseif ($value->status == 3) {
                        $status = 'Done<br>'.$tgldone;
                    } elseif ($value->status == 4) {
                        $status = 'Closed<br>'.$tgldone;
                    } elseif ($value->status == 6) {
                        $status = 'On Hold<br>';
                    }
                    if($value->sladone == null){
                        $realisasi = hitungSLA($value->tgllapor, $value->tglbatas, $tgldone, $value->status, $value->tiket);
                        // $realisasi = $value->sladone;
                    }else{
                        $realisasi = $value->sladone;
                    }
                    // $qrcode = base64_encode(QrCode::format('png')
                    //     ->size(500)
                    //     ->errorCorrection("H")
                    //     ->merge(public_path('image/Petro_logo.png'), 0.3, true)
                    //     ->generate($value->tiket));
                    // Hitung Realisasi SLA 
                    
                    $datas[] = array(
                        'no' => $no++,
                        // 'tiket_nama_layanan' => "<img style='width:160px'src='data:image/png;base64," . $qrcode . "'/><br>" . $value->tiket . "<br>" . $value->layanan,
                        'tiket_nama_layanan' => "<br>" . $value->tiket . "<br>" . $value->kategori,
                        'nama_subjek' => ($value->kategori_subject ? $value->kategori_subject . '-' : '') . $value->subject . "<br>(" . $value->layanan . ")",
                        'user_entry' => $value->creator,
                        // 'nama_peminta' => $value->peminta,
                        'requester' => $value->requester . "<br> NIK" . $value->nik . "<br>(" . $value->unit . ")",
                        'tanggal_lapor' => $value->tgllapor." - <br>".$value->tglbatas,
                        'prioritas' => $value->prioritas,
                        'sla' => $value->sla,
                        'realisasi_sla' => $realisasi,
                        'status' =>  $status,
                        'ekskalasi_pi' => $value->tiket_cares_pi,
                        'note' => $note,
                        'deskripsi_permintaan' => str_replace('contenteditable="true"', 'contenteditable="false"', $value->deskripsi)
                    );
                }
            } else {
                $datas = array();
            }
            // dd($issues);
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;
            // dd($datas);

            return response()->json(compact("data", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function export_pdf(Request $request)
    {

        ini_set("pcre.backtrack_limit", "5000000");

        $awal = $request->tanggalawal;
        $akhir = $request->tanggalakhir;
        $status = $request->status_issue;
        $layanan = $request->layanan;
        $unitkerja = $request->unitkerja;
        $pdf_data['tim'] = $request->tim;
        $pdf_data['koor']  = $request->koor;
        if ($unitkerja == "semua") {
            if ($status == "openprogress") {
                if ($layanan == 'semua') {
                    $pdf_data['issues'] = getIssuesData($awal, $akhir, 1, 2)->get();
                } else {
                    $pdf_data['issues'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 1, 2)->get();
                }
                $tiket_simasti = [];

                foreach ($pdf_data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $pdf_data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);

                $pdf_data['awal'] = $awal;
                $pdf_data['akhir'] = $akhir;

                $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
                $pdf = PDF::loadView('pages.rekap_data_issues.export_pdf_openprogress', $pdf_data, [], $options);
                $pdf->download('Report issues helpdesk Open-Progress ' . $awal . ' - ' . $akhir . '.pdf');
            } else if ($status == "doneclosed") {
                if ($layanan == 'semua') {
                    $pdf_data['issues'] = getIssuesData($awal, $akhir, 3, 4)->get();
                } else {
                    $pdf_data['issues'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 3, 4)->get();
                }
                $tiket_simasti = [];

                foreach ($pdf_data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $pdf_data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);

                $pdf_data['awal'] = $awal;
                $pdf_data['akhir'] = $akhir;

                $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
                $pdf = PDF::loadView('pages.rekap_data_issues.export_pdf_doneclosed', $pdf_data, [], $options);
                $pdf->download('Report issues helpdesk Done-Closed ' . $awal . ' - ' . $akhir . '.pdf');
            } else if ($status == "onhold") {
                if ($layanan == 'semua') {
                    $pdf_data['issues'] = getIssuesData($awal, $akhir, 6, 0)->get();
                } else {
                    $pdf_data['issues'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 6, 0)->get();
                }
                $tiket_simasti = [];

                foreach ($pdf_data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $pdf_data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);

                $pdf_data['awal'] = $awal;
                $pdf_data['akhir'] = $akhir;

                $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
                $pdf = PDF::loadView('pages.rekap_data_issues.export_pdf_onhold', $pdf_data, [], $options);
                $pdf->download('Report issues helpdesk Done-Closed ' . $awal . ' - ' . $akhir . '.pdf');
            } else if ($status == "semua") {

                if ($layanan == 'semua') {
                    $pdf_data['openprogress'] = getIssuesData($awal, $akhir, 1, 2)->get();
                } else {
                    $pdf_data['openprogress'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 1, 2)->get();
                }
                if ($layanan == 'semua') {
                    $pdf_data['doneclosed'] = getIssuesData($awal, $akhir, 3, 4)->get();
                } else {
                    $pdf_data['doneclosed'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 3, 4)->get();
                }
                if ($layanan == 'semua') {
                    $pdf_data['onhold'] = getIssuesData($awal, $akhir, 6, 0)->get();
                } else {
                    $pdf_data['onhold'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 3, 0)->get();
                }
                $tiket_simasti = [];

                foreach ($pdf_data['openprogress'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                foreach ($pdf_data['doneclosed'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $pdf_data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);

                $pdf_data['awal'] = $awal;
                $pdf_data['akhir'] = $akhir;
                $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
                $pdf = PDF::loadView('pages.rekap_data_issues.export_pdf_all', $pdf_data, [], $options);
                $pdf->download('Report issues helpdesk Semua Status ' . $awal . ' - ' . $akhir . '.pdf');
            }
        } else {
            if ($status == "openprogress") {
                if ($layanan == 'semua') {
                    $pdf_data['issues'] = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 1, 2)->get();
                } else {
                    $pdf_data['issues'] = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 1, 2)->get();
                }
                $tiket_simasti = [];

                foreach ($pdf_data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $pdf_data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);

                $pdf_data['awal'] = $awal;
                $pdf_data['akhir'] = $akhir;

                $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
                $pdf = PDF::loadView('pages.rekap_data_issues.export_pdf_openprogress', $pdf_data, [], $options);
                $pdf->download('Report issues helpdesk Open-Progress ' . $awal . ' - ' . $akhir . '[' . $unitkerja . '].pdf');
            } else if ($status == "doneclosed") {
                if ($layanan == 'semua') {
                    $pdf_data['issues'] = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 3, 4)->get();
                } else {
                    $pdf_data['issues'] = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 3, 4)->get();
                }
                $tiket_simasti = [];

                foreach ($pdf_data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $pdf_data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);

                $pdf_data['awal'] = $awal;
                $pdf_data['akhir'] = $akhir;

                $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
                $pdf = PDF::loadView('pages.rekap_data_issues.export_pdf_doneclosed', $pdf_data, [], $options);
                $pdf->download('Report issues helpdesk Done-Closed ' . $awal . ' - ' . $akhir . '[' . $unitkerja . '].pdf');
            } else if ($status == "semua") {
                if ($layanan == 'semua') {
                    $pdf_data['openprogress'] = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 1, 2)->get();
                } else {
                    $pdf_data['openprogress'] = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 1, 2)->get();
                }
                if ($layanan == 'semua') {
                    $pdf_data['doneclosed'] = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 3, 4)->get();
                } else {
                    $pdf_data['doneclosed'] = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 3, 4)->get();
                }
                $tiket_simasti = [];

                foreach ($pdf_data['openprogress'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                foreach ($pdf_data['doneclosed'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $pdf_data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);

                $pdf_data['awal'] = $awal;
                $pdf_data['akhir'] = $akhir;
                $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
                $pdf = PDF::loadView('pages.rekap_data_issues.export_pdf_all', $pdf_data, [], $options);
                $pdf->download('Report issues helpdesk Semua Status ' . $awal . ' - ' . $akhir . '[' . $unitkerja . '].pdf');
            }
        }
    }

    public function export_excel(Request $request)
    {
        $awal = $request->tanggalawal;
        $akhir = $request->tanggalakhir;
        $status = $request->status_issue;
        $layanan = $request->layanan;
        $unitkerja = $request->unitkerja;
        $data['tim'] = $request->tim;
        $data['koor'] = $request->koor;
        if ($unitkerja == "semua") {
            if ($status == "openprogress") {
                if ($layanan == 'semua') {
                    $data['issues'] = getIssuesData($awal, $akhir, 1, 2)->get();
                } else {
                    $data['issues'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 1, 2)->get();
                }
                $tiket_simasti = [];

                foreach ($data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);
                $data['mapping'] = mappingSLAexcel($data['issues']);
                $data['priority'] = mappingPriority($data['issues']);
                $data['judul'] = "Open-Progress";
                return Excel::download(new exportRekapIssues($data), 'Report Issues Helpdesk Open-Progress' . $awal . '-' . $akhir . '.xlsx');
            } else if ($status == "doneclosed") {
                if ($layanan == 'semua') {
                    $data['issues'] = getIssuesData($awal, $akhir, 3, 4)->get();
                } else {
                    $data['issues'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 3, 4)->get();
                }
                $tiket_simasti = [];

                foreach ($data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }

                $tiket_simasti = array_filter($tiket_simasti);
                $data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);
                $data['mapping'] = mappingSLAexcel($data['issues']);
                $data['priority'] = mappingPriority($data['issues']);
                $data['judul'] = "Done-Closed";
                return Excel::download(new exportRekapIssues($data), 'Report Issues Helpdesk Done-Closed' . $awal . '-' . $akhir . '.xlsx');
            } else if ($status == "onhold") {
                if ($layanan == 'semua') {
                    $data['issues'] = getIssuesData($awal, $akhir, 6, 0)->get();
                } else {
                    $data['issues'] = getIssuesDataByLayanan($awal, $akhir, $layanan, 6, 0)->get();
                }
                $tiket_simasti = [];

                foreach ($data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }

                $tiket_simasti = array_filter($tiket_simasti);
                $data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);
                $data['mapping'] = mappingSLAexcel($data['issues']);
                $data['priority'] = mappingPriority($data['issues']);
                $data['judul'] = "On Hold";
                return Excel::download(new exportRekapIssues($data), 'Report Issues Helpdesk Done-Closed' . $awal . '-' . $akhir . '.xlsx');
            } else if ($status == "semua") {
                if ($layanan == 'semua') {
                    $openprogress = getIssuesData($awal, $akhir, 1, 2)->get();
                    $doneclosed = getIssuesData($awal, $akhir, 3, 4)->get();
                    $onhold = getIssuesData($awal, $akhir, 6, 0)->get();
                } else {
                    $openprogress = getIssuesDataByLayanan($awal, $akhir, $layanan, 1, 2)->get();
                    $doneclosed = getIssuesDataByLayanan($awal, $akhir, $layanan, 3, 4)->get();
                    $onhold = getIssuesDataByLayanan($awal, $akhir, $layanan, 6, 0)->get();
                }
                $tiket_simasti = [];

                foreach ($openprogress as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                foreach ($doneclosed as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);

                $data = array(
                    "openprogress" => array(
                        "issues" => $openprogress,
                        "tim" => $request->tim,
                        "koor" => $request->koor,
                        "judul" => "Open-Progress"
                    ),
                    "doneclosed" => array(
                        "issues" => $doneclosed,
                        "tim" => $request->tim,
                        "koor" => $request->koor,
                        "judul" => "Done-Closed"
                    ),
                    "onhold" => array(
                        "issues" => $onhold,
                        "tim" => $request->tim,
                        "koor" => $request->koor,
                        "judul" => "On Hold"
                    ),
                    "kamus" => app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti),
                    "mappingOP" => mappingSLAexcel($openprogress->all()),
                    "mappingOH" => mappingSLAexcel($onhold->all()),
                    "mappingDC" => mappingSLAexcel($doneclosed->all()),
                    "priorityOP" => mappingPriority($openprogress->all()),
                    "priorityOH" => mappingPriority($onhold->all()),
                    "priorityDC" => mappingPriority($doneclosed->all())
                );
                // dd($data);
                return Excel::download(new exportRekapAllIssues($data), 'Report Issues Helpdesk Semua Status ' . $awal . '-' . $akhir . '.xlsx');
            }
        } else {
            if ($status == "openprogress") {
                if ($layanan == 'semua') {
                    $data['issues'] = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 1, 2)->get();
                } else {
                    $data['issues'] = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 1, 2)->get();
                }
                $tiket_simasti = [];

                foreach ($data['issues'] as $issue) {
                    $tiket_simasti = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }

                $tiket_simasti = array_filter($tiket_simasti);
                $data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);
                $data['mapping'] = mappingSLAexcel($data['issues']);
                $data['priority'] = mappingPriority($data['issues']);
                $data['judul'] = "Open-Progress";
                return Excel::download(new exportRekapIssues($data), 'Report Issues Helpdesk Open-Progress' . $awal . '-' . $akhir . '[' . $unitkerja . '].xlsx');
            } else if ($status == "doneclosed") {
                if ($layanan == 'semua') {
                    $data['issues'] = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 3, 4)->get();
                } else {
                    $data['issues'] = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 3, 4)->get();
                }

                $tiket_simasti = [];

                foreach ($data['issues'] as $issue) {
                    $tiket_simasti[] = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }

                $data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);
                $data['mapping'] = mappingSLAexcel($data['issues']);
                $data['priority'] = mappingPriority($data['issues']);
                $data['judul'] = "Done-Closed";
                return Excel::download(new exportRekapIssues($data), 'Report Issues Helpdesk Done-Closed' . $awal . '-' . $akhir . '[' . $unitkerja . '].xlsx');
            } else if ($status == "onhold") {
                if ($layanan == 'semua') {
                    $data['issues'] = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 6, 0)->get();
                } else {
                    $data['issues'] = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 6, 0)->get();
                }

                $tiket_simasti = [];

                foreach ($data['issues'] as $issue) {
                    $tiket_simasti[] = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }

                $data['kamus'] =  app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti);
                $data['mapping'] = mappingSLAexcel($data['issues']);
                $data['priority'] = mappingPriority($data['issues']);
                $data['judul'] = "On Hold";
                return Excel::download(new exportRekapIssues($data), 'Report Issues Helpdesk On Hold' . $awal . '-' . $akhir . '[' . $unitkerja . '].xlsx');
            } else if ($status == "semua") {
                if ($layanan == 'semua') {
                    $openprogress = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 1, 2)->get();
                    $doneclosed = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 3, 4)->get();
                    $onhold = getIssuesDataEachUnit($awal, $akhir, $unitkerja, 6, 0)->get();
                } else {
                    $openprogress = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 1, 2)->get();
                    $doneclosed = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 3, 4)->get();
                    $onhold = getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, 6, 0)->get();
                }

                $tiket_simasti = [];

                foreach ($openprogress as $issue) {
                    $tiket_simasti[] = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                foreach ($doneclosed as $issue) {
                    $tiket_simasti[] = array_merge($tiket_simasti, explode("~", $issue->tiket_simasti));
                }
                $tiket_simasti = array_filter($tiket_simasti);
                $data = array(
                    "openprogress" => array(
                        "issues" => $openprogress,
                        "tim" => $request->tim,
                        "koor" => $request->koor,
                        "judul" => "Open-Progress"
                    ),
                    "doneclosed" => array(
                        "issues" => $doneclosed,
                        "tim" => $request->tim,
                        "koor" => $request->koor,
                        "judul" => "Done-Closed"
                    ),
                    "onhold" => array(
                        "issues" => $onhold,
                        "tim" => $request->tim,
                        "koor" => $request->koor,
                        "judul" => "On Hold"
                    ),
                    "kamus" => app('App\Http\Controllers\apiIssuesController')->getListDataDetailPerbaikan($tiket_simasti),
                    "mappingOP" => mappingSLAexcel($openprogress->all()),
                    "mappingOH" => mappingSLAexcel($onhold->all()),
                    "mappingDC" => mappingSLAexcel($doneclosed->all()),
                    "priorityOP" => mappingPriority($openprogress->all()),
                    "priorityOH" => mappingPriority($onhold->all()),
                    "priorityDC" => mappingPriority($doneclosed->all())
                );
                return Excel::download(new exportRekapAllIssues($data), 'Report Issues Helpdesk Semua Status ' . $awal . '-' . $akhir . '[' . $unitkerja . '].xlsx');
            }
        }
    }
}

class exportRekapIssues implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = $this->data;
        return view('pages.rekap_data_issues.export_excel', $data);
    }

    public function styles(Worksheet $sheet)
    {

        $array = array_merge(
            $this->data['mapping'],
            $this->data['priority']
        );
        $array[1] = [
            'font' => ['bold' => true, 'size' => 11, 'name' => 'Calibri'],
            'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FF006EFF']],
        ];
        return $array;
    }

    // public function drawings()
    // {
    //     $data = $this->data["issues"];
    //     $user = Session::get('user_app')['token'];
    //     $drawings = [];
    //     $index = 1;
    //     foreach ($data as $issue) {
    //         QrCode::format('png')->merge(public_path('image/Petro_logo.png'), 0.3, true)
    //             ->size(500)->errorCorrection('H')->format('png')->generate($issue->tiket, public_path('temp_qr/' . $user . $issue->tiket . '.svg'));
    //         $im = imagecreatefrompng(public_path('temp_qr/' . $user . $issue->tiket . '.svg'));

    //         // $spreadsheet = new Spreadsheet();

    //         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
    //         $drawing->setName('Sample image');
    //         $drawing->setDescription('Sample image');
    //         $drawing->setImageResource($im);
    //         $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
    //         $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
    //         $drawing->setHeight(150);
    //         $drawing->setCoordinates('A' . ++$index);
    //         // $drawing->setWorksheet($spreadsheet->getActiveSheet());
    //         $drawings[] = ($drawing);

    //         File::delete(public_path('temp_qr/' . $user . $issue->tiket . '.svg'));
    //     }
    //     return $drawings;
    // }

    // public function drawings()
    // {
    //     $data = $this->data["issues"];
    //     $drawings = [];
    //     $index = 1;
    //     foreach ($data as $issue) {
    //         QrCode::format('png')->merge(public_path('image/Petro_logo.png'), 0.3, true)
    //         ->size(100)->errorCorrection('H')->generate($issue->tiket, public_path('temp_qr/'.$issue->tiket.'.svg'));
    //         $drawing = new Drawing();
    //         $drawing->setPath(public_path('temp_qr/'.$issue->tiket.'.svg'));
    //         $drawing->setHeight(50);
    //         $drawing->setWidth(120);
    //         $drawing->setCoordinates('A' . ++$index);
    //         $drawings[] = ($drawing);
    //     }
    //     return $drawings;
    // }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function (BeforeExport $event) {
            },
            // AfterSheet::class    => function (AfterSheet $event) {
            //     // $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            //     $data = $this->data["issues"];
            //     $index = 2;
            //     foreach ($data as $issue) {
            //         $event->sheet->getRowDimension($index++)->setRowHeight(130);
            //     }
            // },
        ];
    }
}
class exportRekapAllIssues implements ShouldAutoSize, WithMultipleSheets
{
    use Exportable;
    protected $data, $openprogress, $doneclosed;

    public function __construct($data)
    {
        $this->data = $data;

        $this->openprogress = [
            'issues' => $data['openprogress']['issues'],
            'judul' => $data['openprogress']['judul'],
            'tim' => $data['openprogress']['tim'],
            'koor' => $data['openprogress']['koor'],
            'kamus' => $data['kamus'],
            'mapping' => $data['mappingOP'],
            'priority' => $data['priorityOP']
        ];
        $this->doneclosed = [
            'issues' => $data['doneclosed']['issues'],
            'judul' => $data['doneclosed']['judul'],
            'tim' => $data['doneclosed']['tim'],
            'koor' => $data['doneclosed']['koor'],
            'kamus' => $data['kamus'],
            'mapping' => $data['mappingDC'],
            'priority' => $data['priorityDC']
        ];
        $this->onhold = [
            'issues' => $data['onhold']['issues'],
            'judul' => $data['onhold']['judul'],
            'tim' => $data['onhold']['tim'],
            'koor' => $data['onhold']['koor'],
            'kamus' => $data['kamus'],
            'mapping' => $data['mappingOH'],
            'priority' => $data['priorityOH']
        ];
    }

    // public function view(): View
    // {
    //     $data = $this->data;
    //     return view('pages.rekap_data_issues.export_excel', $data);
    // }

    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //         1    => [
    //             'font' => ['bold' => true, 'size' => 11, 'name' => 'Calibri'],
    //             'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
    //             'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FF006EFF']],

    //         ],

    //     ];
    // }
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new exportRekapIssues($this->openprogress);
        $sheets[] = new exportRekapIssues($this->doneclosed);
        $sheets[] = new exportRekapIssues($this->onhold);
        return $sheets;
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         BeforeExport::class  => function(BeforeExport $event) {

    //         },
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             // $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

    //             $event->sheet->getActiveSheet()->getRowDimension('1')->setRowHeight(100);
    //         },
    //     ];
    // }

    // public function drawings()
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $index = 1;
    //     $drawings = [];
    //     foreach ($this->data as $issue) {

    //         $image = QrCode::format('png')->merge(public_path('image/Petro_logo.png'), 0.3, true)
    //         ->size(95)->errorCorrection('H')->generate($issue->tiket);

    //         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
    //         $drawing->setName('Sample image');
    //         $drawing->setDescription('Sample image');
    //         $drawing->setImageResource($image);
    //         $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
    //         $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
    //         $drawing->setHeight(36);
    //         $drawing->setCoordinates('A' . ++$index);
    //         $drawing->setWorksheet($spreadsheet->getActiveSheet());
    //         $drawings[] = ($drawing);
    //     }
    //     return $drawings;
    // }

    // public function drawings()
    // {
    //     $data = $this->data;
    //     $drawings = [];
    //     $index = 1;
    //     foreach ($data as $issue) {
    //         QrCode::format('png')->merge(public_path('image/Petro_logo.png'), 0.3, true)
    //         ->size(100)->errorCorrection('H')->generate($issue->tiket, public_path('temp_qr/'.$issue->tiket.'.svg'));
    //         $drawing = new Drawing();
    //         $drawing->setPath(public_path('temp_qr/'.$issue->tiket.'.svg'));
    //         $drawing->setHeight(50);
    //         $drawing->setWidth(120);
    //         $drawing->setCoordinates('A' . ++$index);
    //         $drawings[] = ($drawing);
    //     }
    //     return $drawings;
    // }
}

// //CONTOH EXPORT EXCEL
// class exportTemplateKenaikanPangkatCG implements FromView, WithStyles, WithColumnWidths, WithColumnFormatting
// {
//     use Exportable;
//     protected $request;

//     public function __construct($request = null)
//     {
//         $this->request = $request;
//     }

//     public function view(): View
//     {
//         $data['tgl_periode'] = $this->request->tgl_periode;
//         // dd($data);
//         return view('pages.rekap_data_issues.contoh_export_excel', $data);
//     }

//     public function styles(Worksheet $sheet)
//     {
//         $to = $sheet->getHighestRowAndColumn();

//         return [
//             // Style the first row as bold text.
//             1    => [
//                 'font' => ['bold' => true, 'size' => 11],
//                 'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
//                 'fill' => ['color' => ['argb' => '#594194A3']],
//             ],
//         ];
//     }

//     public function columnWidths(): array
//     {
//         return [
//             'A' => 35,
//             'B' => 35,
//             'C' => 35,
//             'D' => 30,
//             'E' => 30,
//             'F' => 30,
//             'G' => 30,
//             'H' => 30,
//             'I' => 30,
//             'J' => 30,
//             'K' => 30,
//             'L' => 30,
//             'M' => 30,
//         ];
//     }

//     public function columnFormats(): array
//     {
//         return [
//             'B' => NumberFormat::FORMAT_TEXT,
//             // 'B' => NumberFormat::FORMAT_NUMBER,
//         ];
//     }
// }
//contoh download excel 
    //public function contoh_export_excel(Request $request)
    // {
    //     return Excel::download(new exportRekapIssues($request), 'contoh_export_excel' . '.xlsx');
    // }

    // public function contoh_export_pdf()
    // {
    //     $get_session_users_id = Session::get('user_app')['users_id'];
    //     $get_session_token = Session::get('user_app')['token'];
    //     $get_session_nama = Session::get('user_app')['nama'];
    //     $get_session_username = Session::get('user_app')['username'];

    //     $get_users = db::table('users')
    //         ->select(DB::raw('users.*'))
    //         ->where('users.id', '=', $get_session_users_id)
    //         ->get()
    //         ->first();
    //     // $pdfdata = [];
    //     $pdf_data['username'] = $get_session_username;
    //     $pdf_data['nama'] = $get_session_nama;


    //     $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
    //     $pdf = PDF::loadView('pages.rekap_data_issues.contoh_export_pdf', $pdf_data, [], $options);
    //     $pdf->stream('contoh_export_pdf.pdf');
    // }
