<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Carbon\CarbonPeriod;

class rekapDataIssuesBulananController extends Controller
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
        // dd('coba');
        $m_layanan =  DB::table('m_layanan')
            ->select(DB::raw('m_layanan.nama_layanan, m_layanan.id, m_kategori.nama_kategori as kategori, m_kategori.id as kategori_id, m_kategori.created_at as m_kategori_created_at'))
            ->join('m_kategori', 'm_layanan.m_kategori_id', '=', 'm_kategori.id')
            ->orderBy('m_kategori.created_at', 'desc')
            ->get();

        $data['judul'] = "Rekap Data";
        $data['m_layanan'] =  $m_layanan;
        $data['helpdesk'] = DB::table('pegawai')
            ->select(DB::raw('pegawai.nama as pegawai'))
            ->where('pegawai.unitid', '=', 'PBD200')
            ->get();
        $data['units'] = DB::table('v_unit_kerja')
            ->select(DB::raw('v_unit_kerja.*'))
            ->orderBy('v_unit_kerja.nama', 'asc')
            ->get();

        $array_kategori_layanan = array();

        foreach($m_layanan as $datas){

            $array_kategori_layanan[$datas->kategori][] = $datas->id.'|'.$datas->nama_layanan;

        }

        $data['checkbox_layanan'] = $array_kategori_layanan;

        // dd($array_kategori_layanan);

        return view('pages.rekap_data_issues_bulanan.index', $data);
    }

    public function export_pdf(Request $request)
    {
        $awal = $request->tanggal_awal;
        $akhir = $request->tanggal_akhir;

        $awal_ambil_tahun = substr("$awal",0,4);
        $akhir_ambil_tahun = substr("$akhir",0,4);
        
        // dd($awal_ambil_tahun, $akhir_ambil_tahun);

        $checkbox_arr = explode(',', $request->checkbox);

        $period = CarbonPeriod::create("$awal", '1 month', "$akhir");
        // $dates = $period->toArray();
        $aray_period_y_m = [];
        foreach ($period as $data) {
            $aray_period_y_m[] = $data->format("Y-m");
        }

        for ($i = $awal_ambil_tahun; $i <= $akhir_ambil_tahun; $i++) {
            $aray_period_years[] = $i;
        }

        $tb_1 = [];
        $no = 0;
        foreach ($aray_period_y_m as $data => $value) {
            // dd($value);
            $status_open = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->groupBy(DB::raw('v_issues.layanan_id'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value'")
                ->whereRaw("v_issues.status = '1'")
                ->whereIn('layanan_id', $checkbox_arr)
                ->get()
                ->first();

            $status_progress = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->groupBy(DB::raw('v_issues.layanan_id'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value'")
                ->whereRaw("v_issues.status = '2'")
                ->whereIn('layanan_id', $checkbox_arr)
                ->get()
                ->first();

            $status_done = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->groupBy(DB::raw('v_issues.layanan_id'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value'")
                ->whereRaw("v_issues.status = '3'")
                ->whereIn('layanan_id', $checkbox_arr)
                ->get()
                ->first();

            $status_closed = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->groupBy(DB::raw('v_issues.layanan_id'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value'")
                ->whereRaw("v_issues.status = '4'")
                ->whereIn('layanan_id', $checkbox_arr)
                ->get()
                ->first();

            $status_onhold = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->groupBy(DB::raw('v_issues.layanan_id'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value'")
                ->whereRaw("v_issues.status = '6'")
                ->whereIn('layanan_id', $checkbox_arr)
                ->get()
                ->first();

            $tb_1[$no]['periode'] = $value;
            $tb_1[$no]['jumlah_status_open'] =
                is_null($status_open) ? 0 : $status_open->count_v_issues_status;
            $tb_1[$no]['jumlah_status_progress'] =
                is_null($status_progress) ? 0 : $status_progress->count_v_issues_status;
            $tb_1[$no]['jumlah_status_done'] =
                is_null($status_done) ? 0 : $status_done->count_v_issues_status;
            $tb_1[$no]['jumlah_status_closed'] =
                is_null($status_closed) ? 0 : $status_closed->count_v_issues_status;
            $tb_1[$no]['jumlah_status_onhold'] =
                is_null($status_onhold) ? 0 : $status_onhold->count_v_issues_status;

            // dd($value);

            $jumlah_status_done_sesuai_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            $tb_1[$no]['jumlah_status_done_sesuai_sla'] =
                count($jumlah_status_done_sesuai_sla) == 0 ? 0 : count($jumlah_status_done_sesuai_sla);


            $jumlah_status_done_tidak_sesuai_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at, v_issues.tanggal_batas_issues
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value'
                    AND issues_status.created_at > v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at, v_issues.tanggal_batas_issues
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd($jumlah_status_done_tidak_sesuai_sla);
    
            $tb_1[$no]['jumlah_status_done_tidak_sesuai_sla'] =
                count($jumlah_status_done_tidak_sesuai_sla) == 0 ? 0 : count($jumlah_status_done_tidak_sesuai_sla);

            // dd($tb_1[$no]['jumlah_status_done_tidak_sesuai_sla']);
            
            $no++;
        }

        $datas = [];
        $datas['tb_1'] = $tb_1;
        $datas['tb_1_1'] = $aray_period_years;

        $tb_2 = [];
        for ($i = $awal_ambil_tahun; $i <= $akhir_ambil_tahun; $i++) {
            $status_done_januari = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_januari_count = is_null($status_done_januari) ? 0 : $status_done_januari->count_v_issues_status;

            $status_closed_januari = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_januari_count = is_null($status_closed_januari) ? 0 : $status_closed_januari->count_v_issues_status;

            // $status_done_januari_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            $status_done_januari_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_januari_sla_count = count($status_done_januari_sla) == 0 ? 0 : count($status_done_januari_sla);

            

            $status_done_januari_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_januari_1_count = count($status_done_januari_1) == 0 ? 0 : count($status_done_januari_1);

            
            
            // dd($status_done_januari_sla_count);

            // $status_closed_januari_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_januari_sla_count = is_null($status_closed_januari_sla) ? 0 : $status_closed_januari_sla->count_v_issues_status;

            $status_semua_januari = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'")
                ->get()
                ->first();

            $status_semua_januari_count = is_null($status_semua_januari) ? 1 : $status_semua_januari->count_v_issues_status;

            $status_close_done_januari_count = $status_done_januari_count + $status_closed_januari_count;

            // dd($status_close_done_januari_count);

            $status_close_done_januari_count_1 = $status_close_done_januari_count == 0 ? 0 : $status_close_done_januari_count;

            // dd($status_close_done_januari_count);

            $persentase_januari = $status_close_done_januari_count / $status_semua_januari_count;

            $tb_2[$i][0] = round($persentase_januari, 4) * 100 . '%';

            $status_close_done_januari_sla_count = $status_done_januari_sla_count;

            if ($status_done_januari_1_count == 0){
                $persentase_sla_januari = 0;
            } else {
                $persentase_sla_januari = $status_close_done_januari_sla_count / $status_done_januari_1_count;
            }

            

            $tb_2[$i][12] = round($persentase_sla_januari, 4) * 100 . '%';








            $status_done_februari = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_februari_count = is_null($status_done_februari) ? 0 : $status_done_februari->count_v_issues_status;

            $status_closed_februari = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_februari_count = is_null($status_closed_februari) ? 0 : $status_closed_februari->count_v_issues_status;

            // $status_done_februari_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_februari_sla_count = is_null($status_done_februari_sla) ? 0 : $status_done_februari_sla->count_v_issues_status;

            $status_done_februari_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_februari_sla_count = count($status_done_februari_sla) == 0 ? 0 : count($status_done_februari_sla);




            $status_done_februari_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_februari_1_count = count($status_done_februari_1) == 0 ? 0 : count($status_done_februari_1);

            // $status_closed_februari_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_februari_sla_count = is_null($status_closed_februari_sla) ? 0 : $status_closed_februari_sla->count_v_issues_status;

            $status_semua_februari = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'")
                ->get()
                ->first();

            $status_semua_februari_count = is_null($status_semua_februari) ? 1 : $status_semua_februari->count_v_issues_status;

            $status_close_done_februari_count = $status_done_februari_count + $status_closed_februari_count;

            $status_close_done_februari_count_1 = $status_close_done_februari_count == 0 ? 0 : $status_close_done_februari_count;

            $persentase_februari = $status_close_done_februari_count / $status_semua_februari_count;

            $tb_2[$i][1] = round($persentase_februari, 4) * 100 . '%';

            $status_close_done_februari_sla_count = $status_done_februari_sla_count;

            if ($status_done_februari_1_count == 0){
                $persentase_februari_sla = 0;
            } else {
                $persentase_februari_sla = $status_close_done_februari_sla_count / $status_done_februari_1_count;
            }

            $tb_2[$i][13] = round($persentase_februari_sla, 4) * 100 . '%';






            $status_done_maret = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_maret_count = is_null($status_done_maret) ? 0 : $status_done_maret->count_v_issues_status;

            $status_closed_maret = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_maret_count = is_null($status_closed_maret) ? 0 : $status_closed_maret->count_v_issues_status;

            // $status_done_maret_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_maret_sla_count = is_null($status_done_maret_sla) ? 0 : $status_done_maret_sla->count_v_issues_status;

            $status_done_maret_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_maret_sla_count = count($status_done_maret_sla) == 0 ? 0 : count($status_done_maret_sla);




            $status_done_maret_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_maret_1_count = count($status_done_maret_1) == 0 ? 0 : count($status_done_maret_1);
            
            // $status_closed_maret_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_maret_sla_count = is_null($status_closed_maret_sla) ? 0 : $status_closed_maret_sla->count_v_issues_status;

            $status_semua_maret = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'")
                ->get()
                ->first();

            $status_semua_maret_count = is_null($status_semua_maret) ? 1 : $status_semua_maret->count_v_issues_status;

            $status_close_done_maret_count = $status_done_maret_count + $status_closed_maret_count;

            $status_close_done_maret_count_1 = $status_close_done_maret_count == 0 ? 0 : $status_close_done_maret_count;

            $persentase_maret = $status_close_done_maret_count / $status_semua_maret_count;

            $tb_2[$i][2] = round($persentase_maret, 4) * 100 . '%';

            $status_close_done_maret_sla_count = $status_done_maret_sla_count;

            if ($status_done_maret_1_count == 0){
                $persentase_maret_sla = 0;
            } else {
                $persentase_maret_sla = $status_close_done_maret_sla_count / $status_done_maret_1_count;
            }

            $tb_2[$i][14] = round($persentase_maret_sla, 4) * 100 . '%';









            $status_done_april = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_april_count = is_null($status_done_april) ? 0 : $status_done_april->count_v_issues_status;

            $status_closed_april = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_april_count = is_null($status_closed_april) ? 0 : $status_closed_april->count_v_issues_status;


            // $status_done_april_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_april_sla_count = is_null($status_done_april_sla) ? 0 : $status_done_april_sla->count_v_issues_status;

            
            $status_done_april_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_april_sla_count = count($status_done_april_sla) == 0 ? 0 : count($status_done_april_sla);



            $status_done_april_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_april_1_count = count($status_done_april_1) == 0 ? 0 : count($status_done_april_1);

            // $status_closed_april_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_april_sla_count = is_null($status_closed_april_sla) ? 0 : $status_closed_april_sla->count_v_issues_status;

            $status_semua_april = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'")
                ->get()
                ->first();

            $status_semua_april_count = is_null($status_semua_april) ? 1 : $status_semua_april->count_v_issues_status;

            $status_close_done_april_count = $status_done_april_count + $status_closed_april_count;

            $status_close_done_april_count_1 = $status_close_done_april_count == 0 ? 0 : $status_close_done_april_count;

            $persentase_april = $status_close_done_april_count / $status_semua_april_count;

            $tb_2[$i][3] = round($persentase_april, 4) * 100 . '%';

            $status_close_done_april_sla_count = $status_done_april_sla_count;

            if ($status_done_april_1_count == 0){
                $persentase_april_sla = 0;
            } else {
                $persentase_april_sla = $status_close_done_april_sla_count / $status_done_april_1_count;
            }

            $tb_2[$i][15] = round($persentase_april_sla, 4) * 100 . '%';









            $status_done_mei = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_mei_count = is_null($status_done_mei) ? 0 : $status_done_mei->count_v_issues_status;

            $status_closed_mei = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_mei_count = is_null($status_closed_mei) ? 0 : $status_closed_mei->count_v_issues_status;


            // $status_done_mei_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_mei_sla_count = is_null($status_done_mei_sla) ? 0 : $status_done_mei_sla->count_v_issues_status;

            $status_done_mei_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_mei_sla_count = count($status_done_mei_sla) == 0 ? 0 : count($status_done_mei_sla);


            $status_done_mei_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_1_sla_count = count($status_done_mei_1) == 0 ? 0 : count($status_done_mei_1);

            // $status_closed_mei_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_mei_sla_count = is_null($status_closed_mei_sla) ? 0 : $status_closed_mei_sla->count_v_issues_status;

            $status_semua_mei = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'")
                ->get()
                ->first();

            $status_semua_mei_count = is_null($status_semua_mei) ? 1 : $status_semua_mei->count_v_issues_status;

            $status_close_done_mei_count = $status_done_mei_count + $status_closed_mei_count;

            $persentase_mei = $status_close_done_mei_count / $status_semua_mei_count;

            $status_close_done_mei_count_1 = $status_close_done_mei_count == 0 ? 0 : $status_close_done_mei_count;

            $tb_2[$i][4] = round($persentase_mei, 4) * 100 . '%';

            $status_close_done_mei_sla_count = $status_done_mei_sla_count;

            if ($status_done_1_sla_count == 0){
                $persentase_mei_sla = 0;
            } else {
                $persentase_mei_sla = $status_close_done_mei_sla_count / $status_done_1_sla_count;
            }

            

            $tb_2[$i][16] = round($persentase_mei_sla, 4) * 100 . '%';











            $status_done_juni = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_juni_count = is_null($status_done_juni) ? 0 : $status_done_juni->count_v_issues_status;

            $status_closed_juni = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_juni_count = is_null($status_closed_juni) ? 0 : $status_closed_juni->count_v_issues_status;


            // $status_done_juni_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_juni_sla_count = is_null($status_done_juni_sla) ? 0 : $status_done_juni_sla->count_v_issues_status;

            $status_done_juni_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_juni_sla_count = count($status_done_juni_sla) == 0 ? 0 : count($status_done_juni_sla);
            



            $status_done_juni_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_juni_1_count = count($status_done_juni_1) == 0 ? 0 : count($status_done_juni_1);
            
            // $status_closed_juni_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_juni_sla_count = is_null($status_closed_juni_sla) ? 0 : $status_closed_juni_sla->count_v_issues_status;

            $status_semua_juni = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'")
                ->get()
                ->first();

            $status_semua_juni_count = is_null($status_semua_juni) ? 1 : $status_semua_juni->count_v_issues_status;

            $status_close_done_juni_count = $status_done_juni_count + $status_closed_juni_count;

            $status_close_done_juni_count_1 = $status_close_done_juni_count == 0 ? 0 : $status_close_done_juni_count;

            $persentase_juni = $status_close_done_juni_count / $status_semua_juni_count;

            $tb_2[$i][5] = round($persentase_juni, 4) * 100 . '%';

            $status_close_done_juni_sla_count = $status_done_juni_sla_count;

            if ($status_done_juni_1_count == 0){
                $persentase_juni_sla = 0;
            } else {
                $persentase_juni_sla = $status_close_done_juni_sla_count / $status_done_juni_1_count;
            }

            

            $tb_2[$i][17] = round($persentase_juni_sla, 4) * 100 . '%';









            $status_done_juli = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_juli_count = is_null($status_done_juli) ? 0 : $status_done_juli->count_v_issues_status;

            $status_closed_juli = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_juli_count = is_null($status_closed_juli) ? 0 : $status_closed_juli->count_v_issues_status;


            // $status_done_juli_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_juli_sla_count = is_null($status_done_juli_sla) ? 0 : $status_done_juli_sla->count_v_issues_status;

            $status_done_juli_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_juli_sla));

            $status_done_juli_sla_count = count($status_done_juli_sla) == 0 ? 0 : count($status_done_juli_sla);
            

            $status_done_juli_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_juli_sla));

            $status_done_juli_1_count = count($status_done_juli_1) == 0 ? 0 : count($status_done_juli_1);
            


            // dd($status_done_juli_sla_count);
            // $status_closed_juli_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_juli_sla_count = is_null($status_closed_juli_sla) ? 0 : $status_closed_juli_sla->count_v_issues_status;

            $status_semua_juli = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'")
                ->get()
                ->first();

            // dd('');

            $status_semua_juli_count = is_null($status_semua_juli) ? 1 : $status_semua_juli->count_v_issues_status;

            $status_close_done_juli_count = $status_done_juli_count + $status_closed_juli_count;

            $status_close_done_juli_count_1 = $status_close_done_juli_count == 0 ? 0 : $status_close_done_juli_count;

            $persentase_juli = $status_close_done_juli_count / $status_semua_juli_count;

            $tb_2[$i][6] = round($persentase_juli, 4) * 100 . '%';

            $status_close_done_juli_sla_count = $status_done_juli_sla_count;

            if ($status_done_juli_1_count == 0){
                $persentase_juli_sla = 0;
            } else {
                $persentase_juli_sla = $status_close_done_juli_sla_count / $status_done_juli_1_count;
            }

            // dd($status_close_done_juli_sla_count, $status_close_done_juli_count_1, $persentase_juli_sla, $status_close_done_juli_count, $status_semua_juli_count, $status_done_juli_count, $status_done_juli_1_count);

            $tb_2[$i][18] = round($persentase_juli_sla, 4) * 100 . '%';








            $status_done_agustus = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_agustus_count = is_null($status_done_agustus) ? 0 : $status_done_agustus->count_v_issues_status;

            $status_closed_agustus = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_agustus_count = is_null($status_closed_agustus) ? 0 : $status_closed_agustus->count_v_issues_status;

            // $status_done_agustus_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_agustus_sla_count = is_null($status_done_agustus_sla) ? 0 : $status_done_agustus_sla->count_v_issues_status;

            $status_done_agustus_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_agustus_sla_count = count($status_done_agustus_sla) == 0 ? 0 : count($status_done_agustus_sla);



            $status_done_agustus_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_agustus_1_count = count($status_done_agustus_1) == 0 ? 0 : count($status_done_agustus_1);
            
            
            // $status_closed_agustus_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_agustus_sla_count = is_null($status_closed_agustus_sla) ? 0 : $status_closed_agustus_sla->count_v_issues_status;

            $status_semua_agustus = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'")
                ->get()
                ->first();

            $status_semua_agustus_count = is_null($status_semua_agustus) ? 1 : $status_semua_agustus->count_v_issues_status;

            $status_close_done_agustus_count = $status_done_agustus_count + $status_closed_agustus_count;

            $persentase_agustus = $status_close_done_agustus_count / $status_semua_agustus_count;

            $status_close_done_agustus_count_1 = $status_close_done_agustus_count == 0 ? 0 : $status_close_done_agustus_count;

            $tb_2[$i][7] = round($persentase_agustus, 4) * 100 . '%';

            $status_close_done_agustus_sla_count = $status_done_agustus_sla_count;

            if ($status_done_agustus_1_count == 0){
                $persentase_agustus_sla = 0;
            } else {
                $persentase_agustus_sla = $status_close_done_agustus_sla_count / $status_done_agustus_1_count;
            }

            $tb_2[$i][19] = round($persentase_agustus_sla, 4) * 100 . '%';









            $status_done_september = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_september_count = is_null($status_done_september) ? 0 : $status_done_september->count_v_issues_status;

            $status_closed_september = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_september_count = is_null($status_closed_september) ? 0 : $status_closed_september->count_v_issues_status;


            // $status_done_september_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_september_sla_count = is_null($status_done_september_sla) ? 0 : $status_done_september_sla->count_v_issues_status;

            
            $status_done_september_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_september_sla_count = count($status_done_september_sla) == 0 ? 0 : count($status_done_september_sla);

            $status_done_september_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_september_1_count = count($status_done_september_1) == 0 ? 0 : count($status_done_september_1);
            
            // $status_closed_september_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_september_sla_count = is_null($status_closed_september_sla) ? 0 : $status_closed_september_sla->count_v_issues_status;

            $status_semua_september = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'")
                ->get()
                ->first();

            $status_semua_september_count = is_null($status_semua_september) ? 1 : $status_semua_september->count_v_issues_status;

            $status_close_done_september_count = $status_done_september_count + $status_closed_september_count;

            $status_close_done_september_count_1 = $status_close_done_september_count == 0 ? 0 : $status_close_done_september_count;

            $persentase_september = $status_close_done_september_count / $status_semua_september_count;

            $tb_2[$i][8] = round($persentase_september, 4) * 100 . '%';

            $status_close_done_september_sla_count = $status_done_september_sla_count;

            if ($status_done_september_1_count == 0){
                $persentase_september_sla = 0;
            } else {
                $persentase_september_sla = $status_close_done_september_sla_count / $status_done_september_1_count;
            }

            $tb_2[$i][20] = round($persentase_september_sla, 4) * 100 . '%';





            $status_done_oktober = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-10'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_oktober_count = is_null($status_done_oktober) ? 0 : $status_done_oktober->count_v_issues_status;

            $status_closed_oktober = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-10'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_oktober_count = is_null($status_closed_oktober) ? 0 : $status_closed_oktober->count_v_issues_status;

            // $status_done_oktober_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-10'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_oktober_sla_count = is_null($status_done_oktober_sla) ? 0 : $status_done_oktober_sla->count_v_issues_status;

            $status_done_oktober_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-10'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_oktober_sla_count = count($status_done_oktober_sla) == 0 ? 0 : count($status_done_oktober_sla);




            $status_done_oktober_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-10'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_oktober_1_count = count($status_done_oktober_1) == 0 ? 0 : count($status_done_oktober_1);

            // $status_closed_oktober_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-10'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_oktober_sla_count = is_null($status_closed_oktober_sla) ? 0 : $status_closed_oktober_sla->count_v_issues_status;

            $status_semua_oktober = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-10'")
                ->get()
                ->first();

            $status_semua_oktober_count = is_null($status_semua_oktober) ? 1 : $status_semua_oktober->count_v_issues_status;

            $status_close_done_oktober_count = $status_done_oktober_count + $status_closed_oktober_count;

            $status_close_done_oktober_count_1 = $status_close_done_oktober_count == 0 ? 0 : $status_close_done_oktober_count;

            $persentase_oktober = $status_close_done_oktober_count / $status_semua_oktober_count;

            $tb_2[$i][9] = round($persentase_oktober, 4) * 100 . '%';

            $status_close_done_oktober_sla_count = $status_done_oktober_sla_count;

            if ($status_done_oktober_1_count == 0){
                $persentase_oktober_sla = 0;
            } else {
                $persentase_oktober_sla = $status_close_done_oktober_sla_count / $status_done_oktober_1_count;
            }

            $tb_2[$i][21] = round($persentase_oktober_sla, 4) * 100 . '%';







            $status_done_november = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_november_count = is_null($status_done_november) ? 0 : $status_done_november->count_v_issues_status;

            $status_closed_november = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_november_count = is_null($status_closed_november) ? 0 : $status_closed_november->count_v_issues_status;


            // $status_done_november_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_november_sla_count = is_null($status_done_november_sla) ? 0 : $status_done_november_sla->count_v_issues_status;

            
            $status_done_november_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_november_sla_count = count($status_done_november_sla) == 0 ? 0 : count($status_done_november_sla);




            $status_done_november_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_november_1_count = count($status_done_november_1) == 0 ? 0 : count($status_done_november_1);
            
            // $status_closed_november_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'")
            //     ->whereRaw("v_issues.status = '4'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_closed_november_sla_count = is_null($status_closed_november_sla) ? 0 : $status_closed_november_sla->count_v_issues_status;

            $status_semua_november = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'")
                ->get()
                ->first();

            $status_semua_november_count = is_null($status_semua_november) ? 1 : $status_semua_november->count_v_issues_status;

            $status_close_done_november_count = $status_done_november_count + $status_closed_november_count;

            $status_close_done_november_count_1 = $status_close_done_november_count == 0 ? 0 : $status_close_done_november_count;

            $persentase_november = $status_close_done_november_count / $status_semua_november_count;

            $tb_2[$i][10] = round($persentase_november, 4) * 100 . '%';

            
            $status_close_done_november_sla_count = $status_done_november_sla_count;

            if ($status_done_november_1_count == 0){
                $persentase_november_sla = 0;
            } else {
                $persentase_november_sla = $status_close_done_november_sla_count / $status_done_november_1_count;
            }

            $tb_2[$i][22] = round($persentase_november_sla, 4) * 100 . '%';










            $status_done_desember = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'")
                ->whereRaw("v_issues.status = '3'")
                ->get()
                ->first();

            $status_done_desember_count = is_null($status_done_desember) ? 0 : $status_done_desember->count_v_issues_status;

            $status_closed_desember = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'")
                ->whereRaw("v_issues.status = '4'")
                ->get()
                ->first();

            $status_closed_desember_count = is_null($status_closed_desember) ? 0 : $status_closed_desember->count_v_issues_status;



            // $status_done_desember_sla = DB::table('v_issues')
            //     ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            //     ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            //     ->groupBy(DB::raw('v_issues.status'))
            //     // ->orderBy('v_issues.status', 'ASC')
            //     ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            //     ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'")
            //     ->whereRaw("v_issues.status = '3'")
            //     ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
            //     ->get()
            //     ->first();

            // $status_done_desember_sla_count = is_null($status_done_desember_sla) ? 0 : $status_done_desember_sla->count_v_issues_status;

            
            $status_done_desember_sla = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'
                    AND issues_status.created_at <= v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_desember_sla_count = count($status_done_desember_sla) == 0 ? 0 : count($status_done_desember_sla);




            $status_done_desember_1 = DB::select(DB::raw(
                " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
            ));

            // dd(count($status_done_januari_sla));

            $status_done_desember_1_count = count($status_done_desember_1) == 0 ? 0 : count($status_done_desember_1);
            
            
            $status_closed_desember_sla = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                ->groupBy(DB::raw('v_issues.status'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'")
                ->whereRaw("v_issues.status = '4'")
                ->whereRaw("v_issues.issues_status_created_at <= v_issues.tanggal_batas_issues")
                ->get()
                ->first();

            $status_closed_desember_sla_count = is_null($status_closed_desember_sla) ? 0 : $status_closed_desember_sla->count_v_issues_status;

            $status_semua_desember = DB::table('v_issues')
                ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
                ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                // ->orderBy('v_issues.status', 'ASC')
                ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'")
                ->get()
                ->first();

            $status_semua_desember_count = is_null($status_semua_desember) ? 1 : $status_semua_desember->count_v_issues_status;

            $status_close_done_desember_count = $status_done_desember_count + $status_closed_desember_count;

            $status_close_done_desember_count_1 = $status_close_done_desember_count == 0 ? 0 : $status_close_done_desember_count;

            $persentase_desember = $status_close_done_desember_count / $status_semua_desember_count;

            $tb_2[$i][11] = round($persentase_desember, 4) * 100 . '%';


            $status_close_done_desember_sla_count = $status_done_desember_sla_count;

            if ($status_done_desember_1_count == 0){
                $persentase_desember_sla = 0;
            } else {
                $persentase_desember_sla = $status_close_done_desember_sla_count / $status_done_desember_1_count;
            }

            $tb_2[$i][23] = round($persentase_desember_sla, 4) * 100 . '%';
        }

        // dd($tb_2);
        $datas['tb_2'] = $tb_2;
        // dd($datas);

        // dd($aray_period_y_m);

        $jenis_layanan = DB::table('v_issues')
            ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
            ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            // ->orderBy('v_issues.status', 'ASC')
            ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'")
            ->get();

        $tb_3 = [];
        $no3 = 0;
        $periode = [];

        // dd($aray_period_y_m);

        

        $no_layanan = 0;

        foreach ($aray_period_y_m as $data => $value1) {
            // dd($value);
            // $periode[$value] = [];
            // $periode = [];

            // dd(explode(',', $request->checkbox));

            $data_layanan_arr = [];
            $data_layanan = DB::table('m_layanan')
                ->select(DB::raw('m_layanan.*, m_kategori.nama_kategori'))
                ->leftJoin('m_kategori', 'm_kategori.id', '=', 'm_layanan.m_kategori_id')
                ->orderBy(DB::raw('m_kategori.nama_kategori'), 'ASC')
                ->whereIn('m_layanan.id', $checkbox_arr)
                ->get();
        
            foreach ($data_layanan as $data) {
                $dt_sub_arr = [];
                    $data_subject = DB::table('m_subject')
                    ->select(DB::raw('m_subject.*'))
                    ->orderBy(DB::raw('m_subject.id'), 'ASC')
                    ->where('m_subject.m_layanan_id', '=', $data->id)
                    ->get();
                    
                foreach($data_subject as $dt_sub){
                    $status_open = DB::table('v_issues')
                        ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, v_issues.layanan_id, COUNT ( v_issues.status ) AS count_v_issues_status'))
                        ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                        ->groupBy(DB::raw('v_issues.status'))
                        ->groupBy(DB::raw('v_issues.layanan_id'))
                        // ->orderBy('v_issues.status', 'ASC')
                        ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value1'")
                        ->whereRaw("v_issues.subject_id = '$dt_sub->id'")
                        ->whereRaw("v_issues.status = '1'")
                        // ->whereIn('v_issues.layanan_id', $checkbox_arr)
                        ->get()
                        ->first();

                    $status_progress = DB::table('v_issues')
                        ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, v_issues.layanan_id, COUNT ( v_issues.status ) AS count_v_issues_status'))
                        ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                        ->groupBy(DB::raw('v_issues.status'))
                        ->groupBy(DB::raw('v_issues.layanan_id'))
                        // ->orderBy('v_issues.status', 'ASC')
                        ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value1'")
                        ->whereRaw("v_issues.subject_id = '$dt_sub->id'")
                        ->whereRaw("v_issues.status = '2'")
                        // ->whereIn('v_issues.layanan_id', $checkbox_arr)
                        ->get()
                        ->first();

                    $status_done = DB::table('v_issues')
                        ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, v_issues.layanan_id, COUNT ( v_issues.status ) AS count_v_issues_status'))
                        ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                        ->groupBy(DB::raw('v_issues.status'))
                        ->groupBy(DB::raw('v_issues.layanan_id'))
                        // ->orderBy('v_issues.status', 'ASC')
                        ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value1'")
                        ->whereRaw("v_issues.subject_id = '$dt_sub->id'")
                        ->whereRaw("v_issues.status = '3'")
                        // ->whereIn('v_issues.layanan_id', $checkbox_arr)
                        ->get()
                        ->first();

                    $status_closed = DB::table('v_issues')
                        ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, v_issues.layanan_id, COUNT ( v_issues.status ) AS count_v_issues_status'))
                        ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                        ->groupBy(DB::raw('v_issues.status'))
                        ->groupBy(DB::raw('v_issues.layanan_id'))
                        // ->orderBy('v_issues.status', 'ASC')
                        ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value1'")
                        ->whereRaw("v_issues.subject_id = '$dt_sub->id'")
                        ->whereRaw("v_issues.status = '4'")
                        // ->whereIn('v_issues.layanan_id', $checkbox_arr)
                        ->get()
                        ->first();

                    $status_onhold = DB::table('v_issues')
                        ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, v_issues.layanan_id, COUNT ( v_issues.status ) AS count_v_issues_status'))
                        ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
                        ->groupBy(DB::raw('v_issues.status'))
                        ->groupBy(DB::raw('v_issues.layanan_id'))
                        // ->orderBy('v_issues.status', 'ASC')
                        ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$value1'")
                        ->whereRaw("v_issues.subject_id = '$dt_sub->id'")
                        ->whereRaw("v_issues.status = '6'")
                        // ->whereIn('v_issues.layanan_id', $checkbox_arr)
                        ->get()
                        ->first();

                    // dd($status_onhold);
                    $dt_sub_arr[(!empty($dt_sub->kategori_subject) ? $dt_sub->kategori_subject . '-' : ' ') . $dt_sub->nama_subject] = array(
                        'status_open' => is_null($status_open) ? 0 : $status_open->count_v_issues_status,
                        'status_progress' => is_null($status_progress) ? 0 : $status_progress->count_v_issues_status,
                        'status_done' => is_null($status_done) ? 0 : $status_done->count_v_issues_status,
                        'status_closed' => is_null($status_closed) ? 0 : $status_closed->count_v_issues_status,
                        'status_onhold' => is_null($status_onhold) ? 0 : $status_onhold->count_v_issues_status
                    );
                }
        
                if (count($data_subject) == 0){
        
                } else {
                    $data_layanan_arr['( '. $data->nama_kategori . ' ) '. $data->nama_layanan] = $dt_sub_arr;
                }
                
            }
            
            $periode[$value1] = $data_layanan_arr;
            
            $tb_3[$no3]['periode'] = $value;
            $tb_3[$no3]['jumlah_status_open'] =
                is_null($status_open) ? 0 : $status_open->count_v_issues_status;
            $tb_3[$no3]['jumlah_status_progress'] =
                is_null($status_progress) ? 0 : $status_progress->count_v_issues_status;
            $tb_3[$no3]['jumlah_status_done'] =
                is_null($status_done) ? 0 : $status_done->count_v_issues_status;
            $tb_3[$no3]['jumlah_status_closed'] =
                is_null($status_closed) ? 0 : $status_closed->count_v_issues_status;
            $tb_3[$no3]['jumlah_status_onhold'] =
                is_null($status_onhold) ? 0 : $status_onhold->count_v_issues_status;

            $no3++;
        }

        $jumlah_eskalasi_pi = DB::table('v_issues')
            ->where(function ($query) use ($awal, $akhir, $checkbox_arr) {
                $query->orWhereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 4) >= '$awal'");
                $query->orWhereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 4) <= '$akhir'");
                $query->WhereIn('v_issues.layanan_id', $checkbox_arr);
            })
            ->whereNotNull('tiket_cares_pi')
        ->count();

        // $datas = [];
        $datas['tb_3'] = $tb_3;
        $datas['tb_3_1'] = $aray_period_years;
        $datas['periode'] = $periode;
        $datas['jumlah_eskalasi_pi'] = $jumlah_eskalasi_pi;

        // dd($request->all());

        $options = array("format" => "A4-L", "defaultFont" => "arial", "orientation" => "L");
        $pdf = PDF::loadView('pages.rekap_data_issues_bulanan.export_pdf', $datas, [], $options);
        $pdf->download('Report issues helpdesk Bulanan ' . $awal . ' - ' . $akhir . '.pdf');
    }
}
