<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class HomeController extends Controller
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
        // dd(Session::get('user_app'));

        $setting_data = [
            'host_url' => 'https://dashboardpengadaan.petrokimia-gresik.com/',
            'embed_code_version' => '3',
            'site_root' => '',
            'tabs' => 'no',
            'toolbar' => 'yes',
            'showAppBanner' => 'false',
            'filter' => 'iframeSizedToWindow=true'
        ];
        $base_url = 'https://dashboardpengadaan.petrokimia-gresik.com/';

        $userid = 'admin_petro01';
        $loginparams = 'username=' . $userid;
        $url = $base_url . 'trusted/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $loginparams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $tickets = curl_exec($ch);
        // dd($ch);
        // dd($tickets);
        curl_close($ch);
        $url_req = $url . $tickets . '/';

        $data = [
            'setting_data' => $setting_data,
            // 'array_data'   => $array_data,
            'tickets'      => $tickets,
            // 'baseurl'      => $array_data[$paramgets]['menu'],
            'isimenu'      => 'helpdeskti/Dashboard1',
            // 'title'        => $array_data[$paramgets]['title'],
            // 'params'       => $paramgets,
            // 'namingparam' => $paramgets
        ];


        $data['judul'] = "Home";
        return view('pages.home.index', $data);
        // dd(onHoldTimer('2023-03-14 15:52:47', '2023-03-15 08:00:43', '2023-02-16 09:15:31'));
    }

    public function getIssuesPerBulan($kategori_search, $tanggal_search_val)
    {

        // dd($tanggal_search_val);

        if ($kategori_search == 'bulan') { // kategori_search = 1 (per bulan), kategori_search = 2 (per hari)

            $tahun_search = substr($tanggal_search_val, 0, 4);
            $bulan_search = substr($tanggal_search_val, 5, 2);
            // dd($tanggal_search_val);
            if ($bulan_search == '01') {
                $bulan = "Januari";
            } else if ($bulan_search == '02') {
                $bulan = "Februari";
            } else if ($bulan_search == '03') {
                $bulan = "Maret";
            } else if ($bulan_search == '04') {
                $bulan = "April";
            } else if ($bulan_search == '05') {
                $bulan = "Mei";
            } else if ($bulan_search == '06') {
                $bulan = "Juni";
            } else if ($bulan_search == '07') {
                $bulan = "Juli";
            } else if ($bulan_search == '08') {
                $bulan = "Agustus";
            } else if ($bulan_search == '09') {
                $bulan = "September";
            } else if ($bulan_search == '10') {
                $bulan = "Oktober";
            } else if ($bulan_search == '11') {
                $bulan = "November";
            } else if ($bulan_search == '12') {
                $bulan = "Desember";
            }
            // $tahun_bulan_tanggal_search_final = $tahun_search . '-' . $bulan_search;
            $tahun_bulan_tanggal_search_final = '';

            $array_data_issues_count = [];

            $data_jumlah_tanggal_per_bulan = cal_days_in_month(CAL_GREGORIAN, $bulan_search, $tahun_search);
            // dd($data_jumlah_tanggal_per_bulan);
            $jumlah = 0;
            for ($k = 1; $k <= $data_jumlah_tanggal_per_bulan; $k++) {
                if (strlen($k) == 1) {
                    $tahun_bulan_tanggal_search_final = $tahun_search . '-' . $bulan_search . '-' . '0' . $k;
                    // dd($tahun_bulan_tanggal_search_final);
                } else {
                    $tahun_bulan_tanggal_search_final = $tahun_search . '-' . $bulan_search . '-' . $k;
                }

                $data_issues = db::table('v_issues')
                    ->select(DB::raw('v_issues.id'))
                    ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 10) = '$tahun_bulan_tanggal_search_final' ")
                    ->groupBy('v_issues.id')
                    ->get();
                $jumlah += count($data_issues);
                $array_data_issues_count[] = count($data_issues);
            }

            // dd($jumlah);

            return response()->json([
                'data_issues' => $data_issues,
                'sumbu_y' => $array_data_issues_count,
                'sumbu_x' => $data_jumlah_tanggal_per_bulan,
                'bulan' => $bulan,
                'jumlah' => $jumlah,
                'tanggal_search_val' => $tanggal_search_val,
                'kode' => 201
            ]);
        } else if ($kategori_search == 'hari') {

            // dd($tanggal_search_val);
            $tahun_search = substr($tanggal_search_val, 0, 4);
            $bulan_search = substr($tanggal_search_val, 5, 2);
            $tanggal_search = substr($tanggal_search_val, 8, 2);
            if ($bulan_search == '01') {
                $bulan = "Januari";
            } else if ($bulan_search == '02') {
                $bulan = "Februari";
            } else if ($bulan_search == '03') {
                $bulan = "Maret";
            } else if ($bulan_search == '04') {
                $bulan = "April";
            } else if ($bulan_search == '05') {
                $bulan = "Mei";
            } else if ($bulan_search == '06') {
                $bulan = "Juni";
            } else if ($bulan_search == '07') {
                $bulan = "Juli";
            } else if ($bulan_search == '08') {
                $bulan = "Agustus";
            } else if ($bulan_search == '09') {
                $bulan = "September";
            } else if ($bulan_search == '10') {
                $bulan = "Oktober";
            } else if ($bulan_search == '11') {
                $bulan = "November";
            } else if ($bulan_search == '12') {
                $bulan = "Desember";
            }
            $tahun_bulan_tanggal_search_final = '';

            $array_data_issues_count = [];

            // $data_jumlah_tanggal_per_bulan = cal_days_in_month(CAL_GREGORIAN, $bulan_search, $tahun_search);

            $data_issues = db::table('issues')
                ->select(DB::raw('issues.tanggal_batas_issues'))
                ->whereRaw("substring(issues.tanggal_pembuatan_issues, 1, 10) = '$tanggal_search_val' ")
                ->groupBy('issues.tanggal_batas_issues')
                ->get();

            $data_issues_count = count($data_issues);

            $jumlah = db::table('issues')
                ->select(DB::raw('issues.id'))
                ->whereRaw("substring(issues.tanggal_pembuatan_issues, 1, 7) = '" . $tahun_search . "-" . $bulan_search . "'")
                ->count();

            // dd($data_issues_count);

            return response()->json([
                'data_issues' => $data_issues,
                'sumbu_y' => array(0, $data_issues_count),
                'sumbu_x' => array(0, $tanggal_search_val),
                'tanggal_search_val' => $tanggal_search_val,
                'bulan' => $bulan,
                'jumlah' => $jumlah,
                'kode' => 201
            ]);
        } else {
        }
    }

    public function getCountIssuePerBulan($kategori_search, $tanggal_search_val)
    {
        if ($kategori_search == 'bulan') {

            for ($i = 1; $i <= 6; $i++) {
                if ($i == 5) {
                    $i - 1;
                } else if ($i == 6) {
                    $query = db::table('v_issues')
                        ->select(DB::raw('v_issues.id'))
                        ->where('v_issues.status', '=', $i)
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$tanggal_search_val' ")
                        ->get();

                    $data[4] = count($query);
                } else {
                    $query = db::table('v_issues')
                        ->select(DB::raw('v_issues.id'))
                        ->where('v_issues.status', '=', $i)
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$tanggal_search_val' ")
                        ->get();

                    $data[$i - 1] = count($query);
                }
            }
            return response()->json([
                'data' => $data,
                'kode' => 201
            ]);
        } else if ($kategori_search == 'hari') {

            for ($i = 1; $i <= 6; $i++) {

                if ($i == 5) {
                    $i - 1;
                } else if ($i == 6) {
                    $query = db::table('v_issues')
                        ->select(DB::raw('v_issues.id'))
                        ->where('v_issues.status', '=', $i)
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 10) = '$tanggal_search_val' ")
                        ->get();
                    $data[4] = count($query);
                } else {
                    $query = db::table('v_issues')
                        ->select(DB::raw('v_issues.id'))
                        ->where('v_issues.status', '=', $i)
                        ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 10) = '$tanggal_search_val' ")
                        ->get();
                    $data[$i - 1] = count($query);
                }
            }

            return response()->json([
                'data' => $data,
                'kode' => 201
            ]);
        }
    }

    public function getJumlahIssueByKategori(Request $request, $kategori_search, $tanggal_search_val)
    {

        if ($kategori_search == 'bulan') {

            $query = db::select("SELECT issues.kategori_id,
                    m_kategori.nama_kategori,
                    count(issues.id) AS count
                FROM (issues
                    LEFT JOIN m_kategori ON (((m_kategori.id)::text = (issues.kategori_id)::text)))
                WHERE issues.kategori_id IS NOT NULL
                AND substring(issues.tanggal_pembuatan_issues, 1, 7) = '$tanggal_search_val'
                GROUP BY issues.kategori_id, m_kategori.nama_kategori
                ORDER BY (count(issues.id)) DESC");

        } else if ($kategori_search == 'hari') {
            $query = db::select("SELECT issues.kategori_id,
                    m_kategori.nama_kategori,
                    count(issues.id) AS count
                FROM (issues
                    LEFT JOIN m_kategori ON (((m_kategori.id)::text = (issues.kategori_id)::text)))
                WHERE issues.kategori_id IS NOT NULL
                AND substring(issues.tanggal_pembuatan_issues, 1, 10) = '$tanggal_search_val'
                GROUP BY issues.kategori_id, m_kategori.nama_kategori
                ORDER BY (count(issues.id)) DESC");
        }

        // $query = db::table('jumlah_issue_by_kategori')
        //         ->select(DB::raw('jumlah_issue_by_kategori.*'))
        //         ->get();

        $data_jumlah_per_issue = [];
        $data_nama_per_issue = [];
        foreach ($query as $data) {
            $data_jumlah_per_issue[] = $data->count;
            $data_nama_per_issue[] = $data->nama_kategori;
        }

        return response()->json([
            'data_jumlah_per_issue' => $data_jumlah_per_issue,
            'data_nama_per_issue' => $data_nama_per_issue,
            'kode' => 201
        ]);
    }

    public function getJumlahIssueByLayananTop(Request $request, $kategori_search, $tanggal_search_val)
    {

        if ($kategori_search == 'bulan') {

            $query = db::select("SELECT issues.kategori_id,
                    issues.layanan_id,
                    m_layanan.nama_layanan,
                    count(issues.id) AS count
                FROM (issues
                    LEFT JOIN m_layanan ON (((m_layanan.id)::text = (issues.layanan_id)::text)))
                WHERE issues.kategori_id IS NOT NULL
                AND substring(issues.tanggal_pembuatan_issues, 1, 7) = '$tanggal_search_val'
                GROUP BY issues.kategori_id, issues.layanan_id, m_layanan.nama_layanan
                ORDER BY count(issues.id) DESC 
                LIMIT 10");

        } else if ($kategori_search == 'hari') {

            $query = db::select("SELECT issues.kategori_id,
                    issues.layanan_id,
                    m_layanan.nama_layanan,
                    count(issues.id) AS count
                FROM (issues
                    LEFT JOIN m_layanan ON (((m_layanan.id)::text = (issues.layanan_id)::text)))
                WHERE issues.kategori_id IS NOT NULL
                AND substring(issues.tanggal_pembuatan_issues, 1, 10) = '$tanggal_search_val'
                GROUP BY issues.kategori_id, issues.layanan_id, m_layanan.nama_layanan
                ORDER BY count(issues.id) DESC 
                LIMIT 10");

        }

        $data_jumlah_per_issue = [];
        $data_nama_per_issue = [];
        foreach ($query as $data) {
            $data_jumlah_per_issue[] = $data->count;
            $data_nama_per_issue[] = $data->nama_layanan;
        }

        return response()->json([
            'data_jumlah_per_issue' => $data_jumlah_per_issue,
            'data_nama_per_issue' => $data_nama_per_issue,
            'kode' => 201
        ]);

        // return response()->json([
        //     'data' => $query,
        //     'kode' => 201
        // ]);
    }

    public function getJumlahIssueByLayanan(Request $request, $kategori_search, $tanggal_search_val)
    {

        if ($kategori_search == 'bulan') {

            $query = db::select("SELECT issues.kategori_id,
                    issues.layanan_id,
                    m_layanan.nama_layanan,
                    count(issues.id) AS count
                FROM (issues
                    LEFT JOIN m_layanan ON (((m_layanan.id)::text = (issues.layanan_id)::text)))
                WHERE issues.layanan_id IS NOT NULL
                AND substring(issues.tanggal_pembuatan_issues, 1, 7) = '$tanggal_search_val'
                GROUP BY issues.kategori_id, issues.layanan_id, m_layanan.nama_layanan
                ORDER BY (count(issues.id)) DESC");

        } else if ($kategori_search == 'hari') {

            $query = db::select("SELECT issues.kategori_id,
                    issues.layanan_id,
                    m_layanan.nama_layanan,
                    count(issues.id) AS count
                FROM (issues
                    LEFT JOIN m_layanan ON (((m_layanan.id)::text = (issues.layanan_id)::text)))
                WHERE issues.layanan_id IS NOT NULL
                AND substring(issues.tanggal_pembuatan_issues, 1, 10) = '$tanggal_search_val'
                GROUP BY issues.kategori_id, issues.layanan_id, m_layanan.nama_layanan
                ORDER BY (count(issues.id)) DESC");

        }

        // $query = db::table('jumlah_issue_by_layanan')
        //     ->select(DB::raw('jumlah_issue_by_layanan.*'))
        //     // ->limit(7)
        //     ->get();

        $data_jumlah_per_issue = [];
        $data_nama_per_issue = [];
        foreach ($query as $data) {
            $data_jumlah_per_issue[] = $data->count;
            $data_nama_per_issue[] = $data->nama_layanan;
        }

        return response()->json([
            'data_jumlah_per_issue' => $data_jumlah_per_issue,
            'data_nama_per_issue' => $data_nama_per_issue,
            'kode' => 201
        ]);

        return response()->json([
            'data' => $query,
            'kode' => 201
        ]);
    }

    public function getJumlahIssueBySubject(Request $request)
    {
        $query = db::table('jumlah_issue_by_subject')
            ->select(DB::raw('jumlah_issue_by_subject.*'))
            ->get();

        $data_jumlah_per_issue = [];
        $data_nama_per_issue = [];
        foreach ($query as $data) {
            $data_jumlah_per_issue[] = $data->count;
            $data_nama_per_issue[] = $data->nama_subject;
        }

        return response()->json([
            'data_jumlah_per_issue' => $data_jumlah_per_issue,
            'data_nama_per_issue' => $data_nama_per_issue,
            'kode' => 201
        ]);
    }

    public function getJumlahIssueBySubjectDatatable(Request $request, $kategori_search, $tanggal_search_val)
    {

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            if ($kategori_search == 'bulan') {

                $m_subject = db::select("SELECT issues.kategori_id,
                            issues.layanan_id,
                            issues.subject_id,
                            m_subject.nama_subject,
                            count(issues.id) AS count
                        FROM (issues
                            JOIN m_subject ON (((m_subject.id)::text = (issues.subject_id)::text)))
                        WHERE issues.subject_id IS NOT NULL
                        AND substring(issues.tanggal_pembuatan_issues, 1, 7) = '$tanggal_search_val'
                        GROUP BY issues.kategori_id, issues.layanan_id, issues.subject_id, m_subject.nama_subject
                        ORDER BY (count(issues.id)) DESC");

            } else if ($kategori_search == 'hari') {
                $m_subject = db::select("SELECT issues.kategori_id,
                            issues.layanan_id,
                            issues.subject_id,
                            m_subject.nama_subject,
                            count(issues.id) AS count
                        FROM (issues
                            JOIN m_subject ON (((m_subject.id)::text = (issues.subject_id)::text)))
                        WHERE issues.subject_id IS NOT NULL
                        AND substring(issues.tanggal_pembuatan_issues, 1, 10) = '$tanggal_search_val'
                        GROUP BY issues.kategori_id, issues.layanan_id, issues.subject_id, m_subject.nama_subject
                        ORDER BY (count(issues.id)) DESC");
            }

            // $jumlah_issue_by_subject = DB::table('jumlah_issue_by_subject')
            //     ->select(DB::raw("jumlah_issue_by_subject.*"));

            // // $datax['total_data'] = $tb_users->first();
            $total_data = count($m_subject);


            // $m_subject = $jumlah_issue_by_subject
            //     ->limit($limit)
            //     ->offset($offset)
            //     ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_subject) > 0) {

                foreach ($m_subject as $value) {
                    // dd($value['nama']);

                    $datas[] = array(

                        'no' => $no++,
                        'nama_subject' => $value->nama_subject,
                        'count' => $value->count,
                    );
                }
            } else {
                $datas = array();
            }

            // dd($datas);
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function getDataDashboardIssueBulanan(Request $request)
    {
        $tahun = $request["tahun"];
        $draw = $request["draw"];
        $i = $tahun;

        $tb_1 = [];

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

        $status_done_januari_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

        $status_done_januari_sla_count = count($status_done_januari_sla) == 0 ? 0 : count($status_done_januari_sla);

        $status_done_januari_1 = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-01'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

        $status_done_januari_1_count = count($status_done_januari_1) == 0 ? 0 : count($status_done_januari_1);

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

        $status_close_done_januari_count_1 = $status_close_done_januari_count == 0 ? 0 : $status_close_done_januari_count;

        $persentase_januari = $status_close_done_januari_count / $status_semua_januari_count;

        $tb_1[0] = round($persentase_januari, 4) * 100;

        $status_close_done_januari_sla_count = $status_done_januari_sla_count;

        if ($status_done_januari_1_count == 0) {
            $persentase_sla_januari = 0;
        } else {
            $persentase_sla_januari = $status_close_done_januari_sla_count / $status_done_januari_1_count;
        }

        $tb_1[12] = round($persentase_sla_januari, 4) * 100;








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

        $status_done_februari_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-02'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_februari_1_count = count($status_done_februari_1) == 0 ? 0 : count($status_done_februari_1);

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

        $tb_1[1] = round($persentase_februari, 4) * 100;

        $status_close_done_februari_sla_count = $status_done_februari_sla_count;

        if ($status_done_februari_1_count == 0) {
            $persentase_februari_sla = 0;
        } else {
            $persentase_februari_sla = $status_close_done_februari_sla_count / $status_done_februari_1_count;
        }

        $tb_1[13] = round($persentase_februari_sla, 4) * 100;






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

        $status_done_maret_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-03'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_maret_1_count = count($status_done_maret_1) == 0 ? 0 : count($status_done_maret_1);

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

        $tb_1[2] = round($persentase_maret, 4) * 100;

        $status_close_done_maret_sla_count = $status_done_maret_sla_count;

        if ($status_done_maret_1_count == 0) {
            $persentase_maret_sla = 0;
        } else {
            $persentase_maret_sla = $status_close_done_maret_sla_count / $status_done_maret_1_count;
        }

        $tb_1[14] = round($persentase_maret_sla, 4) * 100;









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

        $status_done_april_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-04'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_april_1_count = count($status_done_april_1) == 0 ? 0 : count($status_done_april_1);

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

        $tb_1[3] = round($persentase_april, 4) * 100;

        $status_close_done_april_sla_count = $status_done_april_sla_count;

        if ($status_done_april_1_count == 0) {
            $persentase_april_sla = 0;
        } else {
            $persentase_april_sla = $status_close_done_april_sla_count / $status_done_april_1_count;
        }

        $tb_1[15] = round($persentase_april_sla, 4) * 100;









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

        $status_done_mei_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-05'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_1_sla_count = count($status_done_mei_1) == 0 ? 0 : count($status_done_mei_1);

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

        $tb_1[4] = round($persentase_mei, 4) * 100;

        $status_close_done_mei_sla_count = $status_done_mei_sla_count;

        if ($status_done_1_sla_count == 0) {
            $persentase_mei_sla = 0;
        } else {
            $persentase_mei_sla = $status_close_done_mei_sla_count / $status_done_1_sla_count;
        }



        $tb_1[16] = round($persentase_mei_sla, 4) * 100;











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

        $status_done_juni_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-06'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_juni_1_count = count($status_done_juni_1) == 0 ? 0 : count($status_done_juni_1);

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

        $tb_1[5] = round($persentase_juni, 4) * 100;

        $status_close_done_juni_sla_count = $status_done_juni_sla_count;

        if ($status_done_juni_1_count == 0) {
            $persentase_juni_sla = 0;
        } else {
            $persentase_juni_sla = $status_close_done_juni_sla_count / $status_done_juni_1_count;
        }



        $tb_1[17] = round($persentase_juni_sla, 4) * 100;









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

        $status_done_juli_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_juli_1_count = count($status_done_juli_1) == 0 ? 0 : count($status_done_juli_1);

        $status_semua_juli = DB::table('v_issues')
            ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, COUNT ( v_issues.status ) AS count_v_issues_status'))
            ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            // ->orderBy('v_issues.status', 'ASC')
            ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-07'")
            ->get()
            ->first();

        $status_semua_juli_count = is_null($status_semua_juli) ? 1 : $status_semua_juli->count_v_issues_status;

        $status_close_done_juli_count = $status_done_juli_count + $status_closed_juli_count;

        $status_close_done_juli_count_1 = $status_close_done_juli_count == 0 ? 0 : $status_close_done_juli_count;

        $persentase_juli = $status_close_done_juli_count / $status_semua_juli_count;

        $tb_1[6] = round($persentase_juli, 4) * 100;

        $status_close_done_juli_sla_count = $status_done_juli_sla_count;

        if ($status_done_juli_1_count == 0) {
            $persentase_juli_sla = 0;
        } else {
            $persentase_juli_sla = $status_close_done_juli_sla_count / $status_done_juli_1_count;
        }

        $tb_1[18] = round($persentase_juli_sla, 4) * 100;








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

        $status_done_agustus_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-08'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_agustus_1_count = count($status_done_agustus_1) == 0 ? 0 : count($status_done_agustus_1);

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

        $tb_1[7] = round($persentase_agustus, 4) * 100;

        $status_close_done_agustus_sla_count = $status_done_agustus_sla_count;

        if ($status_done_agustus_1_count == 0) {
            $persentase_agustus_sla = 0;
        } else {
            $persentase_agustus_sla = $status_close_done_agustus_sla_count / $status_done_agustus_1_count;
        }

        $tb_1[19] = round($persentase_agustus_sla, 4) * 100;









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

        $status_done_september_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-09'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_september_1_count = count($status_done_september_1) == 0 ? 0 : count($status_done_september_1);

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

        $tb_1[8] = round($persentase_september, 4) * 100;

        $status_close_done_september_sla_count = $status_done_september_sla_count;

        if ($status_done_september_1_count == 0) {
            $persentase_september_sla = 0;
        } else {
            $persentase_september_sla = $status_close_done_september_sla_count / $status_done_september_1_count;
        }

        $tb_1[20] = round($persentase_september_sla, 4) * 100;





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

            $tb_1[9] = round($persentase_oktober, 4) * 100 . '%';

            $status_close_done_oktober_sla_count = $status_done_oktober_sla_count;

            if ($status_done_oktober_1_count == 0){
                $persentase_oktober_sla = 0;
            } else {
                $persentase_oktober_sla = $status_close_done_oktober_sla_count / $status_done_oktober_1_count;
            }

            $tb_1[21] = round($persentase_oktober_sla, 4) * 100 . '%';







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

        $status_done_november_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

        $status_done_november_sla_count = count($status_done_november_sla) == 0 ? 0 : count($status_done_november_sla);

        $status_done_november_1 = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-11'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

        $status_done_november_1_count = count($status_done_november_1) == 0 ? 0 : count($status_done_november_1);

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

        $tb_1[10] = round($persentase_november, 4) * 100;


        $status_close_done_november_sla_count = $status_done_november_sla_count;

        if ($status_done_november_1_count == 0) {
            $persentase_november_sla = 0;
        } else {
            $persentase_november_sla = $status_close_done_november_sla_count / $status_done_november_1_count;
        }

        $tb_1[22] = round($persentase_november_sla, 4) * 100;










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

        $status_done_desember_sla = DB::select(DB::raw(
            " 
                    SELECT DISTINCT on (issues_status.tiket_issues) issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    FROM issues_status
                    JOIN v_issues on v_issues.tiket_issues = issues_status.tiket_issues
                    WHERE issues_status.status = '3'
                    AND substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'
                    AND issues_status.created_at < v_issues.tanggal_batas_issues
                    GROUP BY issues_status.id, issues_status.tiket_issues, issues_status.status, issues_status.catatan, issues_status.created_at
                    ORDER BY issues_status.tiket_issues, issues_status.id DESC
                "
        ));

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

        $status_done_desember_1_count = count($status_done_desember_1) == 0 ? 0 : count($status_done_desember_1);


        $status_closed_desember_sla = DB::table('v_issues')
            ->select(DB::raw('substring(v_issues.tanggal_pembuatan_issues, 1, 7) as v_issues_tanggal_pembuatan_issues, v_issues.status, COUNT ( v_issues.status ) AS count_v_issues_status'))
            ->groupBy(DB::raw('v_issues_tanggal_pembuatan_issues'))
            ->groupBy(DB::raw('v_issues.status'))
            // ->orderBy('v_issues.status', 'ASC')
            ->orderBy(DB::raw('v_issues_tanggal_pembuatan_issues'), 'ASC')
            ->whereRaw("substring(v_issues.tanggal_pembuatan_issues, 1, 7) = '$i-12'")
            ->whereRaw("v_issues.status = '4'")
            ->whereRaw("v_issues.issues_status_created_at < v_issues.tanggal_batas_issues")
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

        $tb_1[11] = round($persentase_desember, 4) * 100;


        $status_close_done_desember_sla_count = $status_done_desember_sla_count;

        if ($status_done_desember_1_count == 0) {
            $persentase_desember_sla = 0;
        } else {
            $persentase_desember_sla = $status_close_done_desember_sla_count / $status_done_desember_1_count;
        }

        $tb_1[23] = round($persentase_desember_sla, 4) * 100;

        // $datas['tb_1'] = $tb_1;

        // $datas = [];

        $datas[] = array(
            // 'judul' => 'Tingkat penyelesaian (%)',
            'januari' => round($tb_1[0], 1),
            'februari' => round($tb_1[1], 1),
            'maret' => round($tb_1[2], 1),
            'april' => round($tb_1[3], 1),
            'mei' => round($tb_1[4], 1),
            'juni' => round($tb_1[5], 1),
            'juli' => round($tb_1[6], 1),
            'agustus' => round($tb_1[7], 1),
            'september' => round($tb_1[8], 1),
            'oktober' => round($tb_1[9], 1),
            'november' => round($tb_1[10], 1),
            'desember' => round($tb_1[11], 1),
        );

        $datas[] = array(
            // 'judul' => 'Tingkat penyelesaian Sesuai SLA (%)',
            'januari' => round($tb_1[12], 1),
            'februari' => round($tb_1[13], 1),
            'maret' => round($tb_1[14], 1),
            'april' => round($tb_1[15], 1),
            'mei' => round($tb_1[16], 1),
            'juni' => round($tb_1[17], 1),
            'juli' => round($tb_1[18], 1),
            'agustus' => round($tb_1[19], 1),
            'september' => round($tb_1[20], 1),
            'oktober' => round($tb_1[21], 1),
            'november' => round($tb_1[22], 1),
            'desember' => round($tb_1[23], 1),
        );

        $data = $datas;

        // return response()->json(compact("data", "draw"));
        return response()->json([
            'data' => $data,
            'draw' => $draw,
            'kode' => 201
        ]);

        // return response()->json([
        //     'tb_1' => $tb_1,
        //     'kode' => 201
        // ]);
    }
}
