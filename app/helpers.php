<?php

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
// use Session;

function loadfile()
{
    $file = new Client(['verify' => public_path('ssl/cacert.pem')]);
    return $file;
}

function url_app_helpdesk($param = '')
{
    $url = env('API_HELPDESK', 'http://localhost/helpdesk_app') . "/$param";
    return $url;
}

function token_static_helpdesk()
{
    $token = "@)(@__!@!@P3T|20K!M!Agresik";

    return $token;
}

function encrypt_($id)
{
    $data = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($id))))));

    return $data;
}

function decrypt_($id)
{
    $data = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($id))))));

    return $data;
}

function validateSessionToken($api_key = null)
{
    if ($api_key != null || $api_key != '') {
        $data = DB::table('pegawai')->where('remember_token', $api_key)->first();
        $data2 = DB::table('users')->where('remember_token', $api_key)->first();

        if (isset($data) || isset($data2)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function headerToken()
{
    $data_session = Session::get('user_app');
    $query = DB::table('users')
        ->where('users.id', $data_session['users_id'])
        ->get()
        ->first();
    // dd($query->remember_token);
    $token = $query->remember_token;
    $myHeader = array(
        "api-token" => $token,
    );
    // return $data_session;
    return $myHeader;
}

function tgl_indo_full($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}

function tgl_indo_bulan_tahun($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}

function next_value($current)
{
    $letter = $current[0];
    $number = (int) substr($current, 1);

    if ($number == 999) {
        $letter++;
        $number = 1;
    } else {
        $number++;
    }

    return $letter . str_pad($number, 3, '0', STR_PAD_LEFT);
}

function next_value_nuber_2_digit($current)
{
    $letter = $current[0];
    $number = (int) substr($current, 1);

    if ($number == 99) {
        $letter++;
        $number = 1;
    } else {
        $number++;
    }

    return $letter . str_pad($number, 2, '0', STR_PAD_LEFT);
}

function next_value_tiket_2($current)
{
    $letter = $current;
    $number = substr($current, 16);

    // $tb_issues_cek_tiket = DB::table('issues')
    //     ->select(DB::raw("issues.*"))
    //     ->where(DB::raw('substr(code, 1, 15)'), '=', $number)
    //     ->get();

    // dd($number);
    // if (count($tb_issues_cek_tiket) > 0) {
    if ($number == 99999) {
        $letter++;
        $number = 1;
    } else {
        $number++;
    }

    // dd($number);
    return substr($letter, 0, 16) . str_pad($number, 5, '0', STR_PAD_LEFT);
    // } else {
    //     return $letter;
    // }
}

function next_value_tiket()
{

    $tahun_sekarang = date("Y");

    $tahun_sekarang_sub = substr($tahun_sekarang, 2, 2);
    // $tiket_issues_final = "HLP-" . $tahun_sekarang_sub;
    // dd($tiket_issues_final);

    $tb_issues_cek_tiket = DB::table('issues')
        ->select(DB::raw("issues.*"))
        ->where(DB::raw('substr(issues.tanggal_pembuatan_issues, 1, 4)'), '=', $tahun_sekarang)
        ->whereRaw('LENGTH(issues.tiket_issues) = 12')
        ->get();

    $current = "";

    if (count($tb_issues_cek_tiket) == 0) {
        // $current = "LAL-" . $tahun_sekarang_sub . "-000001";
        $current = "HLP-" . $tahun_sekarang_sub . "-00001";
    } else {

        $tb_issues_get_id_terakhir = DB::table('issues')
            ->select(DB::raw("issues.*"))
            ->orderby('issues.id', 'DESC')
            ->where(DB::raw('substr(issues.tanggal_pembuatan_issues, 1, 4)'), '=', $tahun_sekarang)
            ->whereRaw('LENGTH(issues.tiket_issues) = 12')
            ->get()
            ->first();

        $letter = $tb_issues_get_id_terakhir->tiket_issues;
        $number = substr($letter, 7, 5);
        // dd($number);

        if ($number == 99999) {
            $letter++;
            $number = 1;
        } else {
            $number++;
        }

        $current =  substr($letter, 0, 7) . str_pad($number, 5, '0', STR_PAD_LEFT);
        // dd($current);
        // dd(str_pad($number, 6, '0', STR_PAD_LEFT));
    }

    return $current;
}

function status_issues_id_ke_text($status_id)
{
    if ($status_id == '1') {
        $status = '<h5><span class="badge rounded-pill bg-warning">Open</span></h5>';
    } else if ($status_id == '2') {
        $status = '<h5><span class="badge rounded-pill bg-info">Progress</span></h5>';
    } else if ($status_id == '3') {
        $status = '<h5><span class="badge rounded-pill bg-success">Done</span></h5>';
    } else if ($status_id == '4') {
        $status = '<h5><span class="badge rounded-pill bg-primary">Closed</span></h5>';
    } else if ($status_id == '5') {
        $status = '<h5><span class="badge rounded-pill bg-secondary">Close</span></h5>';
    } else if ($status_id == '6') {
        $status = '<h5><span class="badge rounded-pill bg-danger">On Hold</span></h5>';
    } else {
        $status = "";
    }

    return $status;
}

function status_issues_id_ke_text2($status_id)
{
    if ($status_id == '1') {
        $status = 'Open';
    } else if ($status_id == '2') {
        $status = 'Progress';
    } else if ($status_id == '3') {
        $status = 'Done';
    } else if ($status_id == '4') {
        $status = 'Closed';
    } else if ($status_id == '5') {
        $status = 'Close';
    } else if ($status_id == '6') {
        $status = 'On Hold';
    } else {
        $status = "";
    }

    return $status;
}

function get_status_terakhir_per_issues_id($tiket_issues)
{
    $tb_issues_status = DB::table('v_issues')
        ->select(DB::raw("v_issues.*"))
        ->where(DB::raw('v_issues.tiket_issues'), '=', $tiket_issues)
        ->get()
        ->first();

    if ($tb_issues_status == null) {
        $status = 0;
    } else {
        $status = $tb_issues_status->status;
    }

    return $status;
}

function get_status_created_by_terakhir_per_tiket_issues($tiket_issues)
{
    $tb_issues_status = DB::table('issues_status')
        ->select(DB::raw("v_users_all.nama as v_users_all_nama"))
        ->where(DB::raw('issues_status.tiket_issues'), '=', $tiket_issues)
        ->leftJoin('v_users_all', 'v_users_all.username', '=', 'issues_status.created_by')
        ->orderBy('issues_status.created_at', 'DESC')
        ->limit(1)
        ->get()
        ->first();

    if ($tb_issues_status == null) {
        $status_v_users_all_nama = 0;
    } else {
        $status_v_users_all_nama = $tb_issues_status->v_users_all_nama;
    }

    return $status_v_users_all_nama;
}

function generateJson($data = null, $x = null, $slash = null)
{
    $output = array(
        'jsonrpc'   => 2.0,
        'id_req'        => uniqid(rand(), true) . '.' . date('YmdHis')
    );

    $error = array(
        '32700' => ["code" => 32700, "message" => 'Parse error'],
        '32600' => ["code" => 32600, "message" => 'Invalid Request'],
        '32601' => ["code" => 32601, "message" => 'Object not found'],
        '32602' => ["code" => 32602, "message" => 'Invalid params'],
        '32603' => ["code" => 32603, "message" => 'Internal error'],
        '32604' => ["code" => 32604, "message" => 'Invalid Request'],
        '0' => ["code" => 0, 'message' => "Invalid username or password"],
    );
    // print_r($data);exit;
    if (!empty($data)) {
        if (is_array($data)) {
            // if(array_key_exists("base_url", $data)):
            // 	$output['base_url'] = $data["base_url"];
            // 	unset($data["base_url"]);
            // endif;
            // if(array_key_exists("total", $data)):
            // 	$output['total'] = $data["total"];
            // 	$output['page'] = $data["page"];
            // 	unset($data["total"]);
            // 	unset($data["page"]);
            // 	$output['view'] = count($data);
            // endif;

            $output['result'] = $data;
        } else {
            if ($x != null) {
                $output['error'] = array(
                    'code'        => $x,
                    'message'    => $data,
                );
            } else {
                $output['result'] = array(
                    'code'        => 200,
                    'message'    => $data,
                );
            }
        }
    } else {
        if ($x != null) {
            $output['error'] = array(
                'code'        => $error[$x]['code'],
                'message'    => $error[$x]['message'],
            );
        }
    }

    return response()->json($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    /* if($slash != null){
        return json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }else{
        // return json_encode($output, JSON_PRETTY_PRINT);
        return json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } */
}

function getIssuesDataByLayanan($awal, $akhir, $layanan, $status1, $status2)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, issues.major_incident as major_incident, issues.security_incident as security_incident,
                    m_kategori.id as k_id, m_kategori.nama_kategori as kategori, m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, 
                    v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
                    pegawai.unitname as unit, pegawai.nama as requester, a.created_at as lastupdate,
                    issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, m_priority.nama_priority as prioritas, 
                    m_priority.sla_priority as sla, a.status as status, issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.status', '=', $status1)
            ->where('issues.tanggal_pembuatan_issues', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.status', '=', $status2)
            ->where('issues.tanggal_pembuatan_issues', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
                    m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
                    pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, issues.tiket_simasti as tiket_simasti,
                    m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate, 
                    issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.status', '=', $status1)
            ->where('issues.tanggal_pembuatan_issues', '>=', $awal)
            ->where('issues.tanggal_pembuatan_issues', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.status', '=', $status2)
            ->where('issues.tanggal_pembuatan_issues', '>=', $awal)
            ->where('issues.tanggal_pembuatan_issues', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}
function getIssuesData($awal, $akhir, $status1, $status2)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, issues.major_incident as major_incident, issues.security_incident as security_incident, 
                    a.created_at as lastupdate, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, 
                    v_users_all.nama as creator, pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, pegawai.unitname as unit, pegawai.nama as requester, 
                    issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, m_priority.nama_priority as prioritas, 
                    m_priority.sla_priority as sla, a.status as status, issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            // ->where('a.status', '=', $status1)
            // ->where('issues.tanggal_pembuatan_issues', 'like', $awal . '%')
            ->Where('a.created_at', 'like', $awal . '%')
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            // ->orWhere('a.status', '=', $status2)
            ->whereIn('a.status', [$status1, $status2])
            // ->where('issues.tanggal_pembuatan_issues', 'like', $awal . '%')
            // ->orWhere('a.created_at', 'like', $awal . '%')
            // ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            // ->where('a.status', '=', $status1)
            // ->where('issues.tanggal_pembuatan_issues', '>=', $awal)
            // ->where('issues.tanggal_pembuatan_issues', '<=', $akhir . '23:59:59')
            ->Where('a.created_at', '>=', $awal)
            ->Where('a.created_at', '<=', $akhir . '23:59:59')
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->whereIn('a.status', [$status1, $status2])
            // ->orWhere('a.status', '=', $status2)
            // ->where('issues.tanggal_pembuatan_issues', '>=', $awal)
            // ->where('issues.tanggal_pembuatan_issues', '<=', $akhir . '23:59:59')
            // ->Where('a.created_at', '>=', $awal)
            // ->Where('a.created_at', '<=', $akhir . '23:59:59')
            // ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}
function getAllIssuesData($awal, $akhir)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', 'like', $awal . '%')
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', 'like', $awal . '%')
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}
function getAllIssuesDataByLayanan($awal, $akhir, $layanan)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
                    m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
                    pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
                    m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.created_at as lastupdate,
                    a.status as status, issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}

//Rekap data tiap unit
function getIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan, $status1, $status2)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, issues.major_incident as major_incident, issues.security_incident as security_incident,
                    m_kategori.id as k_id, m_kategori.nama_kategori as kategori, m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject,  
                    v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
                    pegawai.unitname as unit, pegawai.nama as requester, a.created_at as lastupdate,
                    issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, m_priority.nama_priority as prioritas, 
                    m_priority.sla_priority as sla, a.status as status, issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.status', '=', $status1)
            ->where('a.created_at', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.status', '=', $status2)
            ->where('a.created_at', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
                    m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
                    pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
                    m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate, 
                    issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.status', '=', $status1)
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.status', '=', $status2)
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}
function getIssuesDataEachUnit($awal, $akhir, $unitkerja, $status1, $status2)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, a.created_at as lastupdate, issues.major_incident as major_incident, issues.security_incident as security_incident,
                    m_kategori.id as k_id, m_kategori.nama_kategori as kategori, m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator, 
                    pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, pegawai.unitname as unit, pegawai.nama as requester, 
                    issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, m_priority.nama_priority as prioritas, 
                    m_priority.sla_priority as sla, a.status as status, issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.status', '=', $status1)
            ->where('a.created_at', 'like', $awal . '%')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.status', '=', $status2)
            ->where('a.created_at', 'like', $awal . '%')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.status', '=', $status1)
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.status', '=', $status2)
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}
function getAllIssuesDataEachUnit($awal, $akhir, $unitkerja)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', 'like', $awal . '%')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', 'like', $awal . '%')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}
function getAllIssuesDataEachUnitByLayanan($awal, $akhir, $unitkerja, $layanan)
{
    if ($awal == $akhir) {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
                    m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
                    pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas, 
                    m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.created_at as lastupdate,
                    a.status as status, issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', 'like', $awal . '%')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    } else {
        $data = DB::table('issues')
            ->join('m_subject', 'issues.subject_id', '=', 'm_subject.id')
            ->join('m_layanan', 'issues.layanan_id', '=', 'm_layanan.id')
            ->join('issues_status as a', 'issues.tiket_issues', '=', 'a.tiket_issues')
            ->join('v_users_all', 'issues.created_by', '=', 'v_users_all.username')
            ->join('pegawai', 'issues.username_sap_issues', '=', 'pegawai.nik')
            ->join('m_priority', 'issues.priority_id', '=', 'm_priority.id')
            ->join('m_kategori', 'issues.kategori_id', '=', 'm_kategori.id')
            ->select(DB::raw('issues.tiket_issues as tiket, m_layanan.nama_layanan as layanan, issues.sla as sladone, issues.tiket_simasti as tiket_simasti, m_kategori.id as k_id, m_kategori.nama_kategori as kategori, issues.major_incident as major_incident, issues.security_incident as security_incident,
        m_subject.nama_subject as subject, m_subject.kategori_subject as kategori_subject, v_users_all.nama as creator,  pegawai.nama as peminta, pegawai.nik as nik, issues.priority_id as priority_id, 
        pegawai.unitname as unit, pegawai.nama as requester, issues.tanggal_pembuatan_issues as tgllapor, issues.tanggal_batas_issues as tglbatas,
        m_priority.nama_priority as prioritas, m_priority.sla_priority as sla, a.status as status, a.created_at as lastupdate,
        issues.description_issues as deskripsi,issues.tiket_cares_pi'))
            ->where('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orWhere('a.created_at', '>=', $awal)
            ->where('a.created_at', '<=', $akhir . '23:59:59')
            ->where('issues.layanan_id', '=', $layanan)
            ->where('issues.unitid', '=', $unitkerja)
            ->whereRaw('a.id = (select max(b.id) from issues_status as b where b.tiket_issues = a.tiket_issues)')
            ->orderBy('tanggal_pembuatan_issues', 'asc');
    }
    return $data;
}

// function realisasiSLA($status, $first, $batas, $last)
// {
//     $firstday = substr($first, 0, 10);
//     if ($status == 1 || $status == 2) {
//         $lastday = Date('Y-m-d');
//     } elseif ($status == 3 || $status == 4) {
//         $lastday = substr($last, 0, 10);
//     }

//     $liburnasional = DB::table('m_libur_nasional')
//         ->select(DB::raw('tgl_libur_nasional as nasional'))
//         ->where('tgl_libur_nasional', '>=', $first)
//         ->where('tgl_libur_nasional', '<=', $last)
//         ->get();
//     $holiday = 0;

//     foreach ($liburnasional as $day) {
//         $name = date('D', strtotime($day));
//         if ($name != "Sun" || $name != "Sat") {
//             $holiday++;
//         }
//     }

//     $weekends = 0;
//     for ($i = $firstday; $i <= $lastday; $i = Date('Y-m-d', strtotime("+1 day", strtotime($i)))) {
//         $day = date('D', strtotime($i));
//         if ($day == "Sun" || $day == "Sat") {
//             $weekends++;
//         }
//     }
//     $libur = $weekends + $holiday;
//     $libur = $libur * 24 * 60 * 60;
//     if ($status == 1 || $status == 2) {
//         $diff = strtotime(date("Y-m-d H:i:s")) - strtotime($first) - $libur;
//     } elseif ($status == 3 || $status == 4) {
//         $diff = strtotime($last) - strtotime($first) - $libur;
//     }
//     // $jamkerja = floor($diff / 24 / 60 / 60);
//     if(strtotime($batas)<strtotime($last)){//telat
//         if($hari==0){//hari ini
//             if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//                 if(strtotime($lastday.' 17:00:00')<strtotime($last)){//batas jam lembur
//                 }else{//tidak batas
//                 }
//             }else{//non lembur
//             }
//         }else{//Non todaY
//             if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//                 if(strtotime($lastday.' 17:00:00')<strtotime($last)){//batas jam lembur
//                 }else{//tidak batas
//                 }
//             }else{//non lembur
//             }
//         }
//     }else{//tidak telat
//         if($hari==0){//hari ini
//             if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//             }else{//non lembur
//             }
//         }else{//Non todaY
//             if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//             }else{//non lembur
//             }
//         }
//     }

//     $hari = floor($diff / 24 / 60 / 60);
//     $diff = $diff - ($hari * 24 * 60 * 60);
//     $jam = floor($diff / 60 / 60);
//     $diff = $diff - ($jam * 60 * 60);
//     $menit = floor($diff / 60);
//     $diff = $diff - strtotime($menit);

//     // if(strtotime($batas)<strtotime($last)){//telat
//     //     if($hari==0){//hari ini
//     //         if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//     //             if(strtotime($lastday.' 17:00:00')<strtotime($last)){//batas jam lembur
//     //                 $diff = strtotime($lastday.' 17:00:00') - strtotime($first);
//     //                 $jam = floor($diff/60/60);
//     //                 $diff = $diff - ($jam * 60 * 60);
//     //                 $menit = floor($diff / 60);
//     //             }else{//tidak batas
//     //                 $jam = strtotime($last) - strtotime($first);
//     //                 $jam = floor($jam/60/60);
//     //             }
//     //         }else{//non lembur
//     //             $jam = strtotime($last) - strtotime($first);
//     //             $jam = floor($jam/60/60);
//     //         }
//     //     }else{//Non todaY
//     //         if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//     //             if(strtotime($lastday.' 17:00:00')<strtotime($last)){//batas jam lembur
//     //                 $diff = strtotime($lastday.' 16:00:00')-strtotime($lastday.' '.substr($first, 11, 8));
//     //                 $jam = floor($diff/60/60);
//     //                 $diff = $diff - ($jam * 60 * 60);
//     //                 $menit = floor($diff / 60);
//     //             }else{//tidak batas
//     //                 $jam = 17-(floor((strtotime($first)-strtotime($firstday.' 00:00:00'))/60/60));
//     //             }
//     //         }else{//non lembur
//     //             $jam = floor((strtotime($last)-strtotime($lastday.' '.substr($first, 11, 8)))/60/60);
//     //             // $jam = strtotime($last)-strtotime($lastday.' '.substr($first, 11, 8));
//     //         }
//     //     }
//     // }else{//tidak telat
//     //     if($hari==0){//hari ini
//     //         if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//     //             $diff = strtotime($lastday.' 16:00:00') - strtotime($first);
//     //             $jam = floor($diff/60/60);
//     //             $diff = $diff - ($jam * 60 * 60);
//     //             $menit = floor($diff / 60);
//     //         }else{//non lembur
//     //             $jam = strtotime($last) - strtotime($first);
//     //             $jam = floor($jam/60/60);
//     //         }
//     //     }else{//Non todaY
//     //         if(strtotime($lastday.' 16:00:00')<strtotime($last)){//lembur
//     //             $diff = strtotime($lastday.' 16:00:00')-strtotime($lastday.' '.substr($first, 11, 8));
//     //             $jam = floor($diff/60/60);
//     //             $diff = $diff - ($jam * 60 * 60);
//     //             $menit = floor($diff / 60);
//     //         }else{//non lembur
//     //             $jam = floor((strtotime($last)-strtotime($lastday.' '.substr($first, 11, 8)))/60/60);
//     //         }
//     //     }
//     // }
    
//     // dihitung perhari 9 jam
//     // kalau lebih dari batas dan ga lembur maka biasa
//     // kalau lebih dari batas dan lembur maka max 1 jam
//     // kalau belum batas tapi lembur max jam 4 sore
    
//     if ($menit == 0 && $jam == 0 && $hari == 0) {
//         $menit = 1;
//     }
//     $realisasi = "";
//     $realisasi .= number_format($hari, 0, ",", ".") . " hari <br>";
//     $realisasi .= number_format($jam, 0, ",", ".") . " jam <br>";
//     $realisasi .= number_format($menit, 0, ",", ".") . " menit";
//     return $realisasi;
// }

function preprocessing_get_string($string)
{
    $string = str_replace('<div class="ql-editor" data-gramm="false" contenteditable="true"><p>', "", $string);
    $string = str_replace('</div><div class="ql-clipboard"', "batasteksbro", $string);
    $string = str_replace('<img', "batasteksbro", $string);
    $string = str_replace('"></p>', "batasteksbro", $string);
    $string = str_replace('</p><p>', "batasteksbro", $string);
    $string = str_replace('</p>', "", $string);
    $string = str_replace('<p>', "", $string);
    $string = str_replace('">', "batasteksbro", $string);

    $stringex = explode("batasteksbro", $string);
    $stringarr = [];
    foreach ($stringex as $text) {
        if (!preg_match('/base64/i', $text) && !preg_match('/ql-/i', $text) && !preg_match('/contenteditable/i', $text) && !preg_match('/a>/i', $text)) {
            $stringarr[] = $text;
        }
    }
    $finalstring = "";
    foreach ($stringarr as $word) {
        $finalstring .= $word . "<br>";
    }
    // dd($finalstring);
    return $finalstring;
}

function api_simasti()
{
    // $url = "http://10.14.20.117:8000/";
    // $url = "http://192.168.43.30:8000/";
    // $url = "http://10.14.20.243:8000/";
    $url = "http://simastipg.petrokimia-gresik.com/";
    return $url;
}

function mappingSLAexcel($arr)
{
    $result = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i]->status == 3 || $arr[$i]->status == 4) {
            $lastupdate = ambilTanggalDone($arr[$i]->tiket);
            if ($lastupdate > $arr[$i]->tglbatas) {
                $result["I" . ($i + 2)] = [
                    'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FFFF0000']],
                ];
            } else {
                $result["I" . ($i + 2)] = [
                    'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FF00FF00']],
                ];
            }
        }
    }

    return $result;
}
function mappingPriority($arr)
{
    $result = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i]->priority_id == 'P001') {
            $result["F" . ($i + 2)] = [
                'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FFFC3700']],
            ];
        }
        if ($arr[$i]->priority_id == 'P002') {
            $result["F" . ($i + 2)] = [
                'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FFFC9300']],
            ];
        }
        if ($arr[$i]->priority_id == 'P003') {
            $result["F" . ($i + 2)] = [
                'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FFFCEC00']],
            ];
        }
        if ($arr[$i]->priority_id == 'P004') {
            $result["F" . ($i + 2)] = [
                'alignment' => ['readOrder' => true, 'wrapText' => true, 'vertical' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FF61FC00']],
            ];
        }
    }

    return $result;
}
function mappingPriorityPDF($priority_id)
{
    if ($priority_id == 'P001') {
        return 'style="background-color: #FC3700"';
    }
    if ($priority_id == 'P002') {
        return 'style="background-color: #FC9300"';
    }
    if ($priority_id == 'P003') {
        return 'style="background-color: #FCEC00"';
    }
    if ($priority_id == 'P004') {
        return 'style="background-color: #61FC00"';
    }
}

