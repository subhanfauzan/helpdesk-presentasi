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

class loginController extends Controller
{

    public function index()
    {
        if (Session::has('user_app')) {
            return redirect('/home/index');
        }

        $data['judul'] = "Login";
        return view('login.index', $data);
    }

    public function login(Request $request)
    {
        // dd('coba');
        $username = $request->username;
        $password = $request->password;

        $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        $myBody = array(
            "grant_type" => "password",
            "username" => $username,
            "password" => $password,

        );
        // $url = "https://sso.petrokimia-gresik.net/api/User/Login";
        $url = "https://sso.petrokimia-gresik.net/dev/api/User/Login";
        $request = $client->post($url, ['form_params' => $myBody]);
        $response = \GuzzleHttp\json_decode($request->getBody(), true);
        // return $response['status'];


        // $username = $request->input("username");
        // $password = $request->input("password");
        // $tes = hash::make($password);
        // return response()->json($tes);
        // dd($tes);
        // $ambil_pegawai = db::table('pegawai')
        //     ->where("nik", '=', $request->username)
        //     ->get()
        //     ->first();

        // $role = db::table('m_role')
        //     ->where("m_role.id", '=', $pegawai->role)
        //     ->get()
        //     ->first();

        if ($response['status'] == "true") {
            // dd($response);
            // dd('coba');
            // if (Hash::check($password, $pegawai->password)) {
            $newtoken  = $this->generateRandomString();
            // dd($response['status']);

            $companyCode = $response['companyCode'];
            $userName = $response['userName'];
            $nikSap = $response['nikSap'];
            $name = $response['name'];
            $posTitle = $response['posTitle'];
            $unitId = $response['unitId'];
            $unitName = $response['unitName'];
            $isActive = $response['isActive'];
            $status = $response['status'];
            $access_token = $response['access_token'];
            $token_type = $response['token_type'];
            $expires_in = $response['expires_in'];
            $issued = $response['.issued'];
            $expires = $response['.expires'];

            $pegawai = db::table('pegawai')
                ->where("nik", '=', $response['userName'])
                ->get()
                ->first();

            $pegawai_id = $pegawai ? $pegawai->id : NULL;
            $gradename = $pegawai ? $pegawai->gradename : NULL;
            $role = $pegawai ? $pegawai->role : NULL;
            $foto = $pegawai ? $pegawai->foto : NULL;

            $updated_at = $pegawai ? $pegawai->updated_at : NULL;

            $ambil_role = db::table('m_role')
                ->where("m_role.id", '=', $role)
                ->get()
                ->first();

            // dd($ambil_role);

            $flag = $ambil_role ? $ambil_role->flag : NULL;

            $now = new \DateTime(date("Y-m-d h:i:s"));
            $date1 = new \DateTime($updated_at);
            $diff = $now->diff($date1);

            $token_buat_sendiri = $newtoken;

            $update_pegawai = DB::table('pegawai')
                ->where('pegawai.nik', '=', $userName)
                ->update([
                    'remember_token' => $token_buat_sendiri,
                    'updated_at' => Carbon::now()
                ]);

            // dd($role);

            $get_mapping_menu_sub_menu_group_by = db::table('m_mapping_menu')
                ->select(DB::raw('m_sub_menu.m_menu_id, m_menu.nama_menu, m_menu.icon_menu'))
                ->where("m_mapping_menu.m_role_id", '=', $role)
                ->join('m_sub_menu', 'm_sub_menu.id', '=', 'm_mapping_menu.m_sub_menu_id')
                ->join('m_menu', 'm_menu.id', '=', 'm_sub_menu.m_menu_id')
                ->groupBy('m_sub_menu.m_menu_id', 'm_menu.nama_menu', 'm_menu.icon_menu')
                ->get();

            // dd($get_mapping_menu_sub_menu_group_by);
            $array_menu = [];
            foreach ($get_mapping_menu_sub_menu_group_by as $data) {
                $get_mapping_menu_sub_menu = db::table('m_mapping_menu')
                    ->select(DB::raw('m_mapping_menu.*, m_menu.id as m_menu_id, m_menu.nama_menu as m_menu_nama_menu, m_menu.icon_menu as m_menu_icon_menu, m_sub_menu.nama_sub_menu as m_sub_menu_nama_sub_menu, m_sub_menu.url_sub_menu as m_sub_menu_url_sub_menu'))
                    ->where("m_mapping_menu.m_role_id", '=', $pegawai->role)
                    ->where("m_sub_menu.m_menu_id", '=', $data->m_menu_id)
                    ->join('m_sub_menu', 'm_sub_menu.id', '=', 'm_mapping_menu.m_sub_menu_id')
                    ->join('m_menu', 'm_menu.id', '=', 'm_sub_menu.m_menu_id')
                    ->get()
                    ->toArray();
                foreach ($get_mapping_menu_sub_menu as $data2) {
                    // if($data->m_menu_id == $data2->m_menu_id){
                    $array_menu[$data->nama_menu] = $get_mapping_menu_sub_menu;
                    // }
                }
            }
            // dd($array_menu);

            $data_user = [];
            $data_user['users_id']                  = $pegawai_id;
            $data_user['nik']                       = $userName;
            $data_user['username']                  = $userName;
            $data_user['nama']                      = $name;
            $data_user['role']                      = $role;
            $data_user['flag']                      = $flag;
            $data_user['token']                     = $token_buat_sendiri;
            $data_user['unitId']                    = $unitId;
            $data_user['unitName']                  = $unitName;
            $data_user['gradename']                 = $gradename;
            $data_user['foto']                      = $foto;
            $data_user['menu']                      = $array_menu;

            Session::put('user_app', $data_user);
            // dd(Session::get('user_app'));
            return response()->json(['success' => 'Anda Berhasil Login', 'kode' => 200]);
            // } else {
            //     return response()->json(['success' => 'Anda Gagal Login', 'kode' => 401]);
            // }
        } else {

            // dd('coba');
            // $username = $request->username;
            // $password = $request->password;

            $get_username_users = db::table('users')
                ->where('users.username', '=', $username)
                ->get()
                ->first();
            if ($get_username_users != null) {
                // dd('ini data admin unit kerja');
                if (Hash::check($password, $get_username_users->password)) {
                    // dd('sukses login admin');
                    $users = db::table('users')
                        ->where("users.username", '=', $get_username_users->username)
                        ->get()
                        ->first();

                    $pegawai_id = $users ? $users->id : NULL;
                    $role = $users ? $users->role : NULL;
                    $unit_id = $users ? $users->unitid : NULL;
                    $nama = $users ? $users->nama : NULL;
                    $username = $users ? $users->username : NULL;
                    // $foto = NULL;

                    $updated_at = $users ? $users->updated_at : NULL;

                    $pegawai = db::table('pegawai')
                        ->where("nik", '=', $username)
                        ->get()
                        ->first();

                    $gradename = $pegawai ? $pegawai->gradename : NULL;

                    $ambil_role = db::table('m_role')
                        ->where("m_role.id", '=', $role)
                        ->get()
                        ->first();

                    // dd($ambil_role);

                    $flag = $ambil_role ? $ambil_role->flag : NULL;

                    $now = new \DateTime(date("Y-m-d h:i:s"));
                    $date1 = new \DateTime($updated_at);
                    $diff = $now->diff($date1);

                    $newtoken  = $this->generateRandomString();

                    $token_buat_sendiri = $newtoken;

                    // dd($username);

                    $update_users = DB::table('users')
                        ->where('users.username', '=', $username)
                        ->update([
                            'remember_token' => $token_buat_sendiri,
                            'updated_at' => Carbon::now()
                        ]);

                    // dd($role);

                    $get_mapping_menu_sub_menu_group_by = db::table('m_mapping_menu')
                        ->select(DB::raw('m_sub_menu.m_menu_id, m_menu.nama_menu, m_menu.icon_menu'))
                        ->where("m_mapping_menu.m_role_id", '=', $role)
                        ->join('m_sub_menu', 'm_sub_menu.id', '=', 'm_mapping_menu.m_sub_menu_id')
                        ->join('m_menu', 'm_menu.id', '=', 'm_sub_menu.m_menu_id')
                        ->groupBy('m_sub_menu.m_menu_id', 'm_menu.nama_menu', 'm_menu.icon_menu')
                        ->get();

                    // dd($get_mapping_menu_sub_menu_group_by);
                    $array_menu = [];
                    foreach ($get_mapping_menu_sub_menu_group_by as $data) {
                        $get_mapping_menu_sub_menu = db::table('m_mapping_menu')
                            ->select(DB::raw('m_mapping_menu.*, m_menu.id as m_menu_id, m_menu.nama_menu as m_menu_nama_menu, m_menu.icon_menu as m_menu_icon_menu, m_sub_menu.nama_sub_menu as m_sub_menu_nama_sub_menu, m_sub_menu.url_sub_menu as m_sub_menu_url_sub_menu'))
                            ->where("m_mapping_menu.m_role_id", '=', $users->role)
                            ->where("m_sub_menu.m_menu_id", '=', $data->m_menu_id)
                            ->join('m_sub_menu', 'm_sub_menu.id', '=', 'm_mapping_menu.m_sub_menu_id')
                            ->join('m_menu', 'm_menu.id', '=', 'm_sub_menu.m_menu_id')
                            ->get()
                            ->toArray();
                        foreach ($get_mapping_menu_sub_menu as $data2) {
                            // if($data->m_menu_id == $data2->m_menu_id){
                            $array_menu[$data->nama_menu] = $get_mapping_menu_sub_menu;
                            // }
                        }
                    }
                    // dd($array_menu);

                    $data_user = [];
                    $data_user['users_id']                  = $pegawai_id;
                    $data_user['nik']                       = null;
                    $data_user['username']                  = $username;
                    $data_user['nama']                      = $nama;
                    $data_user['role']                      = $role;
                    $data_user['flag']                      = $flag;
                    $data_user['token']                     = $token_buat_sendiri;
                    $data_user['unitId']                    = $unit_id;
                    $data_user['unitName']                  = null;
                    $data_user['gradename']                 = $gradename;
                    $data_user['foto']                      = null;
                    $data_user['menu']                      = $array_menu;

                    Session::put('user_app', $data_user);
                    // dd(Session::get('user_app'));
                    return response()->json(['success' => 'Anda Berhasil Login', 'kode' => 200]);
                } else {
                    // dd('gagal login admin');
                    return response()->json(['success' => 'Anda Gagal Login', 'kode' => 401]);
                }
            } else {
                // dd('data tidak ditemukan');
                return response()->json(['success' => 'Anda Gagal Login', 'kode' => 401]);
            }

            // return response()->json(['success' => 'Anda Gagal Login', 'kode' => 401]);
        }

        // dd($login);


    }

