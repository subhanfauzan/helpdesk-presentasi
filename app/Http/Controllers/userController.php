<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class userController extends Controller
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

        $data['m_role'] = DB::table('m_role')
            ->select(DB::raw("m_role.*"))
            ->where('nama_role','ILIKE', '%admin%')
            ->get();
        $data['v_units'] = DB::table('v_unit_kerja')
            ->select(DB::raw("v_unit_kerja.*"))
            ->where('v_unit_kerja.nama','!=', null)
            ->get();
        $data['judul'] = "Manage User";
        return view('pages.user.index', $data);
    }

    public function getDataUser(Request $request)
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
        $nik = $get_session['username'];

        if (validateSessionToken($get_session_token)) {
            $users =  DB::table('users')
            ->leftJoin('m_role', 'users.role', '=', 'm_role.id')
            ->select('users.nama as nama', 'users.username as username', 'users.unitid as unitid', 'users.role as roleid', 'm_role.nama_role as role');
            
            $total_data = $users->count();
            $users_data = $users
                ->orderBy('users.nama', 'asc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];

            $no = $offset + 1;

            if (count($users_data) > 0) {
                foreach ($users_data as $value) {
                    $datas[] = array(
                        'no' => $no++,
                        'nama' => $value->nama,
                        'username' => $value->username,
                        'role' => $value->role,
                        'aksi' => 
                        '<button type="button" name="edit" class="edit btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalFormEditUser" data-nama="' . $value->nama . '"  data-username="' . $value->username . '" data-role="' . $value->roleid . '" data-unit="' . $value->unitid . '" > <i class="dripicons-pencil"></i> Edit </button> &nbsp;' .
                        '<button type="button" name="delete" id="delete" data-id="' . $value->username . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="dripicons-trash"></i> Hapus </button>'
                    );
                }
            } else {
                $datas = array();
            }
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;
            return response()->json(compact("data",  "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'Anda belum login', 'kode' => 401]);
        }
    }

    public function getDataUserBy(Request $request){
        $nama = $request->nama;
        $username= $request->username;
        $role = $request->role;

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
        $nik = $get_session['username'];

        if (validateSessionToken($get_session_token)) {
            $query =  DB::table('users')
            ->join('m_role', 'users.role', '=', 'm_role.id')
            ->select('users.nama as nama', 'users.username as username', 'users.unitid as unitid', 'users.role as roleid', 'm_role.nama_role as role');
            
            if (!is_null($nama)) {
                $query = $query
                    ->where('users.nama', 'iLIKE', '%'.$nama.'%');
            } 
            if (!is_null($username)) {
                $query = $query
                    ->where('users.username', 'iLIKE', '%'.$username.'%');
            } 
            if (!is_null($role)) {
                $query = $query
                    ->where('users.role', $role);
            } 

            $total_data = $query->count();
            $users = $query
                ->orderBy('users.nama', 'asc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];

            $no = $offset + 1;

            if (count($users) > 0) {
                foreach ($users as $user) {
                    $datas[] = array(
                        'no' => $no++,
                        'nama' => $user->nama,
                        'username' => $user->username,
                        'role' => $user->role,
                        'aksi' => 
                        '<button type="button" name="edit" class="edit btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalFormEditUser" data-nama="' . $user->nama . '"  data-username="' . $user->username . '" data-role="' . $user->roleid . '" data-unit="' . $user->unitid . '" > <i class="dripicons-pencil"></i> Edit </button> &nbsp;' .
                        '<button type="button" name="delete" id="delete" data-id="' . $user->username . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="dripicons-trash"></i> Hapus </button>'
                    );
                }
            } else {
                $datas = array();
            }
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;
            return response()->json(compact("data",  "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'Anda belum login', 'kode' => 401]);
        }
    }

    public function tambah(Request $request)
    {
        
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_username = $get_session['username'];
        if($request->role != 'R003' || $request->role != 'R004'){
            $stat = '';
        }else{
            $stat = 'required';
        }
        $validated = $this->validate($request,[
            'nama'=>'required',
            'username'=>'required|unique:users|min:6',
            'password'=>'required|min:6',
            'role'=>'required',
            'unitid'=> $stat,
        ]);
        if($validated){
            $nama = $request->nama;
            $username = $request->username;
            $password = Hash::make($request->password);
            $role = $request->role;
            $unitid = $request->unitid;
            // dd($request->unitid);
            $now = Carbon::now();
            if (validateSessionToken($get_session_token)) {
                $tambah_user = DB::table('users')
                    ->insert([
                        'nama' => $nama,
                        'username' => $username,
                        'password' => $password,
                        'role' => $role,
                        'unitid' => $unitid,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            } else {
                return response()->json(['success' => 'Anda belum login', 'kode' => 401]);
            }
        }else{
            return response()->json(['success' => 'Pastikan field terisi penuh', 'kode' => 501]);
        }
        
    }

    public function update(Request $request)
    {
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $now = Carbon::now();
        if($request->role != 'R003' || $request->role != 'R004'){
            $stat = '';
        }else{
            $stat = 'required';
        }
        $validated = $this->validate($request,[
            'nama'=>'required',
            'username'=>'required|min:6',
            'password'=>'required|min:6',
            'role'=>'required',
            'unitid'=> $stat,
        ]);
        // dd('oke');
        if($validated){
            $nama = $request->nama;
            $username = $request->username;
            $password = Hash::make($request->password);
            $role = $request->role;
            $unitid = $request->unitid;
            
            $now = Carbon::now();
            if (validateSessionToken($get_session_token)) {
                $update_user = DB::table('users')
                    ->where('users.username', '=', $username)
                    ->update([
                        'nama' => $nama,
                        'username' => $username,
                        'password' => $password,
                        'role' => $role,
                        'unitid' => $unitid,
                        'updated_at' => $now
                    ]);
                return response()->json(['success' => 'Data berhasil diupdate', 'kode' => 201]);
            } else {
                return response()->json(['error' => 'Anda belum login', 'kode' => 401]);
            };
        }else{
            return response()->json(['error' => 'Pastikan field terisi penuh', 'kode' => 501]);
        }
        
    }

    public function delete(Request $request, $id)
    {
        // dd($id);
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
            $delete_user = DB::table('users')
                ->where('users.username', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data berhasil dihapus', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'Anda belum login', 'kode' => 401]);
        };
    }
}
