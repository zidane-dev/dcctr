@extends('layouts.master')

@section('css')

@endsection

@section('title')
    @lang('qualites.edit qualite')
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    @lang('sidebar.qualites')
                </h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    / @lang('qualites.edit qualite') 
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@include('parametres.partials_1.edit')