function mappingSLAPDF($batas, $latest)
{
    if ($latest > $batas) {
        $result = 'style="background-color: #FF0000"';
    } else {
        $result = 'style="background-color: #00FF00"';
    }
    return $result;
}

function ambilTanggalDone($tiket)
{
    $query = DB::table('issues_status')
        ->select(DB::raw('created_at'))
        ->where('tiket_issues', '=', $tiket)
        ->where('status', '=', 3)
        ->orderBy('id', 'desc')
        ->limit(1)
        ->get();

    if (count($query) > 0) {
        return $query[0]->created_at;
    } else {
        return '';
    }
}
    // function tiket_issues_final()
// {
//     $tahun_sekarang = date("Y");
//     $tiket_issues_final = 
//     dd($tahun_sekarang);
//     $tb_issues_cek_tiket = DB::table('issues')
//         ->select(DB::raw("issues.*"))
//         ->where(DB::raw('substr(issues.tiket_issues, 1, 17)'), '=', $tiket_tanpa_nomor_urut)
//         ->get();
// }

function getMiniNotif($user){
    $query['notif'] = DB::table('mapping_notifikasi')
        ->join('notifikasi', 'notifikasi.id', '=', 'mapping_notifikasi.id_notif')
        ->select(DB::raw('notifikasi.*, mapping_notifikasi.id as aidi'))
        ->where('mapping_notifikasi.id_penerima', '=', $user)
        ->where('mapping_notifikasi.status', '=', 0)
        ->orderBy('mapping_notifikasi.id', 'desc')
        ->limit(5)
        ->get();
    $query['count'] = DB::table('mapping_notifikasi')
        ->join('notifikasi', 'notifikasi.id', '=', 'mapping_notifikasi.id_notif')
        ->select(DB::raw('notifikasi.*'))
        ->where('mapping_notifikasi.id_penerima', '=', $user)
        ->where('mapping_notifikasi.status', '=', 0)
        ->orderBy('mapping_notifikasi.id', 'desc')
        ->count();
    return $query;
}

