@extends('layouts.app')
@section('content')
    <!-- Navbar -->
    @include('spa_framgment_template.top_bar')
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('spa_framgment_template.sider_bar')
    <!-- /.Main Sidebar Container -->
    <!-- Content Wrapper. Contains page content -->
    @include('spa_framgment_template.contentido')
    <!-- Footer -->
    @include('spa_framgment_template.footer')
@endsection