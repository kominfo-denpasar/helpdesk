@extends('themes.default1.client.layout.client')

@section('title')
{!! Lang::get('lang.submit_a_ticket') !!} -
@stop

@section('submit')
class = "nav-item active"
@stop
<!-- breadcrumbs -->
@section('breadcrumb')
{{--<div class="site-hero clearfix">--}}
    <ol class="breadcrumb float-sm-right ">
        <style>
            .words {
                margin-right: 10px; /* Adjust the value to increase or decrease the gap between list items */
            }
        </style>
        <li class="breadcrumb-item"> <i class="fas fa-home"> </i> {!! Lang::get('lang.you_are_here') !!} : &nbsp;</li>
        <li><a class="words" href="{{url('/')}}">{!! Lang::get('lang.home') !!}</a></li>
        <li class="words" style="margin-right: 10px">></li>

        <li><a href="{!! URL::route('form') !!}">{!! Lang::get('lang.submit_a_ticket') !!}</a></li>
    </ol>
</div>
@stop
<!-- /breadcrumbs -->
@section('check')
{{--
    <div id="sidebar" class="site-sidebar col-md-3">
        <div id="form-border" class="comment-respond form-border" style="background : #fff">
            <section id="section-categories" class="section">
                <h2 class="section-title h4 clearfix">
                    <i class="line"></i>{!! Lang::get('lang.have_a_ticket') !!}?
                </h2>

                @if(Session::has('check'))
                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{!! Lang::get('lang.alert') !!} !</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </div>
                @endif
                @endif

                <div>
                     {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}
                    {!! Form::label('email',Lang::get('lang.email')) !!}<span class="text-red"> *</span>
                    {!! Form::text('email_address',null,['class' => 'form-control form-group']) !!}
                    {!! Form::label('ticket_number',Lang::get('lang.ticket_number')) !!}<span class="text-red"> *</span>
                    {!! Form::text('ticket_number',null,['class' => 'form-control form-group']) !!}
                    <button type="submit" class="btn btn-info" style=" background-color: #337ab7 !important; border-color: #337ab7 !important; color: white">
                        <i class="fas fa-save"></i> {!! Lang::get('lang.check_ticket_status') !!}
                    </button>
                    {!! Form::close() !!}
                </div>
            </section>
        </div>
    </div><!-- #sidebar -->
--}}


<div id="sidebar" class="site-sidebar col-md-3">
    <div id="form-border" class="comment-respond form-border" style="background : #fff">
        <section id="section-categories" class="section">
            <h2 class="section-title h4 clearfix">
                <i class="line"></i> Informasi
            </h2>
            <div>
                <p>Silahkan untuk menginputkan formulir sesuai dengan topik permohonan/permintaan Anda. Untuk melihat informasi dan penjelasan masing-masing layanan silahkan membuka halaman <a href="{{url('/knowledgebase')}}">Basis Pengetahuan</a>. Terima kasih.</p>
            </div>

        </section>

        <section id="section-categories" class="section">

            <h2 class="section-title h4 clearfix">

                <b>   <i class="line" style="border-color: rgb(0, 154, 186);"></i>{!! Lang::get('lang.categories') !!}</b>
                <small class="float-right"><i class="far fa-hdd fa-fw"></i></small>
            </h2>

            <ul class="nav nav-pills nav-stacked nav-categories">

                @foreach($categorys as $category)
                <?php
                $num = \App\Model\kb\Relationship::where('category_id','=', $category->id)->get();
                $article_id = $num->pluck('article_id');
                $numcount = count($article_id);
                ?>

                <li class="d-flex justify-content-between align-items-center">

                    <a href="{{url('category-list/'.$category->slug)}}" class="list-group-item list-group-item-action" style="padding: 5px;">

                        <span class="badge badge-pill float-right" style="margin-top: 2px;">{{$numcount}}</span>

                        {{$category->name}}
                    </a>
                </li>
                    @endforeach
            </ul>
        </section>
    </div>