function hitungSLARumus($buat, $batas, $done, $status){
    $firstday = substr($buat, 0, 10);
    if(strtotime($buat)>strtotime($firstday.' 16:00:00')){
        $buat = $firstday.' 16:00:00';
    }
    $str_done = strtotime($done);
    $str_batas = strtotime($batas);
    $str_buat = strtotime($buat);
    if ($status == 1 || $status == 2 || $status == 6) {
        $lastday = Date('Y-m-d');
    } elseif ($status == 3 || $status == 4) {
        $lastday = substr($done, 0, 10);
    }
    
    $holiday = 0;
    $liburstart = 0;
    $liburnasional = DB::table('m_libur_nasional')
        ->select(DB::raw('DISTINCT(tgl_libur_nasional) as nasional'))
        ->where('tgl_libur_nasional', '>=', $firstday)
        ->where('tgl_libur_nasional', '<=', $lastday)
        ->get();

    foreach ($liburnasional as $day) {
        $name = date('D', strtotime($day->nasional));
        if ($name != "Sun" || $name != "Sat") {
            if(substr($day->nasional, 0, 10) == $firstday){
                $liburstart = strtotime($firstday.' 16:00:00')- $str_buat;
            }else{
                $holiday++;
            }
        }
    }
    
    $weekends = 0;
    for ($i = $firstday; $i <= $lastday; $i = Date('Y-m-d', strtotime("+1 day", strtotime($i)))) {
        $day = date('D', strtotime($i));
        if ($day == "Sun" || $day == "Sat") {
            $weekends++;
        }
    }
    $libur = $weekends + $holiday;

    $libur = $libur*9*60*60;
    $sisa = (strtotime($lastday) - strtotime($firstday))/60/60/24;
    $sisa = ($sisa-1)*9*60*60;
    $daydiff = ((strtotime($lastday) - strtotime($firstday)))/24/60/60;
    // return $daydiff.'<br>'.$str_done.'<br>'.$str_batas;
    if($daydiff < 1){
        if($str_done>$str_batas){
            //telat
            if($str_done>strtotime($lastday.' 17:00:00')){
                //lebih batas lembur
                $waktu = strtotime($lastday.' 17:00:00') - $str_buat;
            }else{
                //belum batas lembur
                $waktu = $str_done - $str_buat;
            }
        } else {
            //tidak telat
            if($str_done>strtotime($lastday.' 16:00:00')){
                //lebih batas lembur
                $waktu = strtotime($lastday.' 16:00:00') - $str_buat;
            }else{
                //belum batas lembur
                $waktu = $str_done - $str_buat;
                // return $done;
            }
        }
    }else if($daydiff == 1){
        if($str_done>$str_batas){
            //telat
            if($str_done>strtotime($lastday.' 17:00:00')){
                //lebih batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+(strtotime($lastday.' 17:00:00') - strtotime($lastday.' 07:00:00'));
            }else{
                //belum batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+($str_done-strtotime($lastday.' 07:00:00'));
            }
        } else {
            //tidak telat
            if($str_done>strtotime($lastday.' 16:00:00')){
                //lebih batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+(strtotime($lastday.' 16:00:00') - strtotime($lastday.' 07:00:00'));
            }else{
                //belum batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+($str_done - strtotime($lastday.' 07:00:00'));
            }
        }
    }else if($daydiff >= 2){
        if($str_done>$str_batas){
            //telat
            if($str_done>strtotime($lastday.' 17:00:00')){
                //lebih batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+$sisa+(strtotime($lastday.' 17:00:00') - strtotime($lastday.' 07:00:00'));
            }else{
                //belum batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+$sisa+($str_done-strtotime($lastday.' 07:00:00'));
            }
        } else {
            //tidak telat
            if($str_done>strtotime($lastday.' 16:00:00')){
                //lebih batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+$sisa+(strtotime($lastday.' 16:00:00') - strtotime($lastday.' 07:00:00'));
            }else{
                //belum batas lembur
                $waktu = (strtotime($firstday.' 16:00:00') - $str_buat)+$sisa+($str_done - strtotime($lastday.' 07:00:00'));
            }
        }
    }
    $waktu = $waktu - ($libur+$liburstart);
    // ubah waktu ke jam hari jam menit
    $hari = floor($waktu / 9 / 60 / 60);
    $waktu = $waktu - ($hari * 9 * 60 * 60);
    $jam = floor($waktu / 60 / 60);
    $waktu = $waktu - ($jam * 60 * 60);
    $menit = floor($waktu / 60);
    $waktu = $waktu - strtotime($menit);
    if ($menit == 0 && $jam == 0 && $hari == 0) {
        $menit = 1;
    }
    if($hari<0){
        $menit = 0;
        $jam = 0;
        $hari = 0;
    }

    $realisasi = "";
    $realisasi .= number_format($hari, 0, ",", ".") . " hari ";
    $realisasi .= number_format($jam, 0, ",", ".") . " jam ";
    $realisasi .= number_format($menit, 0, ",", ".") . " menit";
    return $realisasi;
}


