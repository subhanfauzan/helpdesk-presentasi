<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class pegawaiController extends Controller
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
        // dd(request()->route()->getName());
        $data['judul'] = "Pegawai";
        $data['m_role'] = DB::table('m_role')
            ->select(DB::raw("m_role.*"))
            ->get();

        $data['m_flag'] = DB::table('m_flag')
            ->select(DB::raw("m_flag.*"))
            ->get();

        return view('pages.pegawai.index', $data);
    }

    public function getDataPegawai(Request $request)
    {

        if($request->ajax()){
            // dd("AJAX");
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

            $nik_search = is_null($request->NIK) ? '' : $request->NIK;
            $nama_search = is_null($request->Nama) ? '' : $request->Nama;
            $email_search = is_null($request->Email) ? '' : $request->Email;
            $grade_search = is_null($request->Grade) ? '' : $request->Grade;
            $gradename_search = is_null($request->Gradename) ? '' : $request->Gradename;
            $unitid_search = is_null($request->UnitID) ? '' : $request->UnitID;
            $unitname_search = is_null($request->UnitName) ? '' : $request->UnitName;
            $superiornik_search = is_null($request->SuperiorNIK) ? '' : $request->SuperiorNIK;
            $superiorname_search = is_null($request->SuperiorName) ? '' : $request->SuperiorName;

            $get_session = Session::get('user_app');
            $get_session_token = $get_session['token'];

            if (validateSessionToken($get_session_token)) {
                $tb_pegawai = DB::table('pegawai')
                    ->join('m_role', 'm_role.id', '=', 'pegawai.role')
                    ->select(DB::raw("pegawai.*, m_role.nama_role"))
                    // ->where('pegawai.nik', 'ilike%', $nik_search);
                    ->Where('pegawai.nik', 'ilike', '%' . $nik_search . '%')
                    ->Where('pegawai.nama', 'ilike', '%' . $nama_search . '%')
                    ->Where('pegawai.email', 'ilike', '%' . $email_search . '%')
                    ->Where('pegawai.grade', 'ilike', '%' . $grade_search . '%')
                    ->Where('pegawai.gradename', 'ilike', '%' . $gradename_search . '%')
                    ->Where('pegawai.unitid', 'ilike', '%' . $unitid_search . '%')
                    ->Where('pegawai.unitname', 'ilike', '%' . $unitname_search . '%')
                    ->Where('pegawai.superiornik', 'ilike', '%' . $superiornik_search . '%')
                    ->Where('pegawai.superiorname', 'ilike', '%' . $superiorname_search . '%');

                // $datax['total_data'] = $tb_users->first();
                $total_data = $tb_pegawai->count();

                $pegawai = $tb_pegawai
                    ->limit($limit)
                    ->offset($offset)
                    ->get();


                $datas = [];

                $no = $offset + 1;

                if (count($pegawai) > 0) {

                    foreach ($pegawai as $value) {
                        // dd($value['nama']);

                        $datas[] = array(

                            'no' => $no++,
                            'nik' => $value->nik,
                            'nama' => $value->nama,
                            'email' => $value->email,
                            'foto' => $value->foto,
                            'grade' => $value->grade,
                            'gradename' => $value->gradename,
                            'unitid' => $value->unitid,
                            'unitname' => $value->unitname,
                            'superiornik' => $value->superiornik,
                            'superiorname' => $value->superiorname,
                            'role' => $value->nama_role,
                            'created_at' => $value->created_at
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
        } else {
            // dd("no AJAX");
            return "Anda tidak memiliki akses untuk melihat data ini";
        }
    }

    function getapilogin()
    {
        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        $myBody = array(
            "grant_type" => "password",
            "username" => "app_vendor",
            "password" => "apP@v3nd0r123!!",

        );
        $url = "https://sso.petrokimia-gresik.net/api/User/Login";
        $request = $client->post($url, ['form_params' => $myBody]);
        return \GuzzleHttp\json_decode($request->getBody(), true);
        // print_r($request->getBody());
        // return $this->getpegawai();
    }

    function getpegawai()
    {
        $login = $this->getapilogin();
        // print_r($login['access_token'] );exit;
        // dd($login);
        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        $myBody = array(
            "Authorization" => "" . $login['token_type'] . " " . $login['access_token']
        );
        $url = "https://sso.petrokimia-gresik.net/api/Employee/List?unitId=&nik=&name=";

        $response = $client->get($url, ['headers' => $myBody]);

        $fo = \GuzzleHttp\json_decode($response->getBody(), true);

        foreach ($fo as $key => $value) {

            $dataisi[] = array(
                'nik' => $value['nik'],
                'nama' => $value['nama'],
                'email' => $value['email'],
                'foto' => $value['foto'],
                'grade' => $value['grade'],
                'gradename' => $value['gradeName'],
                'unitid' => $value['unitId'],
                'unitname' => $value['unitName'],
                'superiornik' => $value['superiorNik'],
                'superiorname' => $value['superiorName'],
                // 'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                'created_at' => date("Y/m/d H:i:s")
            );
            // $dataisi[]=array();
        }

        return $dataisi;
        // return $this->getPegawaiTambahDatabase();
    }

    function getPegawaiTambahDatabase()
    {
        $login = $this->getapilogin();
        // print_r($login['access_token'] );exit;
        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        $myBody = array(
            "Authorization" => "" . $login['token_type'] . " " . $login['access_token']
        );
        $url = "https://sso.petrokimia-gresik.net/api/Employee/List?unitId=&nik=&name=";

        $response = $client->get($url, ['headers' => $myBody]);

        $fo = \GuzzleHttp\json_decode($response->getBody(), true);

        // dd($fo);
        // dd(array_unique($fo['idBag']));
        // $temp = array_unique(array_column($fo, 'idBag'));
        // $unique_arr = array_intersect_key($fo, $temp);
        // dd($unique_arr);

        foreach ($fo as $key => $value) {

            $dataisi[] = array(
                'nik' => $value['nik'],
                'nama' => $value['nama'],
                'email' => $value['email'],
                'foto' => $value['foto'],
                'grade' => $value['grade'],
                'gradename' => $value['gradeName'],
                'unitid' => $value['unitId'],
                'unitname' => $value['unitName'],
                'superiornik' => $value['superiorNik'],
                'superiorname' => $value['superiorName'],
                // 'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                'created_at' => Carbon::now(),
                'remember_token' => NULL,
                'role' => "R003",
            );
            // $dataisi[]=array();
        }

        $get_pegawai_admin_super = DB::table('pegawai')
            ->select(DB::raw("pegawai.*"))
            ->whereIn('pegawai.nik', ['app_vendor'])
            ->get()
            ->first();

        // dd($get_pegawai_admin_super);

        // if($get_pegawai_admin_super == ){

        // }

        $dataisi[] = array(
            'nik' => 'app_vendor',
            'nama' => 'app_vendor',
            'email' => NULL,
            'foto' => NULL,
            'grade' => NULL,
            'gradename' => NULL,
            'unitid' => NULL,
            'unitname' => NULL,
            'superiornik' => NULL,
            'superiorname' => NULL,
            // 'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
            'created_at' => Carbon::now(),
            'remember_token' => is_null($get_pegawai_admin_super) ? null : $get_pegawai_admin_super->remember_token,
            'role' => "R001",
        );

        // dd($get_pegawai_admin_super->remember_token);

        // $delete_semua_pegawai = DB::table('pegawai')
        //     ->delete();

        for ($i = 0; $i < count($dataisi); $i++) {

            $get_tb_pegawai = DB::table('pegawai')
                ->select(DB::raw("pegawai.*"))
                ->where('pegawai.nik', $dataisi[$i]['nik'])
                ->get();

            if (count($get_tb_pegawai) == 0) {
                $update_pegawai = DB::table('pegawai')
                    ->insert([
                        'nik' => $dataisi[$i]['nik'],
                        'nama' => $dataisi[$i]['nama'],
                        'email' => $dataisi[$i]['email'],
                        'foto' => $dataisi[$i]['foto'],
                        'grade' => $dataisi[$i]['grade'],
                        'gradename' => $dataisi[$i]['gradename'],
                        'unitid' => $dataisi[$i]['unitid'],
                        'unitname' => $dataisi[$i]['unitname'],
                        'superiornik' => $dataisi[$i]['superiornik'],
                        'superiorname' => $dataisi[$i]['superiorname'],
                        // 'password' => $dataisi[$i]['password'],
                        'created_at' => $dataisi[$i]['created_at'],
                        'remember_token' => $dataisi[$i]['remember_token'],
                        'role' => $dataisi[$i]['role'],
                    ]);
            } else {
                $update_pegawai = DB::table('pegawai')
                    ->where('pegawai.nik', $dataisi[$i]['nik'])
                    ->update([
                        // 'nik' => $dataisi[$i]['nik'],
                        'nama' => $dataisi[$i]['nama'],
                        'email' => $dataisi[$i]['email'],
                        'foto' => $dataisi[$i]['foto'],
                        'grade' => $dataisi[$i]['grade'],
                        'gradename' => $dataisi[$i]['gradename'],
                        'unitid' => $dataisi[$i]['unitid'],
                        'unitname' => $dataisi[$i]['unitname'],
                        'superiornik' => $dataisi[$i]['superiornik'],
                        'superiorname' => $dataisi[$i]['superiorname'],
                        // 'password' => $dataisi[$i]['password'],
                        'created_at' => $dataisi[$i]['created_at'],
                        'updated_at' => Carbon::now(),
                        // 'remember_token' => $dataisi[$i]['remember_token'],
                        'role' => $dataisi[$i]['role'],
                    ]);
            }

            // $get_tb_users = DB::table('users')
            //     ->select(DB::raw("users.*"))
            //     ->where('users.nik', $dataisi[$i]['nik'])
            //     ->get();

            // if (count($get_tb_users) == 0) {
            //     $update_users = DB::table('users')
            //         ->insert([
            //             'nik' => $dataisi[$i]['nik'],
            //             'nama' => $dataisi[$i]['nama'],
            //             'username' => $dataisi[$i]['nik'],
            //             'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
            //             'remember_token' => $dataisi[$i]['remember_token'],
            //             'role' => $dataisi[$i]['role'],
            //             'created_at' => Carbon::now(),
            //         ]);
            // } else {
            //     $update_users = DB::table('users')
            //         ->where('users.nik', $dataisi[$i]['nik'])
            //         ->update([
            //             // 'nik' => $dataisi[$i]['nik'],
            //             'nama' => $dataisi[$i]['nama'],
            //             'username' => $dataisi[$i]['nik'],
            //             // 'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
            //             'remember_token' => $dataisi[$i]['remember_token'],
            //             'role' => $dataisi[$i]['role'],
            //             'created_at' => Carbon::now(),
            //         ]);
            // }

            $get_tb_users_admin_unit_kerja = DB::table('users')
                ->select(DB::raw("users.*"))
                ->where('users.username', $dataisi[$i]['unitid'])
                ->get();

            if (count($get_tb_users_admin_unit_kerja) == 0 && $dataisi[$i]['unitid'] != "") {
                $tambah_tb_users_admin_unit_kerja = DB::table('users')
                    ->insert([
                        'nama' => $dataisi[$i]['unitname'],
                        'username' => $dataisi[$i]['unitid'],
                        'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                        'role' => "R004",
                        'created_at' => Carbon::now(),
                        'unitid' => $dataisi[$i]['unitid']
                    ]);
            } else {
                // $update_tb_users_admin_unit_kerja = DB::table('users')
                //     ->where('users.nik', $dataisi[$i]['nik'])
                //     ->update([
                //         'nama' => $dataisi[$i]['unitname'],
                //         'username' => $dataisi[$i]['unitid'],
                //         'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                //     ]);
            }
        }

        $get_tb_users_admin_super = DB::table('users')
            ->select(DB::raw("users.*"))
            ->where('users.role', 'R001')
            ->get();

        // dd($get_tb_users_admin_super);

        if (count($get_tb_users_admin_super) == 0) {
            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super',
                    'username' => 'admin_super',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_1',
                    'username' => 'admin_super_1',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_2',
                    'username' => 'admin_super_2',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_3',
                    'username' => 'admin_super_3',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_4',
                    'username' => 'admin_super_4',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_5',
                    'username' => 'admin_super_5',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_6',
                    'username' => 'admin_super_6',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_7',
                    'username' => 'admin_super_7',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_8',
                    'username' => 'admin_super_8',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_9',
                    'username' => 'admin_super_9',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_super = DB::table('users')
                ->insert([
                    'nama' => 'admin_super_10',
                    'username' => 'admin_super_10',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R001",
                    'created_at' => Carbon::now(),
                ]);
        } else {
        }

        $get_tb_users_admin_lapangan = DB::table('users')
            ->select(DB::raw("users.*"))
            ->where('users.role', 'R005')
            ->get();

        // dd($get_tb_users_admin_super);

        if (count($get_tb_users_admin_lapangan) == 0) {
            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan',
                    'username' => 'admin_lapangan',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_1',
                    'username' => 'admin_lapangan_1',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_2',
                    'username' => 'admin_lapangan_2',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_3',
                    'username' => 'admin_lapangan_3',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_4',
                    'username' => 'admin_lapangan_4',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_5',
                    'username' => 'admin_lapangan_5',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_6',
                    'username' => 'admin_lapangan_6',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_7',
                    'username' => 'admin_lapangan_7',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);

            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_8',
                    'username' => 'admin_lapangan_8',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_9',
                    'username' => 'admin_lapangan_9',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_10',
                    'username' => 'admin_lapangan_10',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);
            $tambah_tb_users_admin_lapangan = DB::table('users')
                ->insert([
                    'nama' => 'admin_lapangan_11',
                    'username' => 'admin_lapangan_11',
                    'password' => '$2y$10$NI9oniC.g.W3Bfo/7Dj2xeU2KvuaiLrfOS7iVnhTM7hhmhqZblscq',
                    'role' => "R005",
                    'created_at' => Carbon::now(),
                ]);
        } else {
        }

        return "berhasil";
    }

    function getPerbaruiPegawai()
    {
        $this->getapilogin();
        $this->getpegawai();
        $this->getPegawaiTambahDatabase();

        return "berhasil";
    }
}
