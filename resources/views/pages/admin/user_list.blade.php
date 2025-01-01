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
                <h1>Kullanıcı Listesi</h1>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="">
                            <table id="users-table" class="display table-responsive nowrap dataTable cell-border" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ad</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <script>
        $(document).ready(function () {
            $('#users-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json'
                },
                order: [
                    [0, 'ASC']
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.user_fetch') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data:'role', name:'role'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection
