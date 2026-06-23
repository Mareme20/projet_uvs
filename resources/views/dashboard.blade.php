@extends('layouts.bootstrap')

@section('page_title', 'Bienvenue')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5 text-center">
                <i class="fas fa-clinic-medical fa-4x text-primary mb-4"></i>
                <h2 class="fw-bold mb-3">Bienvenue sur la plateforme de la Clinique IIBS</h2>
                <p class="lead text-muted mb-4">Vous êtes connecté en tant que <strong>{{ Auth::user()->name }}</strong>.</p>
                <p>Utilisez le menu latéral pour accéder aux fonctionnalités liées à votre rôle ({{ Auth::user()->getRoleNames()->first() }}).</p>
            </div>
        </div>
    </div>
</div>
@endsection
