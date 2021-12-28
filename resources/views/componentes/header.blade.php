<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>ABD SYSTEM</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/moment.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/components.css')}}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link style="background-color:blue;" rel="shortcut icon" href="{{ asset('img/forma_pago.svg') }}">
    <!-- <button onclick="alert(window.innerWidth+','+window.innerHeight)">RESOLUCION</button> -->
</head>

<body>
    <div class="container">
        @extends('layouts.app')

        <!-- <script src="{{asset('js/index.js')}}"></script> -->