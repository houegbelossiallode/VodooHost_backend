{{-- @extends('layouts.app')
@section('section')
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Menu</div>
    <div class="container dasboard-container">
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item">Mes signalements</div>
            @include('partials.hearder2')
        </div>

        <div class="dashboard-list-box fl-wrap">
            <div class="dasboard-widget-title fl-wrap">
                <h5><i class="fas fa-flag"></i> Historique des signalements</h5>
                <a href="{{ route('hoost.reports.create') }}" class="btn color-bg">
                    <i class="fas fa-plus"></i> Nouveau signalement
                </a>
            </div>

            @if($reports->isEmpty())
                <div class="dashboard-list-null">
                    <i class="far fa-flag"></i>
                    <h4>Aucun signalement</h4>
                    <p>Vous n'avez soumis aucun signalement pour le moment.</p>
                    <a href="{{ route('hoost.reports.create') }}" class="btn color-bg">Faire un signalement</a>
                </div>
            @else
                <div class="dashboard-list">
                    @foreach($reports as $report)
                        <div class="dashboard-message">
                            <div class="dashboard-message-avatar">
                                <i class="fas fa-flag"></i>
                            </div>
                            <div class="dashboard-message-text">
                                
                                <p>{{ $report->message}}</p>
                                <div class="dashboard-message-time">
                                    <i class="far fa-calendar-alt"></i> 
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                    @if($report->logement)
                                        <span class="ml-3">
                                            <i class="fas fa-home"></i> 
                                            {{ $report->logement->titre }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                
            @endif
        </div>
    </div>
</div>


<style>
    .dashboard-message {
        display: flex;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .dashboard-message-avatar {
        width: 50px;
        height: 50px;
        background: #f5f5f5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 20px;
        color: #4e66f8;
    }
    
    .dashboard-message-text {
        flex: 1;
    }
    
    .dashboard-message-text h4 {
        margin: 0 0 5px 0;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .dashboard-message-text p {
        margin: 0 0 10px 0;
        color: #666;
    }
    
    .dashboard-message-time {
        font-size: 12px;
        color: #999;
    }
    
    .badge {
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-warning { background: #ffc107; color: #000; }
    .badge-info { background: #17a2b8; color: #fff; }
    .badge-success { background: #28a745; color: #fff; }
    .badge-danger { background: #dc3545; color: #fff; }
    
    .dashboard-list-null {
        text-align: center;
        padding: 40px 20px;
    }
    
    .dashboard-list-null i {
        font-size: 50px;
        color: #ddd;
        margin-bottom: 15px;
    }
    
    .dashboard-list-null h4 {
        margin: 0 0 10px 0;
        font-size: 18px;
    }
    
    .dashboard-list-null p {
        color: #777;
        margin-bottom: 20px;
    }
</style>
@endsection --}}



@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Mes problèmes</span></div>
                 @include('partials/hearder2')
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="custom-form">
                    <div class="row">
                        <div class="dasboard-widget-title fl-wrap"
                            style="display:flex;justify-content:space-between;align-items:center;">
                            <h5>Liste de mes problèmes</h5>
                            <a href="{{ route('hoost.reports.create') }}" class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i>Nouveau problème
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Type</th>
                                    <th style="text-align:left; width:200px;">Message</th>
                                    <th style="text-align:left; width:200px;">Lien de l'annonce</th>
                                    <th style="width:200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $index => $report)
                                    <tr>
                                        <td style="text-align:left; width:200px;">{{ $report->type ?? 'AUCUN'}}</td>
                                        <td style="text-align:left; width:200px;">{{ Str::limit($report->message,90) }}</td>
                                        <td style="text-align:left; width:200px;">{{ Str::limit($report->annonce_url,40 ?? 'AUCUN') }}</td>
                                        {{-- <td style="text-align:left; width:200px;">
                                            {{ $report->created_at->format('d/m/Y H:i') }}</td> --}}
                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.reports.edit',$report) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>
                                                    {{-- <a href="{{ route('hoost.reports.show',$report) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-eye me-2"></i>Voir plus
                                                    </a> --}}
                                                    <button type="button"
                                                        class="vh-action-item report-open"
                                                        data-report-id="{{ $report->id }}"
                                                        data-type="{{ $report->type }}"
                                                        data-message="{{ $report->message }}"
                                                        data-annonce-url="{{ $report->annonce_url }}"
                                                        data-created-at="{{ optional($report->created_at)->format('d/m/Y H:i') }}"
                                                    >
                                                        <i class="fa fa-eye me-2"></i>Voir plus
                                                    </button>

                                                    <form
                                                        action="{{ route('hoost.reports.destroy',$report) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de ce problème ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="vh-action-item vh-action-danger">
                                                            <i class="fa fa-trash me-2"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Aucun problème enregistré pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




<div id="vh-fav-modal" class="vh-fav-modal">
  <div class="vh-fav-overlay"></div>

  <div class="vh-fav-dialog">
    <div class="vh-fav-header color-bg">
      <span>Détails du problème</span>
      <button type="button" class="vh-fav-close"><i class="fal fa-times"></i></button>
    </div>

     <div class="vh-fav-body">
    <div class="vh-report-grid">
        <div class="vh-row">
            <div class="vh-label">Type</div>
            <div class="vh-value"><span class="vh-chip" id="vhReportType">-</span></div>
        </div>

        <div class="vh-row">
            <div class="vh-label">Date</div>
            <div class="vh-value" id="vhReportCreatedAt">-</div>
        </div>

        <div class="vh-row">
            <div class="vh-label">Lien annonce</div>
            <div class="vh-value">
                <a href="#" target="_blank" id="vhReportUrl" class="vh-link">-</a>
            </div>
        </div>
    </div>

    <div class="vh-section-title">Message</div>
    <div class="vh-message-box" id="vhReportMessage">-</div>
</div>

    
  </div>
</div>



<style>

/* ===== MODAL CONTAINER ===== */
.vh-fav-modal {
    position: fixed;              /* ← clé */
    inset: 0;                      /* top:0 right:0 bottom:0 left:0 */
    z-index: 9999;
    display: none;                 /* caché par défaut */
}

/* visible */
.vh-fav-modal.vh-open {
    display: flex;
    align-items: center;           /* centre vertical */
    justify-content: center;       /* centre horizontal */
}

/* ===== OVERLAY ===== */
.vh-fav-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(2px);
}

/* ===== DIALOG ===== */
.vh-fav-dialog {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 520px;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,.35);
    animation: vhZoom .25s ease;
}


.vh-fav-header{
    display:flex;
    justify-content: space-between;
    align-items:center;
    padding: 12px 16px;
    color:white;
}

.vh-fav-close{
    width: 34px;
    height: 34px;
    border-radius: 10px;
    border: 0;
    background: rgba(255,255,255,.18);
    color: #fff;
    cursor: pointer;
}
.vh-fav-close:hover{
    background: rgba(255,255,255,.28);
}




/* ===== BODY ===== */
.vh-fav-body {
    padding: 18px;
}




/* ===== NO SCROLL PAGE ===== */
.vh-no-scroll {
    overflow: hidden;
}

/* ===== ANIMATION ===== */
@keyframes vhZoom {
    from {
        transform: scale(.92);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}


/* Layout interne */
.vh-report-grid{
    display: grid;
    gap: 10px;
    margin-bottom: 14px;
}

.vh-row{
    display: grid;
    grid-template-columns: 120px 1fr;
    gap: 12px;
    align-items: center;
    padding: 10px 12px;
    border: 1px solid #eee;
    border-radius: 10px;
    background: #fafafa;
}

.vh-label{
    font-weight: 600;
    color: #444;
    font-size: 13px;
}

.vh-value{
    color: #111;
    font-size: 13px;
    line-height: 1.4;
    word-break: break-word;     /* casse les longs mots */
    overflow-wrap: anywhere;    /* casse aussi URLs */
}

.vh-chip{
    display: inline-block;
    padding: 4px 10px;
    border-radius: 999px;
    background: rgba(0,0,0,.06);
    font-weight: 700;
    text-transform: capitalize;
}

.vh-link{
    color: #D1B11B;
    text-decoration: none;
    font-weight: 600;
}
.vh-link:hover{
    text-decoration: underline;
}

/* Message */
.vh-section-title{
    font-weight: 700;
    margin: 8px 0 8px;
    color: #222;
}

.vh-message-box{
    border: 1px solid #eee;
    background: #fff;
    border-radius: 10px;
    padding: 12px;
    max-height: 160px;          /* si long => scroll */
    overflow: auto;
    line-height: 1.5;
    font-size: 13px;

    /* IMPORTANT pour ton cas */
    word-break: break-word;
    overflow-wrap: anywhere;
    white-space: pre-wrap;      /* garde les retours à la ligne */
}



</style>



<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('vh-fav-modal');
  if (!modal) return;

  const overlay  = modal.querySelector('.vh-fav-overlay');
  const closeBtn = modal.querySelector('.vh-fav-close');

  // champs d'affichage
  const elType      = document.getElementById('vhReportType');
  const elMessage   = document.getElementById('vhReportMessage');
  const elUrl       = document.getElementById('vhReportUrl');
  const elCreatedAt = document.getElementById('vhReportCreatedAt');

  function openModalWithReport(data) {
    if (elType)      elType.textContent = data.type || '-';
    if (elMessage)   elMessage.textContent = data.message || '-';
    if (elCreatedAt) elCreatedAt.textContent = data.createdAt || '-';

    if (elUrl) {
      const url = data.annonceUrl || '';
      elUrl.textContent = url ? url : 'Aucun';
      elUrl.href = url ? url : '#';
      elUrl.style.pointerEvents = url ? 'auto' : 'none';
    }

    modal.classList.add('vh-open');
    document.body.classList.add('vh-no-scroll');
  }

  function closeModal() {
    modal.classList.remove('vh-open');
    document.body.classList.remove('vh-no-scroll');
  }

  // Clic "Voir plus"
  document.querySelectorAll('.report-open').forEach(btn => {
    btn.addEventListener('click', function () {
      openModalWithReport({
        id: this.dataset.reportId,
        type: this.dataset.type,
        message: this.dataset.message,
        annonceUrl: this.dataset.annonceUrl,
        createdAt: this.dataset.createdAt,
      });

      // optionnel: fermer le dropdown actions si besoin
      const menu = this.closest('.vh-action-menu');
      if (menu) menu.classList.remove('open');
    });
  });

  if (overlay) overlay.addEventListener('click', closeModal);
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.classList.contains('vh-open')) closeModal();
  });
});
</script>
@endsection