function hitungSLA($buat, $batas, $done, $status, $tiket = null){
    // dd($buat);
    $hitungSLARumus = hitungSLARumus($buat, $batas, $done, $status);
    // dd($hitungSLARumus);
    // $hitungSLARumus = str_replace('<br>', ' ', $hitungSLARumus);
    // $hitungSLARumus_explode = explode(" ",$hitungSLARumus);
    // $hitungSLARumus_jam = $hitungSLARumus_explode[0];

    // dd($hitungSLARumus_jam);

    $tanggal_on_hold = DB::table('issues_status')
        ->select(DB::raw('issues_status.*'))
        ->where('issues_status.status', '=', 6)
        ->where('issues_status.tiket_issues', '=', $tiket)
        ->get();

    $sla = '';

    if(count($tanggal_on_hold) > 0){
        $hitungSLARumus2 = hitungSLARumus(
            $tanggal_on_hold->first()->tanggal_onhold_start, 
            $tanggal_on_hold->first()->tanggal_onhold_end, 
            $done, 
            $status
        );

        // echo $hitungSLARumus2 . ' - ' . $hitungSLARumus;

        $hitungSLARumus2_explode = explode(" ", $hitungSLARumus2);
        // dd($hitungSLARumus2_explode);
        $hitungSLARumus2_hari = $hitungSLARumus2_explode[0];
        $hitungSLARumus2_jam = $hitungSLARumus2_explode[2];
        $hitungSLARumus2_menit = $hitungSLARumus2_explode[4];

        $day2 = floor($hitungSLARumus2_hari * 24 * 60 * 60);
        $hours2 = floor($hitungSLARumus2_jam * 60 * 60);
        $minutes2 = floor($hitungSLARumus2_menit * 60);

        $minutes_gabungan2 = $day2 + $hours2 + $minutes2;

        // echo $hitungSLARumus2_hari 
        // . ' ' . $hitungSLARumus2_jam
        // . ' ' . $hitungSLARumus2_menit;

        $hitungSLARumus1_explode = explode(" ", $hitungSLARumus);
        // dd($hitungSLARumus2_explode);
        $hitungSLARumus1_hari = $hitungSLARumus1_explode[0];
        $hitungSLARumus1_jam = $hitungSLARumus1_explode[2];
        $hitungSLARumus1_menit = $hitungSLARumus1_explode[4];

        $day1 = floor($hitungSLARumus1_hari * 24 * 60 * 60);
        $hours1 = floor($hitungSLARumus1_jam * 60 * 60);
        $minutes1 = floor($hitungSLARumus1_menit * 60);

        $minutes_gabungan1 = $day1 + $hours1 + $minutes1;

        $hasil_gabungan = $minutes_gabungan1 - $minutes_gabungan2;

        $hari = floor($hasil_gabungan / 24 / 60 / 60);
        $hasil_gabungan = $hasil_gabungan - ($hari * 24 * 60 * 60);
        $jam = floor($hasil_gabungan / 60 / 60);
        $hasil_gabungan = $hasil_gabungan - ($jam * 60 * 60);
        $menit = floor($hasil_gabungan / 60);
        $hasil_gabungan = $hasil_gabungan - strtotime($menit);
        if ($menit == 0 && $jam == 0 && $hari == 0) {
            $menit = 1;
        }
        if($hari<0){
            $menit = 0;
            $jam = 0;
            $hari = 0;
        }

        // echo $hitungSLARumus2 . ' - ' . $hitungSLARumus . ' [] ' .  $hari . ' - '. $jam . ' - ' . $menit;

        $hasil_akhir_perhitunngan_diff_time = "";
        $hasil_akhir_perhitunngan_diff_time .= number_format($hari, 0, ",", ".") . " hari <br>";
        $hasil_akhir_perhitunngan_diff_time .= number_format($jam, 0, ",", ".") . " jam <br>";
        $hasil_akhir_perhitunngan_diff_time .= number_format($menit, 0, ",", ".") . " menit";

        return $hasil_akhir_perhitunngan_diff_time;

    }else{
        // $hitungSLARumus_explode = explode(" ",$hitungSLARumus);
        // $hitungSLARumus_jam = $hitungSLARumus_explode[0];
        // echo $hitungSLARumus_jam .'coba2';
        $hitungSLARumus = str_replace("hari","hari<br>",$hitungSLARumus);
        $hitungSLARumus = str_replace("jam","jam<br>",$hitungSLARumus);
        return $hitungSLARumus;
    }

    // $hitungSLARumus = str_replace('<br>', ' ', $hitungSLARumus);
    
    // dd($hitungSLARumus);
}

