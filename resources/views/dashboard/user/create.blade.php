@extends('templates.layouts.main')

@section('container')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Manajemen Pengguna Sistem</h1>
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
                                        <path fill-rule="evenodd"
                                            d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
                                        <path fill-rule="evenodd"
                                            d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </div><!--//app-icon-holder-->
                            </div><!--//col-->
                            <div class="col-12 col-lg-auto text-center text-lg-start">
                                <div class="notification-type mb-2"><span class="badge bg-primary">Olah Data</span></div>
                                <h4 class="notification-title mb-1">Formulir Pengguna Baru</h4>
                                <ul class="notification-meta list-inline mb-0">
                                    <li class="list-inline-item">Create</li>
                                    <li class="list-inline-item">|</li>
                                    <li class="list-inline-item">System</li>
                                </ul>

                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body p-4">
                        <form class="row g-2" method="post" action="/dashboard/user">
                            @csrf
                            <div class="col-md-4 position-relative">
                                <label for="validationCustom01" class="form-label ">Nama<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="validationCustom01" class="form-control" name="nama"
                                    placeholder="Isi Nama Pengguna" required>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="validationCustom01" class="form-label">NIP<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="validationCustom01" class="form-control" name="nip"
                                    placeholder="Isi NIP" required>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label for="validationCustom01" class="form-label ">Jabatan<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="validationCustom01" class="form-control" name="jabatan"
                                    placeholder="Isi Jabatan" required>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationCustom01" class="form-label">E-Mail<span
                                        class="text-danger">*</span></label>
                                <input type="email" id="validationCustom01" class="form-control" name="email"
                                    placeholder="Isi E-Mail" required>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationCustom01" class="form-label">Password<span
                                        class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Isi Password" name="password" required>
                                    </div>
                                    <div class="col-auto">
                                        <h3><i class="bi bi-eye-slash" id="togglePassword"></i></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationCustom01" class="form-label">Role<span
                                        class="text-danger">*</span></label>
                                <div>
                                    <input type="radio" id="laki-laki" name="role" value="Administrator" required>
                                    <label for="laki-laki">Administrator</label>
                                </div>
                                <div>
                                    <input type="radio" id="perempuan" name="role" value="Guru" required>
                                    <label for="perempuan">Guru</label>
                                </div>
                            </div>
                            <p>
                                (Wajib terisi untuk kolom dengan tanda "<span class="text-danger">*</span>").
                            </p>
                    </div><!--//app-card-body-->
                    <div class="app-card-footer px-4 py-3">
                        <button class="btn app-btn-primary" type="submit">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M20 4L3 9.31372L10.5 13.5M20 4L14.5 21L10.5 13.5M20 4L10.5 13.5"
                                        stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                    </path>
                                </g>
                            </svg> Simpan Data
                        </button>
                        </form>
                    </div><!--//app-card-footer-->
                </div><!--//app-card-->
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        const togglePassword = document
            .querySelector('#togglePassword');

        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', () => {

            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';

            password.setAttribute('type', type);

            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye');
        });
    </script>
@endsection
