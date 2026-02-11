<div class="dashboard-list-box fl-wrap" style="margin-top:20px;">
    <div class="dashboard-message color-bg">
        <i class="fas fa-magic"></i>
        <p>
            Personnalisez votre <strong>expérience culturelle</strong> pour recevoir des recommandations
            de logements et rituels adaptés à vos envies.
        </p>
    </div>

    <form action="" method="POST" class="custom-form">
        @csrf

        <div class="listsearch-input-wrap fl-wrap">
            <div class="listsearch-input-item">
                <label>Quelle divinité souhaitez-vous découvrir ?</label>
                <div class="divinite-pills-wrap">
                    @php
                        $divinites = [
                            ['key' => 'sakpata', 'label' => 'Sakpata', 'icon' => 'fas fa-seedling'],
                            ['key' => 'mamiwata', 'label' => 'Mamiwata', 'icon' => 'fas fa-water'],
                            ['key' => 'legba', 'label' => 'Legba', 'icon' => 'fas fa-road'],
                        ];
                    @endphp

                    @foreach($divinites as $d)
                        <div class="divinite-pill">
                            <input type="checkbox"
                                   name="divinites[]"
                                   id="divinite_{{ $d['key'] }}"
                                   value="{{ $d['key'] }}">
                            <label for="divinite_{{ $d['key'] }}">
                                <i class="{{ $d['icon'] }}"></i>
                                <span>{{ $d['label'] }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="listsearch-input-item">
                <label>Souhaitez-vous assister à un rituel en direct ?</label>
                <div class="live-toggle-wrap">
                    <label class="radio-pill">
                        <input type="radio" name="want_live_ritual" value="1">
                        <span>Oui</span>
                    </label>
                    <label class="radio-pill">
                        <input type="radio" name="want_live_ritual" value="0" checked>
                        <span>Non</span>
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn color-bg float-btn">
            Enregistrer mes préférences
        </button>

        <a href="" class="btn btn-secondary" style="margin-left:10px;">
            Modifier plus tard
        </a>
    </form>
</div>


<style>

.divinite-pills-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    margin-top: 0.5rem;
}

.divinite-pill {
    border-radius: 999px;
    border: 1px solid #e1e8ed;
    background: #ffffff;
    padding: 6px 14px;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(15, 34, 58, 0.03);
    position: relative;
}

.divinite-pill input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.divinite-pill label {
    margin: 0;
    display: inline-flex;
    align-items: center;
    font-size: 0.92rem;
    font-weight: 500;
    color: #344357;
    cursor: pointer;
}

.divinite-pill i {
    margin-right: 0.4rem;
    font-size: 0.95rem;
    color: var(--primary);
}

.divinite-pill:hover {
    border-color: var(--primary);
    box-shadow: 0 4px 10px rgba(15, 34, 58, 0.08);
}

.divinite-pill input:checked + label {
    color: #fff;
}

.divinite-pill input:checked + label i {
    color: #fff;
}

.divinite-pill input:checked + label::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 999px;
    background: var(--primary);
    z-index: -1;
}

/* Radios "Oui / Non" */
.live-toggle-wrap {
    display: flex;
    gap: 0.6rem;
    margin-top: 0.5rem;
}

.radio-pill {
    position: relative;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
}

.radio-pill input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.radio-pill span {
    border-radius: 999px;
    border: 1px solid #e1e8ed;
    padding: 6px 14px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #344357;
    background: #fff;
    transition: all 0.2s ease;
}

.radio-pill input:checked + span {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
}

</style>