//Timer Hold Y-m-d H:i:s
//menghitung selisih waktu dari start dan stop dikurangi (libur nasional dan weekend)
function onHoldTimer($start, $stop, $batas){
    $daydiff = strtotime($stop) - strtotime($start);
    $result = $daydiff+strtotime($batas);
    $day = date('Y-m-d H:i:s', $result);
    //if day is over at 17:00:00 then add 14 hours
    if(date('H:i:s', strtotime($day)) > '16:00:00'){
        $day = date('Y-m-d H:i:s', strtotime($day.' +15 hours'));
    }
    //if day is under at 07:00:00 then add 7 hours
    else if(date('H:i:s', strtotime($day)) < '07:00:00'){
        $day = date('Y-m-d H:i:s', strtotime($day.' +7 hours'));
    }
    //if $day is sunday then add 1 day
    if(date('N', strtotime($day)) == 7){
        $day = date('Y-m-d H:i:s', strtotime($day.' +1 day'));
    }
    //if $day is saturday then add 2 day
    else if(date('N', strtotime($day)) == 6){
        $day = date('Y-m-d H:i:s', strtotime($day.' +2 day'));
    }else{
        $day = date('Y-m-d H:i:s', strtotime($day));
    }
    $dictionary = DB::table('m_libur_nasional')
    ->select(DB::raw('DISTINCT(tgl_libur_nasional) as nasional'))
    ->get()
    ->toArray();
    $state = true;
    //looping using do while
    do{
        //if $day is holiday then add 1 day
        if(isHoliday($day, $dictionary)){
            $day = date('Y-m-d H:i:s', strtotime($day.' +1 day'));
        }else{
            $state = false;
        }
    }while($state == true);
    $return = strtotime($day);
    //return $return as date
    return date('Y-m-d H:i:s', $return);
}

