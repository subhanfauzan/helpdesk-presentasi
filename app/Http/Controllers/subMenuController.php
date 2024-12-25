<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class subMenuController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // dd(Session::get("user_app")["role"]);
            // if(Session::get("user_app")["role"] != "R001" || empty(Session::get('user_app')) || Session::get("user_app")["unitId"] == null ) {
            //     return redirect('/home/index');
            // }
            // dd(empty(Session::get('user_app')));
            if (Session::get("user_app")["role"] != "R001" && Session::get("user_app")["role"] != "R002" || empty(Session::get('user_app'))) {
                // dd('coba');
                return redirect('/home/index');
            }
            return $next($request);
        });
    }

    public function index($menu_id)
    {
        $data['judul'] = "Sub Menu";
        $data['m_sub_menu'] = DB::table('m_sub_menu')
            ->select(DB::raw("m_sub_menu.*"))
            ->where('m_sub_menu.m_menu_id', '=', $menu_id)
            ->get();

        $data['m_menu'] = DB::table('m_menu')
            ->select(DB::raw("m_menu.*"))
            ->where('m_menu.id', '=', $menu_id)
            ->get()
            ->first();

        // dd($data);


        $data['menu_id'] = $menu_id;

        // dd($data);

        return view('pages.sub_menu.index', $data);
    }

    public function getDataSubMenu(Request $request, $menu_id)
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
        // dd($menu_id);

        // $tb_users = DB::table('users')
        //     ->select(DB::raw("users.*"));
        // $token = headerToken()['api-token'];
        // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        // $myBody = array(
        //     "api-token" => $token,
        // );
        // $url = url_api_helpdesk("sub_menu/get/$menu_id");
        // $response = $client->get($url, ['headers' => $myBody, 'query' => $data_arr]);
        // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        // // $data_users = $response_server['result']['message'];
        // $data_users_count = count($data_users);
        // dd($data_users);
        // dd($response_server);


        // dd($response_server['result']['message']);

        // $tb_users_count = $tb_users->count();
        // $tb_users = $tb_users->limit($limit);
        // $tb_users = $tb_users->offset($offset);
        // $tb_users = $tb_users->get();

        $tb_m_sub_menu = DB::table('m_sub_menu')
            ->select(DB::raw("m_sub_menu.*"))
            ->where('m_sub_menu.m_menu_id', '=', $menu_id);

        // $datax['total_data'] = $tb_users->first();
        $total_data = $tb_m_sub_menu->count();


        $m_sub_menu = $tb_m_sub_menu
            ->limit($limit)
            ->offset($offset)
            ->get();

        $datas = [];

        $no = $offset + 1;

        if (count($m_sub_menu) > 0) {

            foreach ($m_sub_menu as $value) {
                // dd($value['nama']);

                $datas[] = array(

                    'no' => $no++,
                    'nama_sub_menu' => $value->nama_sub_menu,
                    'url_sub_menu' => $value->url_sub_menu,
                    'aksi' =>
                    '<button type="button" name="edit" id="edit" 
                    class="btn btn-primary waves-effect waves-light me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modalFormEditSubMenu"
                    data-nama_sub_menu="' . $value->nama_sub_menu . '" 
                    data-url_sub_menu="' . $value->url_sub_menu . '" 
                    data-sub_menu_id="' . $value->id . '"><i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                        '<button type="button" name="delete" id="delete" data-sub_menu_id="' . $value->id . '" class="btn btn-danger btn-xs me-1 mb-1" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>'
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
    }

    public function tambah(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $m_menu_id = $request->m_menu_id;
        $nama_sub_menu = $request->nama_sub_menu;
        $url_sub_menu = $request->url_sub_menu;

        if (validateSessionToken($get_session_token)) {

            $tb_m_sub_menu = DB::table('m_sub_menu')
                ->select(DB::raw("m_sub_menu.*"))
                ->get();

            $tb_m_sub_menu_count = count($tb_m_sub_menu);

            if ($tb_m_sub_menu_count == 0) {
                $tambah_sub_menu = DB::table('m_sub_menu')
                    ->insert([
                        'id' => 'S001',
                        'm_menu_id' => $m_menu_id,
                        'nama_sub_menu' => $nama_sub_menu,
                        'url_sub_menu' => $url_sub_menu,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            } else {
                $tb_m_sub_menu_get_id_terakhir = DB::table('m_sub_menu')
                    ->select(DB::raw("m_sub_menu.*"))
                    ->orderby('m_sub_menu.id', 'DESC')
                    // ->limit(1)
                    ->get()
                    ->first();

                $tambah_sub_menu = DB::table('m_sub_menu')
                    ->insert([
                        'id' => next_value($tb_m_sub_menu_get_id_terakhir->id),
                        'm_menu_id' => $m_menu_id,
                        'nama_sub_menu' => $nama_sub_menu,
                        'url_sub_menu' => $url_sub_menu,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            }
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };


        // dd($response_server);
        // dd();

    }

    public function update(Request $request)
    {

        // $token = headerToken()['api-token'];
        // // $data['data'] = $request->all();
        // // $data['token'] = $token;
        // // dd($request->all());
        // $users_id = Session::get('user_app')['users_id'];
        // $request->request->add(['token' => $token, 'token' => $token, 'users_id' => $users_id]);
        // $data = $request->all();

        // // dd('coba');
        // // dd($request->all());

        // $client = loadfile();

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $m_sub_menu_id_edit = $request->m_sub_menu_id_edit;
        $nama_sub_menu_edit = $request->nama_sub_menu_edit;
        $url_sub_menu_edit = $request->url_sub_menu_edit;

        if (validateSessionToken($get_session_token)) {
            $update_m_sub_menu = DB::table('m_sub_menu')
                ->where('m_sub_menu.id', '=', $m_sub_menu_id_edit)
                ->update([
                    'nama_sub_menu' => $nama_sub_menu_edit,
                    'url_sub_menu' => $url_sub_menu_edit,
                ]);
            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };



        // dd($response_server);
        // dd();

    }

    public function delete(Request $request, $sub_menu_id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $delete_m_sub_menu = DB::table('m_sub_menu')
                ->where('m_sub_menu.id', '=', $sub_menu_id)
                ->delete();

            $delete_m_mapping_menu = DB::table('m_mapping_menu')
                ->where('m_mapping_menu.m_sub_menu_id', '=', $sub_menu_id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }



        // dd($response_server);
        // dd();

    }
}
