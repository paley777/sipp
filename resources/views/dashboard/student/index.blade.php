@extends('templates.layouts.main')

@section('container')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">

                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Manajemen Siswa</h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                @if (Auth::user()->role == 'Administrator')
                                    <div class="col-auto">
                                        <button class="btn app-btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#importExcel">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-file-earmark-spreadsheet"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
                                            </svg>
                                            Import Batch
                                        </button>
                                        <a class="btn app-btn-primary" href="/dashboard/student/create">
                                            <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M13 3C13 2.44772 12.5523 2 12 2C11.4477 2 11 2.44772 11 3V11H3C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13H11V21C11 21.5523 11.4477 22 12 22C12.5523 22 13 21.5523 13 21V13H21C21.5523 13 22 12.5523 22 12C22 11.4477 21.5523 11 21 11H13V3Z"
                                                        fill="#ffffff"></path>
                                                </g>
                                            </svg>
                                            Tambah Siswa Baru
                                        </a>
                                    </div>
                                @endif
                                <div class="col-auto">
                                    <select id="select_kelas" class="form-select">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <!-- Tombol untuk Memilih Siswa Berdasarkan Kelas -->
                                    <a href="#" id="btn_pilih_siswa" class="btn btn-primary text-white">Cari
                                        Berdasarkan Kelas</a>
                                </div>
                            </div><!--//row-->
                        </div><!--//table-utilities-->
                    </div><!--//col-auto-->
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <!-- Tambahkan di atas tabel siswa -->
                    @if (isset($selected_kelas))
                        <div class="alert alert-info" role="alert">
                            Menampilkan siswa untuk kelas: {{ $selected_kelas }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div><!--//row-->
                <div class="tab-content" id="orders-table-tab-content">
                    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                        <div class="app-card app-card-orders-table shadow-sm mb-5">
                            <div class="app-card-body">
                                <div class="table-responsive p-4">
                                    <table id="example" class="table app-table-hover mb-0 text-left">
                                        <thead>
                                            <tr>
                                                <th class="cell">No.</th>
                                                <th class="cell">Nama</th>
                                                <th class="cell">Kelas</th>
                                                <th class="cell">Jenis Kelamin</th>
                                                <th class="cell">User Email</th> <!-- New column header -->
                                                @if (Auth::user()->role == 'Administrator')
                                                    <th class="cell">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $student->nama }}</td>
                                                    <td>{{ $student->kelas }}</td>
                                                    <td>{{ $student->jenis_kelamin }}</td>
                                                    <td>{{ $student->user ? $student->user->email : 'N/A' }}</td>
                                                    <!-- Displaying the user's email -->
                                                    @if (Auth::user()->role == 'Administrator')
                                                        <td>
                                                            <a href="/dashboard/student/{{ $student->id }}/edit"
                                                                class="btn btn-sm btn-warning"><svg width="16px"
                                                                    height="16px" viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <title></title>
                                                                        <g id="Complete">
                                                                            <g id="edit">
                                                                                <g>
                                                                                    <path
                                                                                        d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8"
                                                                                        fill="none" stroke="#000000"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"></path>
                                                                                    <polygon fill="none"
                                                                                        points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8"
                                                                                        stroke="#000000"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"></polygon>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </svg> Ubah</a>
                                                            <form action="/dashboard/student/{{ $student->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button class="btn btn-sm btn-danger text-white"
                                                                    onclick="return confirm('Anda yakin untuk menghapus data ini?')">
                                                                    <svg width="16px" height="16px"
                                                                        viewBox="0 0 1024 1024"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                        <g id="SVGRepo_tracerCarrier"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                        </g>
                                                                        <g id="SVGRepo_iconCarrier">
                                                                            <path fill="#ffffff"
                                                                                d="M195.2 195.2a64 64 0 0 1 90.496 0L512 421.504 738.304 195.2a64 64 0 0 1 90.496 90.496L602.496 512 828.8 738.304a64 64 0 0 1-90.496 90.496L512 602.496 285.696 828.8a64 64 0 0 1-90.496-90.496L421.504 512 195.2 285.696a64 64 0 0 1 0-90.496z">
                                                                            </path>
                                                                        </g>
                                                                    </svg> Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><!--//table-responsive-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div><!--//tab-pane-->
                </div><!--//tab-content-->
            </div><!--//container-fluid-->
        </div><!--//app-content-->
    </div><!--//app-wrapper-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Impor Data dari Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="responsive-small">Pilih file excel yang akan diimpor.</p>
                    <p class="responsive-small fw-semibold">Format .xls atau .xlsx</p>
                    <img src="{{ url('/assets/tatacara.png') }}" alt="Logo" width="720" height="384"
                        class="">
                    <hr>
                    <form action="/dashboard/student/import" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                            <div class="custom-file text-left">
                                <input type="file" name="file" class="custom-file-input responsive-small"
                                    id="customFile"
                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <label class="custom-file-label" for="customFile">Pilih File</label>
                            </div>
                        </div>
                        <button class="btn btn-warning fw-semibold">Impor Data
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z" />
                                <path
                                    d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                            </svg>

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectKelas = document.getElementById('select_kelas');
            var btnPilihSiswa = document.getElementById('btn_pilih_siswa');

            btnPilihSiswa.addEventListener('click', function() {
                var kelas = selectKelas.value;
                if (kelas) {
                    // Redirect ke route yang sesuai dengan kelas yang dipilih
                    window.location.href = '/dashboard/student/select/' + kelas;
                } else {
                    // Jika tidak ada kelas yang dipilih, kembalikan ke halaman dengan semua data siswa
                    window.location.href = '/dashboard/student';
                }
            });
        });
    </script>

@endsection