function isHoliday($date, $dictionary){
    //if date is in dictionary then return true
    if(in_array($date, $dictionary)){
        return true;
    }else{
        return false;
    }
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function menghitungCharacterExcludeTagHTML($text)
{
    $trim = strip_tags($text);
    $trim=str_replace([" ","\n","\t","&ndash;","&rsquo;","&#39;","&quot;","&nbsp;"], '', $trim);
    
    $totalCharacter = strlen(utf8_decode($trim));
    return $totalCharacter;
}

function isRealDate($date) { 
    if (false === strtotime($date)) { 
        return false;
    } 
    list($year, $month, $day) = explode('-', substr($date,0,10)); 
    return checkdate($month, $day, $year);
}

function sendWA($receiver, $message, $url = null)
{
    $domain = "http://34.101.96.239/api/message/text";
    // $domain = "https://jogja.wablas.com";
    $key = "9fd62-1ab3f-4642c-a798c-0cfad";
    $token = "4a893-12aac-480ec-ce65c-be98c";
    // $result = "Successfully send message";
    // curl_close($curl);

    $curl = curl_init();
    // $token = "VlJ9zZAlKDj5JTNnQBFZdk6Qv9DO8aYwSWIw4mgbzaiFbmtOx3h9rOE9qli6U3O7";
    $random = true;
    $payload = [
        'schema' => 'NUMBER',
        'receiver' => $receiver,
        'message' => [
            'text' => $message,
            'footer' => 'Pesan ini dikirimkan secara otomatis, harap tidak membalas pesan ini', // opsional, bisa di isi bisa tidak
            'viewOnce' => true, // WAJIB !!
        ],
    ];
    // dd($payload);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "X-APP-KEY: $key",
        "X-APP-TOKEN: $token",
        // "Authorization: $token",
        'Content-Type: application/json',
    ]);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($curl, CURLOPT_URL, $domain);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    // dd($curl);
    $result = curl_exec($curl);
    // curl_close($curl);
    return $result;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