    function generateRandomString($length = 80)
    {
        $karakkter = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $panjang_karakter = strlen($karakkter);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $karakkter[rand(0, $panjang_karakter - 1)];
        }
        return $str;
    }

    public function logout()
    {
        $session_username = Session::get('user_app')['username'];

        // dd($session_nik);

        $pegawai = db::table('pegawai')->where("nik", $session_username)->first();
        // dd($user);
        $ara = array('remember_token' => NULL, 'updated_at' => date("Y-m-d H:i:s"));
        if ($pegawai) {
            DB::table('pegawai')->where("nik", $session_username)->update($ara);
        } else {
        }

        Session::flush();
    }

    public function getDetailDataIssues($tiket_issues_duplikat)
    {

        // dd($tiket_issues_duplikat);
        $tiket_issues_duplikat = decrypt_($tiket_issues_duplikat);
        $get_detail_data_issues = db::table('v_issues')
            ->select(DB::raw('v_issues.*,
            v_users_all.nama as nama_pegawai,
            m_kategori.nama_kategori as nama_kategori,
            m_layanan.nama_layanan as nama_layanan,
            m_subject.nama_subject as nama_subject,
            m_priority.nama_priority as nama_priority'))
            ->where('v_issues.tiket_issues_duplikat', '=', $tiket_issues_duplikat)
            ->leftjoin('v_users_all', 'v_users_all.username', '=', 'v_issues.username_sap_issues')
            ->leftjoin('m_kategori', 'm_kategori.id', '=', 'v_issues.kategori_id')
            ->leftjoin('m_layanan', 'm_layanan.id', '=', 'v_issues.layanan_id')
            ->leftjoin('m_subject', 'm_subject.id', '=', 'v_issues.subject_id')
            ->leftjoin('m_priority', 'm_priority.id', '=', 'v_issues.priority_id')
            ->get();

        // dd($get_detail_data_issues);

        if (count($get_detail_data_issues) > 0) {

            $get_issues_file = DB::table('issues_file')
                ->select(DB::raw("issues_file.*"))
                ->where('issues_file.issues_tiket', '=', $get_detail_data_issues->first()->tiket_issues)
                ->get();

            $issues_link_file_array = '';

            foreach ($get_issues_file as $value_2) {
                // $issues_link_array = "";
                // $issues_link_array .= '<a href="' . url() . 'v_issues/' . $value_2->file_name . '">' . url() . '/v_issues/' . $value_2->file_name . '</a> <br>';
                $issues_link_file_array .= '<a href="' . url('download_file') . '/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a> <br>';
                // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                // $issues_link_array .= '<button type="submit" onclick="window.open("' . $value_2->file_name . '")">Download!</button>';
            }

            return response()->json(['data' => $get_detail_data_issues->first(), 'issues_link_file_array' => $issues_link_file_array, 'kode' => 200]);
        } else {
            return response()->json(['data' => 'kosong', 'issues_link_file_array' => 'kosong', 'kode' => 401]);
        }
    }

    public function getDescriptionIssues($tiket_issues_duplikat)
    {
        // dd('coba');
        $tiket_issues_duplikat = decrypt_($tiket_issues_duplikat);
        $tb_issues = DB::table('v_issues')
            ->select(DB::raw("v_issues.*"))
            ->where('v_issues.tiket_issues_duplikat', '=', $tiket_issues_duplikat)
            ->get()
            ->first();

        $status_issues_html = status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_duplikat));

        return response()->json(['description_issues' => $tb_issues->description_issues, 'status_issues_html' => $status_issues_html]);
    }

    public function download_file($file_name_dengan_extension)
    {
        $file = public_path() . "/file_issues/$file_name_dengan_extension";

        // // dd($file);

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        // return Response::download($file, $file_name_dengan_extension, $headers);
        return response()->download($file);
    }

    public function getListDataRiwayatStatusIssues(Request $request, $tiket_issues)
    {

        // dd('coba');

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

        // $get_session = Session::get('user_app');
        // $get_session_token = $get_session['token'];
        // $get_session_role = $get_session['role'];
        // $get_session_nik = $get_session['nik'];
        // $get_session_unitId = $get_session['unitId'];

        // if (validateSessionToken($get_session_token)) {
        $tb_issues_status = DB::table('issues_status')
            ->select(DB::raw("issues_status.*,
                v_users_all.nama as nama_user,
                v_users_all.role as role_user"))
            ->leftjoin('v_users_all', 'v_users_all.username', 'issues_status.created_by')
            ->where('issues_status.tiket_issues', '=', $tiket_issues)
            ->orderBy('issues_status.created_at', 'DESC');

        // $datax['total_data'] = $tb_users->first();
        $total_data = $tb_issues_status->count();


        $m_status = $tb_issues_status
            ->limit($limit)
            ->offset($offset)
            ->get();


        $datas = [];

        $no = $offset + 1;

        // $photo = "";
        $no_ckeditor = 0;

        if (count($m_status) > 0) {
            foreach ($m_status as $value) {
                // dd($no_ckeditor++);
                $datas[] = array(
                    'no' => $no++,
                    'status' => status_issues_id_ke_text($value->status),
                    // 'catatan' => $value->catatan,
                    'catatan' => '<div style="border: 0px; font-size:18px;" name="catatan_status_list_ckeditor' . $no_ckeditor . '" id="catatan_status_list_ckeditor' . $no_ckeditor . '" class="catatan_status_list_ckeditor' . $no_ckeditor . '" style="max-width:100%" >' . $value->catatan . '</div>',
                    'created_by' => $value->nama_user,
                    'created_at' => $value->created_at
                );

                $no_ckeditor++;
            }
        } else {
            $datas = array();
        }

        // dd($datas);
        $recordsTotal = is_null($total_data) ? 0 : $total_data;
        $recordsFiltered = is_null($total_data) ? 0 : $total_data;
        $data = $datas;

        return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        // } else {
        //     return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        // }
    }
}
