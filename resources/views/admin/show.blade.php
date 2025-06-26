@extends('admin::admin.layouts.master')

@section('title', 'Banners Management')

@section('page-title', 'Banner Details')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.banners.index') }}">Manage Banners</a></li>
    <li class="breadcrumb-item active" aria-current="page">Banner Details</li>
@endsection

@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Banner Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">                    
                    <div class="table-responsive">
                         <div class="card-body">      
                            <table class="table table-bordered table-responsive-lg">                            
                                <tbody>
                                    <tr>
                                        <th scope="row">Title</th>
                                        <td scope="col">{{ $banner->title ?? 'N/A' }}</td>                                   
                                    </tr>
                                    <tr>
                                        <th scope="row">Sub Title</th>
                                        <td scope="col">{{ $banner->sub_title ?? 'N/A' }}</td>                                   
                                    </tr>
                                    <tr>
                                        <th scope="row">Button Title</th>
                                        <td scope="col">{{ $banner->button_title ?? 'N/A' }}</td>                                   
                                    </tr>
                                    <tr>
                                        <th scope="row">Button URL</th>
                                        <td scope="col">{{ $banner->button_url ?? 'N/A' }}</td>                                   
                                    </tr>
                                    <tr>
                                        <th scope="row">Image</th>
                                        <td scope="col">
                                            @if ($banner->image)
                                                <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}" class="img-fluid" style="max-width: 200px; max-height: 120px;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Description</th>
                                        <td scope="col">{!! $banner->description ?? 'N/A' !!}</td>                                   
                                    </tr>
                                    <tr>
                                        <th scope="row">Created At</th>
                                        <td scope="col">{{ $banner->created_at ?? 'N/A' }}</td>                                   
                                    </tr>
                                </tbody>
                            </table>   
                                             
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Back</a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End banner Content -->
    </div>
    <!-- End Container fluid  -->
@endsection