</div><!-- #sidebar -->

@stop
<!-- content -->
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            font-size: 15px;
        }
        .select2-container .select2-selection--single {
            height: 36px !important;
        }
        span.selection {
            width: 100%;
        }
    </style>
    
    <div id="content" class="site-content col-md-9">

        @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <i class="fas  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('message') !!}
        </div>
        @endif
        @if (count($errors) > 0)
        @if(Session::has('check'))
        <?php goto a; ?>
        @endif
        @if(!Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fas fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <?php a: ?>
        @endif

        <?php
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        ?>
        <input id="token" type="hidden" value="{{$encrypted_token}}">
        {!! Form::open(['route'=>'client.form.post','method'=>'post', 'enctype'=>'multipart/form-data']) !!}

        <article class="hentry">

            <div id="form-border" class="comment-respond form-border" style="background : #fff">

                <section id="section-categories">

                    <h2 class="section-title h4 clearfix mb-0">

                        <i class="line" style="border-color: rgb(0, 154, 186);"></i>{!! Lang::get('lang.submit_a_ticket') !!}
                    </h2>

                    <div class="row mt-4">

                        @if(Auth::user())

                        {!! Form::hidden('Name',Auth::user()->user_name,['class' => 'form-control']) !!}

                        @else

                        <div class="col-md-12 form-group {{ $errors->has('Name') ? 'has-error' : '' }}">
                            {!! Form::label('Name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>
                            {!! Form::text('Name',null,['class' => 'form-control']) !!}
                        </div>
                        @endif

                        @if(Auth::user())

                        {!! Form::hidden('Email',Auth::user()->email,['class' => 'form-control']) !!}

                        @else
                        <div class="col-md-12 form-group {{ $errors->has('Email') ? 'has-error' : '' }}">
                            {!! Form::label('Email',Lang::get('lang.email')) !!}
                            @if($email_mandatory->status == 1 || $email_mandatory->status == '1')
                                <span class="text-red">*</span>
                            @endif
                            {!! Form::email('Email',null,['class' => 'form-control']) !!}
                        </div>
                        @endif

                        {!! Form::hidden('Code','62',['class' => 'form-control']) !!}
                        <div class="col-md-5 form-group {{ $errors->has('Phone') ? 'has-error' : '' }}">
                            {!! Form::label('Phone',Lang::get('lang.phone')) !!} <span class="text-red"> *</span>
                            {!! Form::text('Phone',null,['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        
                        <div class="col-md-12 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
                            {!! Form::label('help_topic', Lang::get('lang.choose_a_help_topic')) !!}
                            {!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
                            <p><b>{{ $topicnya->topic }}</b></p>
                            <?php
                            $forms = App\Model\helpdesk\Form\Forms::get();
//                            ?><!---->

                            {!! Form::hidden('helptopic',$topicnya->id,['class' => 'form-control']) !!}
                        </div>
                        <!-- priority -->
                         <?php
                         $Priority = App\Model\helpdesk\Settings\CommonSettings::select('status')->where('option_name','=', 'user_priority')->first();
                         $user_Priority=$Priority->status;
                        ?>

                         @if(Auth::user())

                         @if(Auth::user()->active == 1)
                        @if($user_Priority == 1)

                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-md-1">
                                    <label>{!! Lang::get('lang.priority') !!}:</label>
                                </div>
                                <div class="col-md-12">
                                    <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                                    {!! Form::select('priority', ['Priority'=>$Priority->pluck('priority_desc','priority_id')->toArray()],null,['class' => 'form-control select']) !!}
                                </div>
                             </div>
                        </div>
                        @endif
                        @endif
                        @endif
                        <!-- kategori pemohon -->
                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Kategori Pemohon<span class="text-red"> *</span>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    // $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                                    ?><!---->
                                    <select autocomplete="off" name="pemohonnya" class="form-control select2" id="pemohonnya" required>
                                        <option value="" selected>- Pilih -</option>
                                        <option value="1">Internal</option>
                                        <option value="2">Eksternal</option>
                                    </select>
                                </div>
                             </div>
                        </div>
                        <!-- --------------- -->
                        
                        <!-- kategori pemohon internal -->
                        <div id="internal" class="col-md-12 form-group" style="display: none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Kategori Internal<span class="text-red"> *</span>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    // $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                                    ?><!---->
                                    <select autocomplete="off" name="kat_pemohon" class="form-control select2" id="inputinternal">
                                        <option value="" selected>- Pilih Perangkat Daerah -</option>
                                        @foreach($opd['entry'] as $opdnya)
                                        <option value="{{ $opdnya['id'] }}">{{ $opdnya['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                             </div>
                        </div>
                        <!-- --------------- -->
                        
                        <!-- kategori pemohon eksternal -->
                        <div id="eksternal" class="col-md-12 form-group" style="display: none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Kategori Eksternal<span class="text-red"> *</span>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    // $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                                    ?><!---->
                                    <input type="hidden" value="99" name="kat_pemohon" id="inputeksternal">
                                    <input type="text" class="form-control" name="kat_eksternal" placeholder="Ketik Nama Instansi atau asal Pemohon">
                                </div>
                             </div>
                        </div>
                        <!-- --------------- -->
                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12 form-group {{ $errors->has('Subject') ? 'has-error' : '' }}">
                            {!! Form::label('Subject',Lang::get('lang.subject')) !!}<span class="text-red"> *</span>
                            {!! Form::text('Subject',null,['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-12 form-group {{ $errors->has('Details') ? 'has-error' : '' }}">
                            {!! Form::label('Details',Lang::get('lang.message')) !!}<span class="text-red"> *</span>
                            {!! Form::textarea('Details',null,['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="file" name="attachment[]" multiple/><br/>
                            {!! Lang::get('lang.max') !!}. {!! $max_size_in_actual !!}
                            <br><small>Mohon berkas-berkas yang akan diupload dijadikan menjadi satu file</small>
                        </div>
        

                        {{-- Event fire --}}
                        <?php \Illuminate\Support\Facades\Event::dispatch(new App\Events\ClientTicketForm()); ?>
                        
                        <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
                        <div class="col-md-12 form-group">
                            {!! Form::button('<i class="fas fa-save"></i> ' . Lang::get('lang.submit'), ['type'=>'submit', 'class'=>'btn btn-info float-right', 'style'=>'background-color: #337ab7 !important; border-color: #337ab7 !important; color: white;', 'onclick' => 'this.disabled=true;this.innerHTML="Sending, please wait...";this.form.submit();', 'data-v-fce8d630']) !!}
                        </div>

                    {!! Form::close() !!}
                    </div>
                </section>    
            </div>
        </article>
    </div>
<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.select2').select2({
        width: '100%'
    });
    
    $('select[id="pemohonnya"]').on('change',function(){
        jenis = $(this).val();
        
        if(jenis==1) { 
            $('#internal').show();
            $('#eksternal').hide();
            $("#inputeksternal").prop('disabled', true);
            $("#inputinternal").prop('disabled', false);
            
        } else {
            $('#eksternal').show();
            $('#internal').hide();
            $("#inputinternal").prop('disabled', true);
            $("#inputeksternal").prop('disabled', false);
        }
    });
    
    // ----------------------------
    
   /*
   var helpTopic = $("#selectid").val();
   send(helpTopic);
   $("#selectid").on("change",function(){
       helpTopic = $("#selectid").val();
       send(helpTopic);
   });
   function send(helpTopic){
       $.ajax({
           url:"{{url('/get-helptopic-form')}}",
           data:{'helptopic':helpTopic},
           type:"GET",
           dataType:"html",
           success:function(response){
               $("#response").html(response);
           },
           error:function(response){
              $("#response").html(response); 
           }
       });
   }
   */
});

$(function() {
//Add text editor
    $("textarea").summernote({
        height: 300,
        tabsize: 2,
        toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ]
      });
});
</script>
@stop