@extends('layout.app')

@section('content')
    <style>
        .user-list {
            background-color: #1E2739;
            border: 3px solid #1ef876;
            border-bottom-width: 6px;
            border-radius: 15px;
            padding: 15px;
            width: 100%;
            margin-top: 20px;
        }

        .user-list .card {
            background-color: #2A3448;
            border: none;
            border-radius: 10px;
            padding: 20px;
            color: #FFFFFF;
        }

        .user-list .card h1 {
            color: #1ef876;
            font-size: 24px;
            margin-bottom: 20px;
        }

    </style>

    <div class="user-list">
        <div class="card">
            <form action="{{route('admin.role_store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role_name">Rol Adı</label>
                    <input type="text" class="form-control" id="role_name" name="name" placeholder="Rol Adı">
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
        </div>
    </div>


@endsection
