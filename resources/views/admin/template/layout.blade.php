<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Mazer Admin Dashboard</title>
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .dt-input {
            min-width: 150px;
            /* Sesuaikan dengan lebar yang diinginkan */
            margin: 2px;
        }

        .dataTables_length select {
            width: 80px;
            /* Atur lebar sesuai keinginan */
        }

        table.dataTable {
            width: 100% !important;
        }

        .dataTables_wrapper {
            overflow: hidden;
        }

        .dataTables_scrollBody {
            overflow-x: hidden !important;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    {{-- @include('admin.template.sidebar') --}}
    @include('admin.template.navbaradmin')


    <div class="container">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/compiled/js/app.js"></script>
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script>
        $(document).ready(function() {
            $('#myTable')
                .DataTable({ // "l" untuk lengthMenu, "r" untuk processing display, "t" untuk tabel, "i" untuk informasi, "p" untuk pagination
                    language: {
                        lengthMenu: "_MENU_",
                        info: "Result _START_ - _END_ of _TOTAL_",
                    },
                    columnDefs: [{
                        className: "dt-center",
                        targets: [1, 2, 3, 4] // Indeks kolom aksi
                    }],
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('tablerole') }}', // Gunakan nama rute yang sudah didefinisikan
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false

                        }, {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'aksi',
                            name: 'aksi'
                        }
                    ]
                });
        });

        // GLOBAL SETUP
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // TEMPLATE TAMBAH DAN EDIT DATA
        function simpan(id = '') {
            if (id == '') {
                var var_url = 'Ajaxrole';
                var var_type = 'POST';
                var name = $('#name'); // Ambil elemen dengan ID name
                var email = $('#email');
            } else {
                var var_url = 'Ajaxupdate/' + id;
                var var_type = 'PUT';
                var name = $('#name2'); // Ambil elemen dengan ID name2
                var email = $('#email2');
            }

            $.ajax({
                url: var_url,
                type: var_type,
                data: {
                    name: name.val(),
                    email: email.val()
                },
                success: function(response) {
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: response.Success,
                    //     showConfirmButton: false,
                    //     timer: 3000
                    // });

                    $('#myTable').DataTable().ajax.reload();

                    $('#name').val('');
                    $('#email').val('');

                    // $('#exampleModal').modal('hide');
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.gagal,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $('#exampleModal').modal('hide');
                }

            });
        }

        // // 1 TAMBAH DATA
        $('body').on('click', '#tambah', function(e) {
            e.preventDefault();
            //open modal
            $('#exampleModal').modal('show');
        });
        $('body').on('click', '#simpan', function() {

            simpan()

        })

        // 2 EDIT DATA
        $('body').on('click', '#edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Lakukan permintaan AJAX untuk mendapatkan data pengguna yang akan diedit
            $.ajax({
                url: 'Ajaxedit/' + id,
                type: 'GET',
                success: function(response) {
                    // Tampilkan modal dan isi field dengan data yang diambil
                    $('#exampleModal2').modal('show');
                    $('#name2').val(response.edit.name);
                    $('#email2').val(response.edit.email);
                    $('body').off('click', '#simpan2').on('click', '#simpan2', function() {
                        simpan(id)
                        $('#exampleModal2').modal('hide');
                    })

                }
            });

        });

        // HAPUS DATA
        $('body').on('click', '#hapus', function(e) {
            e.preventDefault();
            var id = $(this).data('id')

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'Ajaxhapus/' + id,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                            $('#myTable').DataTable().ajax.reload();
                        },
                        error: function() {

                        }
                    });
                };
            });

        })
    </script>
</body>

</html>