function get_nama_previous_path(){
    if (url()->previous() == null) {
        return null;
    } else {
        $str = url()->previous();    
        $str_arr = explode("/", $str);
        return $str;
    }
}

function get_nama_current_path()
{
    return request()->path();
}

function tambah_issues_log($tiket_issues = null, $catatan = null)
{
    $get_session = Session::get('user_app');
    $get_session_username = $get_session['username'];
    $tambah_issues_status = DB::table('issues_log')
        ->insert([
            'tiket_issues' => $tiket_issues,
            'catatan' => $catatan,
            'created_at' => Carbon::now(),
            'created_by' => $get_session_username,
            'current_route' => get_nama_current_path(),
            'previous_route' => get_nama_previous_path()
        ]);
}

function get_nama_priority($priority_id){
    if ($priority_id == 'P001') {
        return 'Fast';
    }else if ($priority_id == 'P002') {
        return 'Medium';
    }else if ($priority_id == 'P003') {
        return 'Normal';
    }else if ($priority_id == 'P004') {
        return 'Low';
    }else{
        return '';
    }
}

if (!function_exists('get_nama_previous_path')) {
    function get_nama_previous_path()
    {
        if (url()->previous() == null) {
            return null;
        } else {
            $str = url()->previous();
            
            $str_arr = explode("/", $str);
            
            $str_arr_final = explode("?", $str_arr[3]);
            if (isset($str_arr_final[0])) {
                
                return $str_arr_final[0];
                
            } else {
                return null;
            }
        }
    }
}

