@extends('themes.default1.client.layout.client')

@section('home')
  class = "nav-item active"
@stop

@section('HeadInclude')
    <link href="{{ asset('lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('lb-faveo/css/widgetbox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('lb-faveo/plugins/iCheck/flat/blue.css') }}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    {{-- <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('lb-faveo/css/jquerysctipttop.css') }}" rel="stylesheet" type="text/css">
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
@stop
@section('breadcrumb')
    {{--    <div class="site-hero clearfix"> --}}
    <ol class="breadcrumb float-sm-right ">
        <li class="breadcrumb-item"> <i class="fas fa-home"> </i> {!! Lang::get('lang.you_are_here') !!} : &nbsp;</li>

        <li><a href="{!! URL::route('/') !!}">{!! Lang::get('lang.home') !!}</a></li>
    </ol>
    {{--    </div> --}}
@stop
@section('content')
    @if (!Session::has('error') && count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="content" class="site-content col-md-12">
        <div id="corewidgetbox" class="wid">

            <div class="alert alert-primary">
                <h5>Tentang LAKON (Layanan Kominfos Online)</h5>
                LAKON (Layanan Kominfos Online) merupakan portal yang memberikan
                informasi
                dan permohonan layanan secara
                online sehingga lebih efisien dan berkualitas bagi pengguna, baik dalam mengatasi masalah teknis maupun
                memberikan
                panduan terkait produk dan layanan yang disediakan.
            </div>
            {{-- <div class="alert alert-warning">
        <h5>Catatan</h5>
        <ul>
          <li>Untuk gangguan atau kendala terhadap layanan seperti aplikasi silahkan mengirimkan tiket langsung dengan
            mengklik tombol kirim tiket dengan menyiapkan bukti dan kronologi dari kendala atau dapat mengirimkan melalui
            e-mail ke <b>support[at]denpasarkota.go.id</b></li>
          <li>Untuk permohonan layanan dapat diajukan melalui halaman kirim tiket atau dapat mengakses halaman <b><a
                href="{{ url('/knowledgebase') }}">list layanan</a></b> untuk melihat semua layanan yang disediakan
            sebelum melakukan permohonan.</li>
          <li>Khusus untuk pengaduan/permintaan informasi terkait Pelayanan Publik Kota Denpasar, dapat disampaikan
            melalui aplikasi DPS (Denpasar Prama Sewaka) atau langsung melalui website <b><a
                href="https://pengaduan.denpasarkota.go.id">pengaduan.denpasarkota.go.id</a></b></li>
        </ul>
      </div> --}}
            <hr>
        </div>

        <script type="text/javascript">
            $(function() {
                $('.dialogerror, .dialoginfo, .dialogalert').fadeIn('slow');
                $("form").bind("submit", function(e) {
                    $(this).find("input:submit").attr("disabled", "disabled");
                });
            });
        </script>
        <script type="text/javascript">
            try {
                if (top.location.hostname != self.location.hostname) {
                    throw 1;
                }
            } catch (e) {
                top.location.href = self.location.href;
            }
        </script>
    </div>

    <?php $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
    ?>
    <div class="col-md-4 py-4 d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
            <span class="fa fa-2x fa-pencil-alt"></span>
        </div>
        <div>
            <h2>Layanan</h2>
            <p>Kumpulan layanan yang tersedia pada paltform ini Anda dapat melihat informasi, syarat dan
                formulir permohonan yang dibutuhkan untuk mengajukan permohonan</p>
            <a href="{{ url('/knowledgebase') }}" class="btn btn-primary">
                Lihat {!! Lang::get('lang.knowledge_base') !!}
            </a>
        </div>
    </div>
    @if ($system != null)
        @if ($system->status)
            @if ($system->status == 1)
                <div class="col-md-4 py-4 d-flex align-items-start">
                    <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                        <span class="fa fa-2x fa-clock"></span>
                    </div>
                    <div>
                        <h2>Hari/Jam Kerja</h2>
                        <p>Kami siap melayani Anda pada jam kerja Senin hingga Kamis, pukul 07.30 - 16.30 Wita dan Jumat,
                            pukul
                            07.30 - 14.30 Wita.</p>
                        <a href="{{ url('pages/hari-jam-kerja') }}" class="btn btn-primary">
                            Hari & Jam Kerja
                        </a>
                    </div>
                </div>
            @endif
        @endif
    @endif
    <div class="col-md-4 py-4 d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
            <span class="fa fa-2x fa-question-circle"></span>
        </div>
        <div>
            <h2>F.A.Q</h2>
            <p>Pertanyaan yang sering diajukan dan informasi umum lainnya. Baca terlebih dahulu pertanyaan-pertanyaan yang
                pernah diajukan sebelumnya, untuk menghindari pertanyaan yang berulang.</p>
            <a href="{{ url('pages/faq') }}" class="btn btn-primary">
                Baca FAQ
            </a>
        </div>
    </div>

    @if (Auth::user())
        <div class="col-md-4 py-4 d-flex align-items-start">
            <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                <span class="fa fa-2x fa-clipboard-list"></span>
            </div>
            <div>
                <h2>Tiket</h2>
                <p>Riwayat Tiket yang pernah diajukan sebelumnya.</p>
                <a href="{{ url('mytickets') }}" class="btn btn-primary">
                    {!! Lang::get('lang.my_tickets') !!}
                </a>
            </div>
        </div>
    @endif
@stop
