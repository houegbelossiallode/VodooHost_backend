@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Points forts</span></div>
                @include('partials/hearder2')
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="custom-form">
                    <div class="row">
                        <div class="dasboard-widget-title fl-wrap"
                            style="display:flex;justify-content:space-between;align-items:center;">
                            <h5>Liste des points forts</h5>
                            {{-- <a href="" class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i> Ajouter un point fort
                            </a> --}}
                            <button type="button"
                                    id="vh-open-point-modal"
                                    class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i> Ajouter un point fort
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Libellé</th>
                                    <th style="text-align:left; width:200px;">Date de création</th>
                                    <th style="width:200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($points as $index => $point)
                                    <tr>
                                        <td style="text-align:left; width:200px;">{{ Str::limit($point->titre,150) }}</td>
                                        <td style="text-align:left; width:200px;">
                                            {{ $point->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    {{-- <a href="{{ route('hoost.points.edit',$point->id) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a> --}}

                                                    <a href="#"
                                                        class="vh-edit-point vh-action-item"
                                                        data-id="{{ $point->id}}"
                                                        data-libelle="{{ $point->titre}}">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>

                                                    <form
                                                        action="{{ route('hoost.points.destroy',$point->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de cet équipement ?');">
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
                                        <td colspan="4" class="text-center">Aucun point fort enregistré pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    
                </div>
            </div>
        </div>
        <!-- Dashboard container end -->
    </div>
    <!-- content end -->



{{-- Modal Création / Modification d’un point fort --}}
<div id="vh-point-modal" class="vh-fav-modal">
    <div class="vh-fav-overlay"></div>

    <div class="vh-fav-dialog">
        <div class="vh-fav-header color-bg">
            <span id="vhPointModalTitle">Ajouter un point fort</span>
            <button type="button" class="vh-fav-close">
                <i class="fal fa-times"></i>
            </button>
        </div>

        <div class="vh-fav-body">
            <form id="vhPointForm" method="POST" class="vh-fav-form">
                @csrf
                <input type="hidden" name="_method" id="vhPointMethod" value="POST">

                <label class="vh-fav-label">Libellé du point fort</label>
                <input type="text"
                       name="libelle"
                       id="vhPointLibelle"
                       maxlength="100"
                       class="vh-fav-input"
                       placeholder="Ex : Très lumineux"
                       required>

                <button type="submit" class="vh-fav-btn-main color-bg" id="vhPointSubmitBtn">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>


<style>

.vh-fav-modal {
    position: fixed;
    inset: 0;
    display: none;
    z-index: 9999;
}

.vh-fav-modal.vh-fav-open {
    display: block;
}

.vh-fav-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
}

.vh-fav-dialog {
    position: relative;
    max-width: 480px;
    margin: 80px auto;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.vh-fav-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 18px;
    color: #fff;
}

.vh-fav-close {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}

.vh-fav-body {
    padding: 18px;
}

.vh-fav-label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

.vh-fav-input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 4px;
    border: 1px solid #e0e0e0;
    margin-bottom: 12px;
}

.vh-fav-btn-main {
    display: inline-block;
    border: none;
    padding: 10px 18px;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal        = document.getElementById('vh-point-modal');
    const overlay      = modal.querySelector('.vh-fav-overlay');
    const closeBtn     = modal.querySelector('.vh-fav-close');
    const openBtn      = document.getElementById('vh-open-point-modal');

    const form         = document.getElementById('vhPointForm');
    const methodInput  = document.getElementById('vhPointMethod');
    const title        = document.getElementById('vhPointModalTitle');
    const libelleInput = document.getElementById('vhPointLibelle');
    const submitBtn    = document.getElementById('vhPointSubmitBtn');

    function openModal() {
        modal.classList.add('vh-fav-open');
    }

    function closeModal() {
        modal.classList.remove('vh-fav-open');
    }

    // 👉 Mode AJOUTER
    openBtn.addEventListener('click', function () {
        form.action = "{{ route('hoost.points.store') }}";   // route POST
        methodInput.value = "POST";
        title.textContent = "Ajouter un point fort";
        libelleInput.value = "";
        submitBtn.textContent = "Enregistrer";

        openModal();
    });

    // 👉 Mode MODIFIER
    document.querySelectorAll('.vh-edit-point').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const id      = btn.dataset.id;
            const libelle = btn.dataset.libelle;

            form.action = "/hoost/points/" + id;   // route update
            methodInput.value = "PUT";

            title.textContent = "Modifier le point fort";
            libelleInput.value = libelle;
            submitBtn.textContent = "Mettre à jour";

            openModal();
        });
    });

    // 👉 Fermer modal
    overlay.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
});
</script>



{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn   = document.getElementById('vh-open-point-modal');
        const modal     = document.getElementById('vh-point-modal');
        if (!openBtn || !modal) return;

        const overlay   = modal.querySelector('.vh-fav-overlay');
        const closeBtn  = modal.querySelector('.vh-fav-close');

        function openModal() {
            modal.classList.add('vh-fav-open');
        }

        function closeModal() {
            modal.classList.remove('vh-fav-open');
        }

        openBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });

        closeBtn.addEventListener('click', function () {
            closeModal();
        });

        overlay.addEventListener('click', function () {
            closeModal();
        });

        // Optionnel : fermer avec ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    });
</script> --}}


@endsection