if (!function_exists('get_nama_current_path')) {
    function get_nama_current_path()
    {
        return request()->path();
    }
}

if (!function_exists('get_nama_current_path_root_group')) {
    function get_nama_current_path_root_group()
    {
        if (request()->path() == null) {
            return null;
        } else {
            $str = request()->path();
            
            $str_arr = explode("/", $str);
            
            $str_arr_final = explode("?", $str_arr[0]);
            if (isset($str_arr_final[0])) {
                
                return $str_arr_final[0];
                
            } else {
                return null;
            }
        }
    }
}

if (!function_exists('get_sub_menu')) {
    function get_sub_menu()
    {
        $user_app = session('user_app');
        $menu = $user_app['menu'];

        $array_sub_menu = [];

        foreach($menu as $datas => $val){
            foreach($val as $datass => $vall){

                $m_sub_menu_url_sub_menu = $vall->m_sub_menu_url_sub_menu;
                $m_sub_menu_url_sub_menu_str_arr = explode("/", $m_sub_menu_url_sub_menu);
                $m_sub_menu_url_sub_menu_root = '';

                if (isset($m_sub_menu_url_sub_menu_str_arr[0])) {
                    $m_sub_menu_url_sub_menu_root = $m_sub_menu_url_sub_menu_str_arr[0];
                } else {
                    $m_sub_menu_url_sub_menu_root = '';
                }

                $array_sub_menu[] = strtolower($m_sub_menu_url_sub_menu_root);
            }
        }

        return $array_sub_menu;

    }
}