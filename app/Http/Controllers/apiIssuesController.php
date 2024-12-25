<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Session;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class apiIssuesController extends Controller
{
    public function getIssuesTiketClient(Request $request)
    {
        $data_arr    = [
            "token" => encrypt_(token_static_helpdesk()),
            "tiket_issues" => encrypt_("HLP-22-000001"),
        ];

        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);

        $url = url_app_helpdesk('api/getIssuesTiketServer');
        $response = $client->get($url, ['query' => $data_arr]);
        $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        dd($response_server);
        // return generateJson($response_server);
    }

    public function getIssuesTiketServer(Request $request)
    {

        // dd();
        // return generateJson($request->all());
        $token          = decrypt_($request->token);
        $tiket_issues   = decrypt_($request->tiket_issues);

        if ($token == token_static_helpdesk()) {
            try {
                $tb_issues = DB::table('issues')
                    ->select(DB::raw("
                    issues.tiket_issues as tiket_issues,
                    issues.username_sap_issues as username_sap_issues,
                    issues.username_sap_issues as telp_issues,
                    issues.description_issues as description_issues,
                    m_kategori.nama_kategori,
                    m_layanan.nama_layanan,
                    m_subject.nama_subject,
                    m_priority.nama_priority,
                    pegawai.nama as nama_pegawai"))
                    ->leftjoin('m_kategori', 'm_kategori.id', 'issues.kategori_id')
                    ->leftjoin('m_layanan', 'm_layanan.id', 'issues.layanan_id')
                    ->leftjoin('m_subject', 'm_subject.id', 'issues.subject_id')
                    ->leftjoin('m_priority', 'm_priority.id', 'issues.priority_id')
                    ->leftjoin('pegawai', 'pegawai.nik', 'issues.username_sap_issues');

                // $datax['total_data'] = $tb_users->first();

                $datax['issues'] = $tb_issues
                    ->where('issues.tiket_issues', '=', $tiket_issues)
                    ->get();

                $datax['kode'] = 200;

                return generateJson($datax);
            } catch (RequestException $e) {
                // return response()->json(['success' => $e, 'kode' => 401]);
                // dd($e->getMessage());
                return generateJson($e->getMessage());
                // return response()->json(['success' => $e, 'kode' => 201]);
            }
        } else {
            return response()->json(['error' => 'token anda salah', 'kode' => 401]);
        }
    }

    public function getListIssuesTiketClient(Request $request)
    {
        $data_arr    = [
            "token" => encrypt_(token_static_helpdesk()),
            "nik" => encrypt_("2145784"),
        ];

        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);

        $url = url_app_helpdesk('api/getListIssuesTiketServer');
        $response = $client->get($url, ['query' => $data_arr]);
        $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        dd($response_server);
    }

    public function getListIssuesTiketServer(Request $request)
    {
        $token          = decrypt_($request->token);
        $nik            = decrypt_($request->nik);

        // return generateJson($request->nik);

        if ($token == token_static_helpdesk()) {

            try {
                $tb_issues = DB::table('issues')
                    ->select(DB::raw("
                    issues.tiket_issues as tiket_issues,
                    issues.username_sap_issues as username_sap_issues,
                    issues.username_sap_issues as telp_issues,
                    issues.description_issues as description_issues,
                    m_kategori.nama_kategori,
                    m_layanan.nama_layanan,
                    m_subject.nama_subject,
                    m_priority.nama_priority,
                    pegawai.nama as nama_pegawai"))
                    ->leftjoin('m_kategori', 'm_kategori.id', 'issues.kategori_id')
                    ->leftjoin('m_layanan', 'm_layanan.id', 'issues.layanan_id')
                    ->leftjoin('m_subject', 'm_subject.id', 'issues.subject_id')
                    ->leftjoin('m_priority', 'm_priority.id', 'issues.priority_id')
                    ->leftjoin('pegawai', 'pegawai.nik', 'issues.username_sap_issues');

                $datax['issues'] = $tb_issues
                    ->where('m_kategori.id', '=', "K11") //ini untuk kategori yang berada di simasti
                    ->where('issues.username_sap_issues', '=', $nik)
                    ->get();

                $datax['kode'] = 200;

                return generateJson($datax);
            } catch (RequestException $e) {
                // return response()->json(['success' => $e, 'kode' => 401]);
                // dd($e->getMessage());
                return generateJson($e->getMessage());
                // return response()->json(['success' => $e, 'kode' => 201]);
            }
        } else {
            return response()->json(['error' => 'token anda salah', 'kode' => 401]);
        }
    }

    // public function getStatusIssuesDoneClient(Request $request)
    // {
    //     // $data_arr    = [
    //     //     "token" => encrypt_(token_static_helpdesk()),
    //     //     "tiket_issues" => encrypt_("HLP-22-000066"),
    //     // ];

    //     // dd($request->all());

    //     // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);

    //     // $url = url_app_helpdesk('api/postStatusIssuesDoneServer');
    //     // $response = $client->get($url, ['query' => $data_arr]);
    //     // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
    //     // dd($response_server);

    //     // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
    //     // $myBody = array(
    //     //     "tiket_issues" => $request->tiket_issues,
    //     // );
    //     // // $url = api_simasti()."api/data_issue_dev";
    //     // $url = "http://10.14.20.159/helpdesk_app/api/postStatusIssuesDoneServer";

    //     // $request = $client->post($url, ['form_params' => $myBody]);

    //     $data_arr    = [
    //         "tiket_issues" => $request->tiket_issues
    //     ];

    //     $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
    //     $url = "http://10.14.20.159/helpdesk_app/api/getStatusIssuesDoneServer";
    //     $response = $client->get($url, ['query' => $data_arr]);
    //     $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

    //     // dd($request);
    //     // return \GuzzleHttp\json_decode($request->getBody(), true);
    //     // $response = \GuzzleHttp\json_decode($request->getBody(), true);
    //     dd($response_server);
    // }

    public function postStatusIssuesDoneServer(Request $request)
    {
        // $token          = decrypt_($request->token);
        // return $request->all();
        $tiket_issues = $request->tiket_issues;
        // dd($tiket_issues);
        // return $request->tiket_issues;
        // dd($request);
        // return $tiket_issues;

        // return generateJson($tiket_issues);
        // return response()->json(['tiket_issues' => $tiket_issues, 'kode' => 401]);

        try {
            $get_issues_terakhir_id = get_status_terakhir_per_issues_id($tiket_issues);

            if ($get_issues_terakhir_id == 3) {
                return response()->json(['error' => 'your status is already done', 'kode' => 401]);
            } else {
                // return response()->json(['tiket_issues' => $tiket_issues, 'kode' => 401]);
                // return $tiket_issues;

                if ($get_issues_terakhir_id == 6){
                    // $tambah_issues_status = DB::table('issues_status')
                    // ->insert([
                    //     'tiket_issues' => $tiket_issues,
                    //     'status' => 6,
                    //     'catatan' => 'this issue is approved from SIMASTI apps',
                    //     'tanggal_onhold_start' => Carbon::now(),
                    //     // 'tanggal_onhold_end' => NULL,
                    //     'created_at' => Carbon::now(),
                    //     'created_by' => 'admin_super',
                    // ]);
                    $update_issues_status = DB::table('issues_status')
                        ->where('issues_status.tiket_issues', '=', $tiket_issues)
                        ->where('issues_status.status', '=', "6")
                        ->update([
                            'tanggal_onhold_end' => Carbon::now(),
                        ]);

                    $issue = DB::table('issues')
                        ->select(DB::raw('issues.*'))
                        ->where('issues.tiket_issues', '=', $tiket_issues)
                        ->get()
                        ->first();
                    $done = Carbon::now();
                    DB::table('issues')
                        ->where('issues.tiket_issues', '=', $tiket_issues)
                        ->update([
                            'sla' => hitungSLA($issue->tanggal_pembuatan_issues, $issue->tanggal_batas_issues, $done, 3, $tiket_issues)
                        ]);

                    // $tambah_issues_status = DB::table('issues_status')->insert([
                    //     'tiket_issues' => $tiket_issues,
                    //     'status' => 3,
                    //     'catatan' => 'this issue is approved from SIMASTI apps',
                    //     'tanggal_onhold_start' => Carbon::now(),
                    //     // 'tanggal_onhold_end' => NULL,
                    //     'created_at' => Carbon::now(),
                    //     'created_by' => 'admin_super',
                    // ]);

                    // $tambah_issues_status = DB::table('issues_status')->insert([
                    //     'tiket_issues' => $tiket_issues,
                    //     'status' => 4,
                    //     'catatan' => 'this issue is approved from SIMASTI apps',
                    //     'tanggal_onhold_start' => Carbon::now(),
                    //     // 'tanggal_onhold_end' => NULL,
                    //     'created_at' => Carbon::now(),
                    //     'created_by' => 'admin_super',
                    // ]);

                } else {

                }
                
                $tambah_issues_status = DB::table('issues_status')
                    ->insert([
                        'tiket_issues' => $tiket_issues,
                        'status' => 3,
                        'catatan' => 'this issue is approved from SIMASTI apps',
                        'created_at' => Carbon::now(),
                        'created_by' => 'admin_super'
                    ]);

                $tambah_issues_status = DB::table('issues_status')->insert([
                    'tiket_issues' => $tiket_issues,
                    'status' => 4,
                    'catatan' => 'this issue is approved from SIMASTI apps',
                    'tanggal_onhold_start' => Carbon::now(),
                    // 'tanggal_onhold_end' => NULL,
                    'created_at' => Carbon::now(),
                    'created_by' => 'admin_super',
                ]);

                $tb_issues = DB::table('v_issues')
                    ->select(DB::raw("
                    v_issues.tiket_issues as tiket_issues,
                    v_issues.username_sap_issues as username_sap_issues,
                    v_issues.username_sap_issues as telp_issues,
                    v_issues.description_issues as description_issues,
                    m_kategori.nama_kategori,
                    m_layanan.nama_layanan,
                    m_subject.nama_subject,
                    m_priority.nama_priority,
                    pegawai.nama as nama_pegawai"))
                    ->leftjoin('m_kategori', 'm_kategori.id', 'v_issues.kategori_id')
                    ->leftjoin('m_layanan', 'm_layanan.id', 'v_issues.layanan_id')
                    ->leftjoin('m_subject', 'm_subject.id', 'v_issues.subject_id')
                    ->leftjoin('m_priority', 'm_priority.id', 'v_issues.priority_id')
                    ->leftjoin('pegawai', 'pegawai.nik', 'v_issues.username_sap_issues');

                // $datax['total_data'] = $tb_users->first();


                $datax['v_issues'] = $tb_issues
                    ->where('v_issues.tiket_issues', '=', $tiket_issues)
                    ->get();

                // return $tiket_issues;
                app('App\Http\Controllers\notifikasiController')->createNotifikasi(3, $tiket_issues);
                
                //update SLA
                $issue = DB::table('issues')
                    ->select(DB::raw('issues.*'))
                    ->where('issues.tiket_issues', '=', $tiket_issues)
                    ->get()
                    ->first();
                $done = Carbon::now();
                DB::table('issues')
                    ->where('issues.tiket_issues', '=', $tiket_issues)
                    ->update([
                        'sla' => hitungSLA($issue->tanggal_pembuatan_issues, $issue->tanggal_batas_issues, $done, 3, $tiket_issues)
                    ]);

                // $issues_status_terakhir_setelah_progress = DB::table('issues_status')
                //     ->select(DB::raw('issues_status.*'))
                //     ->where('issues_status.tiket_issues', '=', $tiket_issues)
                //     ->orderBy('issues_status.id', 'DESC')
                //     ->take(1)
                //     ->get()
                //     ->first();

                // $get_issue_setelah_tambah_issues = DB::table('v_issues')
                //     ->select(DB::raw('v_issues.*'))
                //     ->where('v_issues.tiket_issues', '=', $tiket_issues)
                //     ->get()
                //     ->first();

                // DB::table('issues')
                // ->where('issues.tiket_issues', '=', $tiket_issues)
                // ->update([
                //     'tanggal_batas_issues' => onHoldTimer(
                //         $issues_status_terakhir_setelah_progress->tanggal_onhold_start,
                //         $issues_status_terakhir_setelah_progress->tanggal_onhold_end,
                //         $get_issue_setelah_tambah_issues->tanggal_batas_issues
                //     )
                // ]);

                $datax['status_issues'] = status_issues_id_ke_text2(get_status_terakhir_per_issues_id($tiket_issues));
                $datax['kode'] = 200;

                return generateJson($datax);
            }
        } catch (RequestException $e) {
            // return response()->json(['success' => $e, 'kode' => 401]);
            // dd($e->getMessage());
            return generateJson($e->getMessage());
            // return response()->json(['success' => $e, 'kode' => 201]);
        } catch (\Exception $e) {
            return generateJson($e->getMessage());
            // return response()->json(['success' => $e, 'kode' => 201]);
        }
    }


    public function getListDataAssetSimasti(Request $request)
    {
        $search = $request->search;

        $page = $request->page;

        $data_arr    = [
            "search" => $search,
            "page" => $page,
        ];

        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        $url = api_simasti() . "api/data_asset";
        $response = $client->get($url, ['query' => $data_arr]);
        $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

        $data_array = [];
        for ($i = 0; $i < count($response_server['data']); $i++) {
            $data_array[] = array(

                'id' => $response_server['data'][$i]['no'],
                'text' => $response_server['data'][$i]['no_aset'] . ' - ' . $response_server['data'][$i]['model'] . ' - ' . $response_server['data'][$i]['nama_kategori']

            );
        }

        $results = array(
            "results" => $data_array,
            "results_count" => $response_server['countpage'],
            // "pagination" => array(
            //     "more" => $morePages
            // ),
        );

        // dd($results);

        return response()->json($results);
    }

    public function getListDataAssetSimastiDenganNomor($no)
    {
        // $no = $request->no;

        $data_arr    = [
            "no" => $no,
        ];

        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        $url = api_simasti() . "api/sinkron_asset";
        $response = $client->get($url, ['query' => $data_arr]);
        $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

        // dd($results);

        return response()->json($response_server);
        // return $response_server;
    }

    public function getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk($tiket_issues)
    {
        // $no = $request->no;
        // dd($tiket_issues);

        $tb_issues = DB::table('issues')
            ->select(DB::raw("issues.*"))
            ->where('issues.tiket_issues', '=', $tiket_issues)
            ->get();

        // dd($tb_issues);

        // $tiket_simasti_gabungan = '';

        $jumlah_data_belum_selesai = 0;
        $jumlah_data_sudah_selesai = 0;
        $no_urut_tampil = 1;

        foreach ($tb_issues as $data) {

            $tiket_simasti_gabungan = '';

            $tiket_simasti_id_explode = explode("~", $data->tiket_simasti);
            // dd($tiket_simasti_id_explode);

            for ($j = 0; $j < count($tiket_simasti_id_explode); $j++) {
                // dd($tiket_simasti_id_explode[$j]);
                // $data_arr = [
                //     "no[]" => $tiket_simasti_id_explode[$j],
                // ];
                // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
                // $url = api_simasti() . "api/data_perbaikan";
                // $response = $client->get($url, ['query' => $data_arr]);
                // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

                // // dd(count($response_server['data']));
                // dd($response_server['data']);
                // if (count($response_server['data']) > 0) {
                //     $no_aset = $response_server['data'][0]['no_aset'];
                //     $model = $response_server['data'][0]['model'];
                //     $nama_kategori = $response_server['data'][0]['nama_kategori'];
                //     $status_perbaikan = $response_server['data'][0]['status_perbaikan'];
                //     // dd($status_perbaikan);
                //     // dd($response_server['data']['no_aset'] . ' - ' . $response_server['data']['model']. ' - ' . $response_server['data']['nama_kategori']);
                //     $tiket_simasti_gabungan .= ' ( ' . $no_aset . ' - ' . $model . ' - ' . $nama_kategori . ' ) - ' . $status_perbaikan . '; ';
                // } else {
                //     $tiket_simasti_gabungan .= '';
                // }

                // // dd($tiket_simasti_gabungan);
                // sleep(1);

                $getListDataDetailPerbaikan = $this->getListDataDetailPerbaikan($tiket_simasti_id_explode[$j]);
                // dd($getListDataDetailPerbaikan);

                // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
                // $url = api_simasti() . "api/detail_perbaikan";
                // $response = $client->get($url, ['query' => $data_arr]);
                // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

                // dd(count($response_server['data']));
                // dd($response_server['data']);
                // if (count($response_server['data']) > 0) {
                //     $no_aset = $response_server['data'][0]['no_aset'];
                //     $model = $response_server['data'][0]['model'];
                //     $nama_kategori = $response_server['data'][0]['nama_kategori'];
                //     $status_perbaikan = $response_server['data'][0]['status_perbaikan'];
                //     // dd($status_perbaikan);
                //     // dd($response_server['data']['no_aset'] . ' - ' . $response_server['data']['model']. ' - ' . $response_server['data']['nama_kategori']);

                // } else {
                //     $tiket_simasti_gabungan .= '';
                // }

                foreach ($getListDataDetailPerbaikan as $data => $value) {
                    // dd($value);
                    if ($value['status_perbaikan'] == 'belum selesai') {
                        $jumlah_data_belum_selesai = $jumlah_data_belum_selesai + 1;
                    } else if ($value['status_perbaikan'] == 'selesai') {
                        $jumlah_data_sudah_selesai = $jumlah_data_sudah_selesai + 1;
                    } else {
                    }
                    $tiket_simasti_gabungan .= '( ' . $no_urut_tampil++ . ' ) ' . ' ( ' . $value['no_aset'] . ' - ' . $value['model'] . ' - ' . $value['nama_kategori'] . ' ) - ' . $value['status_perbaikan'] . '; ';
                }

                // dd($tiket_simasti_gabungan);
                // sleep(1);
            }

            // return response()->json($response_server);
            // dd($tiket_simasti_gabungan);
        }

        // dd($jumlah_data_belum_selesai . ' - ' . $jumlah_data_sudah_selesai);

        // return response()->json($response_server);
        // dd(response()->json(['data' => $tiket_simasti_gabungan, 'data_count' => $tiket_simasti_gabungan, 'kode' => 201]));
        return response()->json([
            'data' => $tiket_simasti_gabungan,
            'jumlah_data_belum_selesai' => $jumlah_data_belum_selesai,
            'jumlah_data_sudah_selesai' => $jumlah_data_sudah_selesai,
            'kode' => 201
        ]);

        // dd($tiket_simasti_gabungan);


        // return $response_server;
    }


    public function getListDataAssetSimastiDenganTiketSismatiByTiketIssuesDuplikatHelpdesk($tiket_issues_duplikat)
    {
        // $no = $request->no;
        // dd($tiket_issues);

        $tb_issues = DB::table('issues')
            ->select(DB::raw("issues.*"))
            ->where('issues.tiket_issues_duplikat', '=', $tiket_issues_duplikat)
            ->get();

        // dd($tb_issues);

        // $tiket_simasti_gabungan = '';

        $jumlah_data_belum_selesai = 0;
        $jumlah_data_sudah_selesai = 0;
        $no_urut_tampil = 1;

        foreach ($tb_issues as $data) {

            $tiket_simasti_gabungan = '';

            $tiket_simasti_id_explode = explode("~", $data->tiket_simasti);
            // dd($tiket_simasti_id_explode);

            for ($j = 0; $j < count($tiket_simasti_id_explode); $j++) {
                // dd($tiket_simasti_id_explode[$j]);
                // $data_arr = [
                //     "no[]" => $tiket_simasti_id_explode[$j],
                // ];
                // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
                // $url = api_simasti() . "api/data_perbaikan";
                // $response = $client->get($url, ['query' => $data_arr]);
                // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

                // // dd(count($response_server['data']));
                // dd($response_server['data']);
                // if (count($response_server['data']) > 0) {
                //     $no_aset = $response_server['data'][0]['no_aset'];
                //     $model = $response_server['data'][0]['model'];
                //     $nama_kategori = $response_server['data'][0]['nama_kategori'];
                //     $status_perbaikan = $response_server['data'][0]['status_perbaikan'];
                //     // dd($status_perbaikan);
                //     // dd($response_server['data']['no_aset'] . ' - ' . $response_server['data']['model']. ' - ' . $response_server['data']['nama_kategori']);
                //     $tiket_simasti_gabungan .= ' ( ' . $no_aset . ' - ' . $model . ' - ' . $nama_kategori . ' ) - ' . $status_perbaikan . '; ';
                // } else {
                //     $tiket_simasti_gabungan .= '';
                // }

                // // dd($tiket_simasti_gabungan);
                // sleep(1);

                $getListDataDetailPerbaikan = $this->getListDataDetailPerbaikan($tiket_simasti_id_explode[$j]);
                // dd($getListDataDetailPerbaikan);

                // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
                // $url = api_simasti() . "api/detail_perbaikan";
                // $response = $client->get($url, ['query' => $data_arr]);
                // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

                // dd(count($response_server['data']));
                // dd($response_server['data']);
                // if (count($response_server['data']) > 0) {
                //     $no_aset = $response_server['data'][0]['no_aset'];
                //     $model = $response_server['data'][0]['model'];
                //     $nama_kategori = $response_server['data'][0]['nama_kategori'];
                //     $status_perbaikan = $response_server['data'][0]['status_perbaikan'];
                //     // dd($status_perbaikan);
                //     // dd($response_server['data']['no_aset'] . ' - ' . $response_server['data']['model']. ' - ' . $response_server['data']['nama_kategori']);

                // } else {
                //     $tiket_simasti_gabungan .= '';
                // }

                foreach ($getListDataDetailPerbaikan as $data => $value) {
                    // dd($value);
                    if ($value['status_perbaikan'] == 'belum selesai') {
                        $jumlah_data_belum_selesai = $jumlah_data_belum_selesai + 1;
                    } else if ($value['status_perbaikan'] == 'selesai') {
                        $jumlah_data_sudah_selesai = $jumlah_data_sudah_selesai + 1;
                    } else {
                    }
                    $tiket_simasti_gabungan .= '( ' . $no_urut_tampil++ . ' ) ' . ' ( ' . $value['no_aset'] . ' - ' . $value['model'] . ' - ' . $value['nama_kategori'] . ' ) - ' . $value['status_perbaikan'] . '; ';
                }

                // dd($tiket_simasti_gabungan);
                // sleep(1);
            }

            // return response()->json($response_server);
            // dd($tiket_simasti_gabungan);
        }

        // dd($jumlah_data_belum_selesai . ' - ' . $jumlah_data_sudah_selesai);

        // return response()->json($response_server);
        // dd(response()->json(['data' => $tiket_simasti_gabungan, 'data_count' => $tiket_simasti_gabungan, 'kode' => 201]));
        return response()->json([
            'data' => $tiket_simasti_gabungan,
            'jumlah_data_belum_selesai' => $jumlah_data_belum_selesai,
            'jumlah_data_sudah_selesai' => $jumlah_data_sudah_selesai,
            'kode' => 201
        ]);

        // dd($tiket_simasti_gabungan);


        // return $response_server;
    }

    public function getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk2($tiket_issues)
    {
        // $no = $request->no;
        // dd($tiket_issues);

        $tb_issues = DB::table('issues')
            ->select(DB::raw("issues.*"))
            ->where('issues.tiket_issues', '=', $tiket_issues)
            ->get();

        // dd($tb_issues);

        // $tiket_simasti_gabungan = '';

        foreach ($tb_issues as $data) {

            $tiket_simasti_gabungan = '';

            $tiket_simasti_id_explode = explode("~", $data->tiket_simasti);
            // dd($tiket_simasti_id_explode);

            for ($j = 0; $j < count($tiket_simasti_id_explode); $j++) {
                // dd($tiket_simasti_id_explode[$j]);
                $data_arr = [
                    "no[]" => $tiket_simasti_id_explode[$j],
                ];
                $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
                $url = api_simasti() . "api/data_perbaikan";
                $response = $client->get($url, ['query' => $data_arr]);
                $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

                // dd(count($response_server['data']));
                if (count($response_server['data']) > 0) {
                    $no_aset = $response_server['data'][0]['no_aset'];
                    $model = $response_server['data'][0]['model'];
                    $nama_kategori = $response_server['data'][0]['nama_kategori'];
                    $status_perbaikan = $response_server['data'][0]['status_perbaikan'];
                    // dd($status_perbaikan);
                    // dd($response_server['data']['no_aset'] . ' - ' . $response_server['data']['model']. ' - ' . $response_server['data']['nama_kategori']);
                    $tiket_simasti_gabungan .= ' ( ' . $no_aset . ' - ' . $model . ' - ' . $nama_kategori . ' ) - ' . $status_perbaikan . '; ';
                } else {
                    $tiket_simasti_gabungan .= '';
                }

                // dd($tiket_simasti_gabungan);
                sleep(1);
            }

            // return response()->json($response_server);
            // dd($tiket_simasti_gabungan);
        }

        // return response()->json($response_server);
        return response()->json(['data' => $tiket_simasti_gabungan, 'kode' => 201]);

        // dd($tiket_simasti_gabungan);


        // return $response_server;
    }

    public function parsingDataIssuesSimasti()
    {
        $data_arr    = [
            "coba" => 'coba',
        ];

        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        $url = api_simasti() . "api/data_issue";
        $response = $client->get($url, ['query' => $data_arr]);
        $response_server = \GuzzleHttp\json_decode($response->getBody(), true);

        dd($response_server);
    }

    public function getListDataDetailPerbaikan($tiket_simasti)
    {
        if (empty($tiket_simasti)) {
            return array();
        } else {
            try {
                //code...
                $data_arr = [
                    "id_simasti[]" => $tiket_simasti
                ];
                $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
                $url = api_simasti() . "api/detail_perbaikan";
                $response = $client->get($url, ['query' => $data_arr]);
                // dd($data_arr);
                $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
                return $response_server['data'];

            } catch (\Throwable $th) {
                //throw $th;
                return array();
            }
        }
    }

    public function getListDataSyncNoAsset(Request $request)
    {
        // dd($request->all());
        $tiket_issues = $request->tiket_issues;
        $no_sismasti = $request->no_sismasti;

        // dd($no_sismasti);

        $tb_issues = DB::table('issues')
            ->select(DB::raw("issues.*"))
            ->where('issues.tiket_issues', '=', $tiket_issues)
            ->get()
            ->first();

        $tb_issues_no_asset = $tb_issues->tiket_simasti;
        $tb_issues_no_asset_array = explode("~", $tb_issues_no_asset);

        $tiket_simasti_final = "";

        for ($i = 0; $i < count($tb_issues_no_asset_array); $i++) {

            if ($tb_issues_no_asset_array[$i] == $no_sismasti) {
                // $tiket_simasti_final += "";
            } else {
                $tiket_simasti_final .= $tb_issues_no_asset_array[$i] . '~';
            }
        }

        // dd(substr($tiket_simasti_final, 0, strlen($tiket_simasti_final) - 1));

        $tiket_simasti_final_final = substr($tiket_simasti_final, 0, strlen($tiket_simasti_final) - 1);

        $update_m_kategori = DB::table('issues')
            ->where('issues.tiket_issues', '=', $tiket_issues)
            ->update([
                'tiket_simasti' => $tiket_simasti_final_final,
            ]);

        return response()->json(['data' => $tiket_simasti_final_final, 'kode' => 201]);
    }
}
