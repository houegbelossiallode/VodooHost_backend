@extends('layouts.app')
@section('section')
<div class="page-heading d-flex justify-content-between align-items-center">
  <h1 class="page-title">Liste partagée : {{ $list->libelle }}</h1>
  <a href="{{ url()->current() }}" class="btn btn-light btn-sm"
     onclick="navigator.clipboard.writeText(this.href);return false;">
     Copier le lien
  </a>
</div>

@if($list->items->count())
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
    @foreach($list->items as $it)
      @php $l = $it->logement; @endphp
      <div class="col">
        <div class="card h-100">
            {{-- @if($l->photos->count())
                <img src="{{ asset('storage/' . $l->photos->first()->chemin) }}"
                     class="card-img-top" alt="Photo de {{ $l->titre }}">
            @endif --}}
          <div class="card-body py-2">
            <div class="fw-semibold text-truncate">{{ $l->titre }}</div>
            <div class="small text-muted">{{ $l->ville }}</div>
            @isset($l->prix_par_nuit)
              <div class="small">{{ number_format($l->prix_par_nuit, 0, ',', ' ') }} FCFA / nuit</div>
            @endisset
          </div>
        </div>
      </div>
    @endforeach
  </div>
@else
  <p class="text-muted">Cette liste est vide.</p>
@endif
@endsection
