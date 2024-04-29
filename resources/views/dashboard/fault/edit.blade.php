@extends('templates.layouts.main')

@section('container')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Manajemen Pelanggaran</h1>
                    </div>
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
                <div class="app-card app-card-notification shadow-sm mb-4">
                    <div class="app-card-header px-4 py-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-lg-auto text-center text-lg-start">
                                <div class="app-icon-holder">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <!-- SVG Path -->
                                    </svg>
                                </div><!--//app-icon-holder-->
                            </div><!--//col-->
                            <div class="col-12 col-lg-auto text-center text-lg-start">
                                <div class="notification-type mb-2"><span class="badge bg-primary">Olah Data</span></div>
                                <h4 class="notification-title mb-1">Formulir Ubah Pelanggaran</h4>
                                <ul class="notification-meta list-inline mb-0">
                                    <li class="list-inline-item">Update</li>
                                    <li class="list-inline-item">|</li>
                                    <li class="list-inline-item">System</li>
                                </ul>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body p-4">
                        <form class="row g-2" method="post" action="/dashboard/fault/{{ $fault->id }}">
                            @method('put')
                            @csrf
                            <div class="col-md-12 position-relative">
                                <label for="studentSelect" class="form-label">Siswa<span
                                        class="text-danger">*</span></label>
                                <select id="studentSelect" class="form-control" name="student_id" required>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ $student->id == $fault->student_id ? 'selected' : '' }}>{{ $student->nama }}
                                            | {{ $student->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Kolom untuk NISN -->
                            <div class="col-md-6 position-relative">
                                <label for="validationCustom01" class="form-label">NISN<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="validationCustom01" class="form-control" name="nisn"
                                    value="{{ old('nisn', $fault->nisn) }}" placeholder="Masukkan NISN siswa..." required>
                            </div>

                            <!-- Kolom untuk Nama Orang Tua -->
                            <div class="col-md-6 position-relative">
                                <label for="validationCustom01" class="form-label">Nama Orang Tua<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="validationCustom01" class="form-control" name="nama_ortu"
                                    value="{{ old('nama_ortu', $fault->nama_ortu) }}"
                                    placeholder="Masukkan nama orang tua siswa..." required>
                            </div>

                            <!-- Kolom untuk Alamat -->
                            <div class="col-md-6 position-relative">
                                <label for="validationCustom01" class="form-label">Alamat<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="validationCustom01" class="form-control" name="alamat"
                                    value="{{ old('alamat', $fault->alamat) }}" placeholder="Masukkan alamat siswa..."
                                    required>
                            </div>
                            <!-- Kolom untuk Nomor HP -->
                            <div class="col-md-6 position-relative">
                                <label for="validationCustom01" class="form-label">No. HP<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="validationCustom01" class="form-control" name="no_hp"
                                    value="{{ old('no_hp', $fault->no_hp) }}"
                                    placeholder="Masukkan nomor handphone siswa..." required>
                            </div>
                            <div class="col-md-12 position-relative">
                                <label for="validationCustom01" class="form-label">Bentuk Pelanggaran<span
                                        class="text-danger">*</span></label>
                                <textarea id="pelanggaran" class="form-control" name="pelanggaran" style="height: 100px" required>{{ old('pelanggaran', $fault->pelanggaran) }}</textarea>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="validationCustom01" class="form-label">Poin<span
                                        class="text-danger">*</span></label>
                                <input type="number" id="validationCustom01" class="form-control" name="poin"
                                    value="{{ old('poin', $fault->poin) }}" placeholder="Masukkan poin" required>
                            </div>
                            <p>
                                (Wajib terisi untuk kolom dengan tanda "<span class="text-danger">*</span>").
                            </p>
                    </div><!--//app-card-body-->
                    <div class="app-card-footer px-4 py-3">
                        <button class="btn app-btn-primary" type="submit">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <!-- SVG Path -->
                            </svg> Ubah Data
                        </button>
                        </form>
                    </div><!--//app-card-footer-->
                </div><!--//app-card-->
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@endsection
