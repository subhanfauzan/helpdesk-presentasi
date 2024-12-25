<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class roleController extends Controller
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
        $data['judul'] = "Role";
        $data['m_role'] = DB::table('m_role')
            ->select(DB::raw("m_role.*"))
            ->get();

        $data['m_flag'] = DB::table('m_flag')
            ->select(DB::raw("m_flag.*"))
            ->get();

        return view('pages.role.index', $data);
    }

    public function getDataRole(Request $request)
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
        // dd($get_session['token']);
        // dd($limit);

        // $tb_users = DB::table('users')
        //     ->select(DB::raw("users.*"));
        // $token = headerToken()['api-token'];
        // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        // $myBody = array(
        //     "api-token" => $token,
        // );
        // $url = url_api_helpdesk('role/get');
        // $response = $client->get($url, ['headers' => $myBody, 'query' => $data_arr]);
        // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        // $data_users = $response_server['result']['message'];
        // $data_users_count = count($data_users);
        // dd($data_users);
        // dd($response_server);


        // dd($response_server['result']['message']);

        // $tb_users_count = $tb_users->count();
        // $tb_users = $tb_users->limit($limit);
        // $tb_users = $tb_users->offset($offset);
        // $tb_users = $tb_users->get();


        if (validateSessionToken($get_session_token)) {
            $tb_m_role = DB::table('m_role')
                ->select(DB::raw("m_role.*"));

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_role->count();


            $m_role = $tb_m_role
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_role) > 0) {

                foreach ($m_role as $value) {
                    // dd($value['nama']);

                    $datas[] = array(

                        'no' => $no++,
                        'nama_role' => $value->nama_role,
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                    class="btn btn-primary waves-effect waves-light me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditRole"
                    data-nama_role="' . $value->nama_role . '" 
                    data-role_id="' . $value->id . '"
                    data-flag="' . $value->flag . '" 
                    >
                    <i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                            '<button type="button" name="delete" id="delete" data-role_id="' . $value->id . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>'
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

    public function tambah(Request $request)
    {

        // $token = headerToken()['api-token'];
        // $data['data'] = $request->all();
        // $data['token'] = $token;
        // $users_id = Session::get('user_app')['users_id'];
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        // $request->request->add(['token' => $token, 'token' => $token, 'users_id' => $users_id]);
        // $data = $request->all();
        $nama_role = $request->nama_role;
        $flag = $request->flag;

        // dd($data);

        $client = loadfile();

        // try {
        //     $url = url_api_helpdesk('role/tambah');
        //     $response = $client->post($url, ['form_params' => $data]);
        //     $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        //     // dd($response_server);
        //     return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        // } catch (RequestException $e) {
        //     // return response()->json(['success' => $e, 'kode' => 401]);
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // }

        if (validateSessionToken($get_session_token)) {
            $tb_m_role = DB::table('m_role')
                ->select(DB::raw("m_role.*"))
                ->get();

            $tb_m_role_count = count($tb_m_role);

            // return response()->json($tb_m_role_count);

            if ($tb_m_role_count == 0) {
                $tambah_role = DB::table('m_role')
                    ->insert([
                        'id' => 'R001',
                        'nama_role' => $nama_role,
                        'flag' => $flag,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            } else {

                $tb_m_role_get_id_terakhir = DB::table('m_role')
                    ->select(DB::raw("m_role.*"))
                    ->orderby('m_role.id', 'DESC')
                    // ->limit(1)
                    ->get()
                    ->first();

                // return response()->json($tb_m_role_get_id_terakhir->id);

                $tambah_role = DB::table('m_role')
                    ->insert([
                        'id' => next_value($tb_m_role_get_id_terakhir->id),
                        'nama_role' => $nama_role,
                        'flag' => $flag,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            }

            return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function update(Request $request)
    {

        // $token = headerToken()['api-token'];
        // $data['data'] = $request->all();
        // $data['token'] = $token;
        // dd($request->all());
        // $users_id = Session::get('user_app')['users_id'];
        // $request->request->add(['token' => $token, 'token' => $token, 'users_id' => $users_id]);
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        // $request->request->add(['token' => $token, 'token' => $token, 'users_id' => $users_id]);
        // $data = $request->all();
        $role_id_edit = $request->role_id_edit;
        $nama_role_edit = $request->nama_role_edit;
        $flag_edit = $request->flag_edit;

        // dd('coba');
        // dd($request->all());

        $client = loadfile();

        // try {
        //     $url = url_api_helpdesk('role/update');
        //     $response = $client->post($url, ['form_params' => $data]);
        //     $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        //     // dd($response_server);
        //     return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        // } catch (RequestException $e) {
        //     // return response()->json(['success' => $e, 'kode' => 401]);
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // }

        // dd($response_server);
        // dd();

        if (validateSessionToken($get_session_token)) {
            $role_id_edit = $request->role_id_edit;
            $nama_role_edit = $request->nama_role_edit;
            $flag_edit = $request->flag_edit;

            $update_m_role = DB::table('m_role')
                ->where('m_role.id', '=', $role_id_edit)
                ->update([
                    'nama_role' => $nama_role_edit,
                    'flag' => $flag_edit,
                ]);


            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function delete(Request $request, $id)
    {

        // $token = headerToken()['api-token'];
        // $data['data'] = $request->all();
        // $data['token'] = $token;
        // dd($request->all());
        // $users_id = Session::get('user_app')['users_id'];
        // $request->request->add(['token' => $token, 'token' => $token, 'users_id' => $users_id]);
        // $data = $request->all();

        // dd('coba');
        // dd($request->all());
        // $array = array("users_id" => $id);
        // $request->request->add(['token' => $token, 'users_id' => $id]);
        // dd($request->all());
        // $data_arr    = [
        //     'token' => $token
        // ];

        // $client = loadfile();

        // try {
        //     $url = url_api_helpdesk("role/delete/$id");
        //     $response = $client->get($url, ['query' => $data_arr]);
        //     $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        //     // dd($response_server);
        //     return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        // } catch (RequestException $e) {
        //     // return response()->json(['success' => $e, 'kode' => 401]);
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // }

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
            $delete_m_role = DB::table('m_role')
                ->where('m_role.id', '=', $id)
                ->delete();

            $delete_m_mapping_menu = DB::table('m_mapping_menu')
                ->where('m_mapping_menu.m_role_id', '=', $id)
                ->delete();

            $update_pegawai = DB::table('pegawai')
                ->where('pegawai.role', '=', $id)
                ->update([
                    'role' => null,
                ]);

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };



        // dd($response_server);
        // dd();

    }
}
