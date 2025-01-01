<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function user_list()
    {
        return view('pages.admin.user_list');
    }

    public function role_list()
    {
        return view('pages.admin.role_list');
    }

    public function user_fetch()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return DataTables::of($users)
            ->addIndexColumn() // Satır numarası ekler
            ->addColumn('id', function($row) {
                return $row->id;
            })
            ->addColumn('name', function($row) {
                return $row->name;
            })
            ->addColumn('email', function($row) {
                return $row->email;
            })
            ->addColumn('role', function($row) {
                $role_id = $row->role_id;
                $role = Role::where('role_id', $role_id)->first();
                return $role->name;
            })
            ->addColumn('created_at', function($row) {
                return $row->created_at->format('d/m/Y H:i'); // Tarih formatlama
            })
            ->addColumn('updated_at', function($row) {
                return $row->updated_at->format('d/m/Y H:i'); // Tarih formatlama
            })
            ->addColumn('action', function($row) {
                // Düzenle ve sil butonları
                $btn = '<form action="' . route('admin.user_status', $row->id) . '" method="POST" style="display:inline;margin-right: 5px;">
                            ' . csrf_field() . '
                            <button type="submit" class="edit btn btn-primary btn-sm mr-1">Yetki Güncelle</button>
                        </form>';

                $btn .= '<form action="' . route('admin.user_delete', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            <button type="submit" class="delete btn btn-danger btn-sm ">Sil</button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['action']) // HTML içeriği için rawColumns kullanılır.
            ->make(true);
    }

    public function user_status($id)
    {
        $user = User::find($id);
        if ($user->role_id == 2) {
            $user->role_id = 3;
        } else {
            $user->role_id = 2;
        }
        $user->save();
        return redirect()->route('admin.user_list');
    }
    public function user_delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.user_list');
    }

    public function role_fetch()
    {
        $roles = Role::all();
        return DataTables::of($roles)
            ->addColumn('role_id', function($row) {
                return $row->role_id;
            })
            ->addColumn('name', function($row) {
                return $row->name;
            })
            ->addColumn('action', function($row) {
                // Düzenle ve sil butonları
                $btn = '<form action="' . route('admin.role_delete', $row->role_id) . '" method="POST" style="display:inline;margin-right: 5px;">
                            ' . csrf_field() . '
                            <button type="submit" class="delete btn btn-danger btn-sm ">Sil</button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['action']) // HTML içeriği için rawColumns kullanılır.
            ->make(true);
    }
    public function role_create()
    {
        return view('pages.admin.role_create');
    }
    public function role_store(Request $request)
    {
        $lastRoleId = Role::max('role_id');
        $role = new Role();
        $role->name = $request->name;
        $role->role_id = $lastRoleId + 1;
        $role->save();
        return redirect()->route('admin.role_list');
    }
    public function role_delete($id)
    {
        $id = (int)$id;
        $role = Role::where('role_id', $id)->first();
        $role->delete();
        return redirect()->route('admin.role_list');
    }

}
