@extends('layouts.master')


@section('css')

@endsection

@section('title')
    @lang('secteurs.add secteur')
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">@lang('sidebar.secteurs')</h4>
                <span class="text-muted mt-1 tx-14 mr-2 mb-0">
                    /  @lang('secteurs.add secteur') 
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@include('parametres.partials_1.create')