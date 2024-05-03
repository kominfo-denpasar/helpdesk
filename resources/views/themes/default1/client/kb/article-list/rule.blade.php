@extends('themes.default1.client.layout.client')

@section('title')
  @if (isset($category->name))
    {!! $category->name !!} -
  @endif
@stop

@section('kb')
  class = "nav-item active"
@stop

@section('breadcrumb')

  <?php
  //dd($arti);
  $all = App\Model\kb\Relationship::where('article_id', '=', $arti->id)->get();
  //dd($all);
  /* from whole attribute pick the article_id */
  $category_id = $all->pluck('category_id')->toArray();
  ?>
@section('breadcrumb')
  {{-- <div class="site-hero clearfix"> --}}
  <ol class="breadcrumb float-sm-right ">
    <style>
      .words {
        margin-right: 10px;
        /* Adjust the value to increase or decrease the gap between list items */
      }
    </style>
    <li class="breadcrumb-item"> <i class="fas fa-home"> </i> {!! Lang::get('lang.you_are_here') !!} : &nbsp;</li>
    <?php $category = App\Model\kb\Category::where('id', $category_id)->first(); ?>
    <li><a class="words" href="{!! URL::route('home') !!}">{!! Lang::get('lang.knowledge_base') !!}</a></li>
    <li class="words">></li>

    <li><a class="words" href="{{ url('article-list') }}">{!! Lang::get('lang.article_list') !!}</a></li>
    <li class="words">></li>
    <li><a class="words" href="{{ url('category-list/' . $category->slug) }}">{{ $category->name }}</a></li>
    <li class="words"> > </li>
    <li class="active">{{ $arti->name }}</li>
  </ol>
@stop
@section('title')
  {!! $arti->name !!} -
@stop
@section('content')

  <div id="content" class="site-content col-md-9">

    <article class="hentry">

      <header class="entry-header">

        <h1 class="entry-title">Syarat & Ketentuan {{ $arti->name }}</h1>

        <div class="entry-meta text-muted">

          <!-- <span class="date">
                      <i class="far fa-clock fa-fw"></i>
                      <time datetime="2013-09-19T20:01:58+00:00">{{ $arti->created_at->format('l, d-m-Y') }}</time>
                  </span> -->

          <span class="category">
            <i class="fas fa-folder-open fa-fw"></i>
            <a href="{{ url('category-list/' . $category->slug) }}">{{ $category->name }}</a>
          </span>
        </div><!-- .entry-meta -->
      </header><!-- .entry-header -->

      <div class="entry-content clearfix">
        <blockquote class="blockquote archive-description" id="block" style="margin-bottom: 10px; margin-top: 10px;">
          <small>
            <a class="btn btn-sm btn-warning" href="{{ url('article-list') }}"><i class="fa fa-angle-double-left"></i>
              &nbsp;{!! Lang::get('lang.back') !!}</a>
            <a class="btn btn-sm btn-primary" href="{{ url('show/' . $arti->slug) }}"><i class="fa fa-info-circle"></i>
              &nbsp;{!! Lang::get('lang.read_more') !!}</a>
            @if ($arti->link_form != null)
              <a class="btn btn-sm btn-danger" target="_BLANK" href="{{ $arti->link_form }}"><i class="fa fa-link"></i>
                &nbsp;{!! Lang::get('lang.link_form') !!}</a>
            @endif
            <a class="btn btn-sm btn-info" href="{{ url('create-ticket/' . $arti->slug) }}"><i class="fa fa-file"></i>
              &nbsp;{!! Lang::get('lang.submit_a_ticket') !!}</a>
          </small>
        </blockquote>

        <p>{!! $arti->rules !!}</p>

      </div><!-- .entry-content -->

    </article><!-- .hentry -->

    <?php
    use Illuminate\Support\Facades\Auth;
    
    $comments = App\Model\kb\Comment::where('article_id', $arti->id)
        ->where('status', '1')
        ->orWhere(function ($query) {
            $query->where('article_id', Auth::id()); // Add this line to include the authenticated user's comment
        })
        ->get();
    
    ?>

  </div>

@stop
@section('category')
  <div id="sidebar" class="site-sidebar col-md-3">

    <div class="col-sm-12">

      <div class="widget-area">

        <section id="section-categories" class="section">

          <h2 class="section-title h4 clearfix">

            <b> <i class="line" style="border-color: rgb(0, 154, 186);"></i>{!! Lang::get('lang.categories') !!}</b>

            <small class="float-right"><i class="far fa-hdd fa-fw"></i></small>
          </h2>

          <ul class="nav nav-pills nav-stacked nav-categories">

            <?php $categorys = App\Model\kb\Category::all(); ?>
            @foreach ($categorys as $category)
              <?php
              $num = \App\Model\kb\Relationship::where('category_id', '=', $category->id)->get();
              $article_id = $num->pluck('article_id');
              $numcount = count($article_id);
              ?>

              <li class="d-flex justify-content-between align-items-center">

                <a href="{{ url('category-list/' . $category->slug) }}" class="list-group-item list-group-item-action"
                  style="padding: 5px;">
                  <span class="badge badge-pill float-right"
                    style="margin-top: 2px;">{{ $numcount }}</span>{{ $category->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </section>
      </div>
    </div>
  </div>
@stop
