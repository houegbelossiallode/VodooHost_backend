<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORMULAIRE D'ADHÉSION TENANT LIEU DE CONTRAT D'ASSURANCE</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .page {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            padding: 5mm 10mm;
            box-sizing: border-box;
            position: relative;
        }
        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
        }
        .logo {
            height: 25px;
        }
        .header-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.1;
            text-align: center;
            color: #0056b3;
        }
        .contract-number {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
            font-size: 14pt;
            padding: 3px 15px;
            margin: 5px 0;
            display: inline-block;
            letter-spacing: 0.5px;
        }
        .subtitle {
            font-size: 8pt;
            margin: 2px 0;
            text-align: center;
        }

        /* Section Styles */
        .section {
            margin-bottom: 8px;
            border: 1px solid #000;
        }
        .section-header {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
            padding: 3px 8px;
            font-size: 9pt;
        }

        /* Form Elements */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 4px;
            padding: 4px 8px;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-right: 15px;
            margin-bottom: 2px;
            white-space: nowrap;
        }
        .form-label {
            margin-right: 5px;
            font-weight: normal;
        }
        .form-value {
            border-bottom: 1px solid #000;
            min-width: 100px;
            display: inline-block;
            height: 16px;
            margin-right: 5px;
        }

        /* Checkbox and Radio Styles */
        .checkbox-group, .radio-group {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        /* Table Styles */
        .value-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 9pt;
        }
        .value-table th, .value-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: left;
        }
        .value-table th {
            background-color: #e6e6e6;
            font-weight: bold;
        }

        /* Special Sections */
        .note {
            font-style: italic;
            font-size: 8pt;
            margin: 3px 0 5px 0;
        }
        .signature-box {
            display: inline-block;
            width: 200px;
            height: 40px;
            border: 1px solid #000;
            margin: 10px 20px 10px 0;
        }
        .copy-info {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 8pt;
            text-align: right;
        }
        }
        .subtitle {
            font-weight: bold;
            font-size: 10pt;
            margin: 5px 0;
        }
        .subtitle-small {
            font-size: 8pt;
            margin: 2px 0;
        }
        .section {
            margin-bottom: 10px;
            border: 1px solid #000;
            page-break-inside: avoid;
        }
        .section-header {
            background-color: #d9d9d9;
            padding: 3px 8px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            display: flex;
            justify-content: space-between;
        }
        .section-header.blue {
            background-color: #0056b3;
            color: white;
            border-bottom: none;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            padding: 3px 8px;
            align-items: baseline;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-right: 15px;
            margin-bottom: 3px;
        }
        .form-label {
            white-space: nowrap;
            margin-right: 5px;
        }
        .form-input {
            border: none;
            border-bottom: 1px solid #000;
            min-width: 100px;
            flex-grow: 1;
            background: transparent;
            padding: 1px 5px;
        }
        .form-input.small {
            min-width: 60px;
            max-width: 80px;
        }
        .form-input.medium {
            min-width: 100px;
            max-width: 150px;
        }
        .form-input.large {
            min-width: 200px;
        }
        .form-input.xlarge {
            min-width: 300px;
        }
        .form-input.xxlarge {
            min-width: 400px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }
        .checkbox-group input[type="checkbox"] {
            margin-right: 5px;
            accent-color: #000;
        }
        .signature-area {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            padding-top: 5px;
        }
        .note {
            font-size: 8pt;
            font-style: italic;
            margin: 3px 0;
        }
        .text-center {
            text-align: center;
        }
        .mt-10 {
            margin-top: 10px;
        }
        .mt-20 {
            margin-top: 20px;
        }
        .mb-5 {
            margin-bottom: 5px;
        }
        .mb-10 {
            margin-bottom: 10px;
        }
        .w-100 {
            width: 100%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 3px 5px;
            font-size: 8pt;
        }
        .table th {
            background-color: #f0f0f0;
            text-align: left;
        }
        .highlight {
            background-color: #ffffcc;
            padding: 0 2px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div>
                <img src="{{ public_path('images/ecobank-logo.png') }}" alt="Ecobank" class="logo">
                <div>La Banque Panafricaine</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 9pt; margin-bottom: 5px;">GENERAL INSURANCE</div>
                <div class="contract-number">ECO-RESIDENCE N° {{ $contractNumber ?? '___________' }}</div>
                <div class="subtitle">(A remplir en MAJUSCULES et à LIRE ATTENTIVEMENT AVANT DE SIGNER)</div>
                <div class="subtitle">(To be filled in BLOCK LETTERS and READ CAREFULLY BEFORE SIGNING)</div>
            </div>
            <div style="text-align: right;">
                <img src="{{ public_path('images/prudential-logo.png') }}" alt="Prudential" class="logo">
            </div>
        </div>

        <div style="text-align: center; margin: 10px 0;">
            <div class="header-title">FORMULAIRE D'ADHÉSION TENANT LIEU DE CONTRAT D'ASSURANCE</div>
            <div style="font-size: 8pt; margin-top: 5px;">(Veuillez compléter le formulaire en lettres majuscules ou en cochant les cases prévues à cet effet)</div>
            <div style="font-size: 8pt;">(Please complete the form in block letters or by ticking the appropriate boxes)</div>
        </div>

        <!-- Section 1: RENSEIGNEMENTS SUR L'ASSURE -->
        <div class="section">
            <div class="section-header blue">1. RENSEIGNEMENTS SUR L'ASSURE</div>
            <div class="form-row">
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Raison sociale / Nom</span>
                    <div class="form-input xlarge">{{ $formData['company_name'] ?? '' }}</div>
                </div>
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Prénom</span>
                    <div class="form-input medium">{{ $formData['first_name'] ?? '' }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Date et lieu de naissance</span>
                    <div class="form-input large">{{ $formData['birth_info'] ?? '' }}</div>
                </div>
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Profession</span>
                    <div class="form-input medium">{{ $formData['profession'] ?? '' }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width: 30%;">
                    <span class="form-label">N° CNI / Passeport</span>
                    <div class="form-input small">{{ $formData['id_number'] ?? '' }}</div>
                </div>
                <div class="form-group" style="width: 30%;">
                    <span class="form-label">N° Contribuable</span>
                    <div class="form-input small">{{ $formData['tax_number'] ?? '' }}</div>
                </div>
                <div class="form-group" style="width: 30%;">
                    <span class="form-label">N° RCCM</span>
                    <div class="form-input small">{{ $formData['rccm'] ?? '' }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width: 100%;">
                    <span class="form-label">Adresse</span>
                    <div class="form-input xxlarge">{{ $formData['address'] ?? '' }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">E-mail</span>
                    <div class="form-input large">{{ $formData['email'] ?? '' }}</div>
                </div>
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Téléphone</span>
                    <div class="form-input medium">{{ $formData['phone'] ?? '' }}</div>
                </div>
            </div>
        </div>

        <!-- Section 2: GARANTIES SOUSCRITES -->
        <div class="section">
            <div class="section-header blue">2. GARANTIES SOUSCRITES</div>
            <div class="form-row">
                <div class="checkbox-group">
                    <input type="checkbox" id="fire" {{ isset($formData['fire']) ? 'checked' : '' }}>
                    <label for="fire">Incendie</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="liability" {{ isset($formData['liability']) ? 'checked' : '' }}>
                    <label for="liability">Responsabilité Civile</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="water_damage" {{ isset($formData['water_damage']) ? 'checked' : '' }}>
                    <label for="water_damage">Dégâts des Eaux</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="glass_breakage" {{ isset($formData['glass_breakage']) ? 'checked' : '' }}>
                    <label for="glass_breakage">Bris de Glaces</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="theft" {{ isset($formData['theft']) ? 'checked' : '' }}>
                    <label for="theft">Vol</label>
                </div>
            </div>
        </div>

        <!-- Section 3: VALEURS D'ASSURANCE -->
        <div class="section">
            <div class="section-header blue">3. VALEURS D'ASSURANCE</div>
            <div class="form-row">
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Valeur du bâtiment (FCFA)</span>
                    <div class="form-input medium highlight">{{ number_format($formData['building_value'] ?? 0, 0, ',', ' ') }}</div>
                </div>
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Valeur du contenu (FCFA)</span>
                    <div class="form-input medium highlight">{{ number_format($formData['content_value'] ?? 0, 0, ',', ' ') }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Type d'habitation</span>
                    <div class="form-group" style="margin: 0;">
                        <input type="radio" id="house" name="dwelling_type" {{ ($formData['dwelling_type'] ?? '') == 'house' ? 'checked' : '' }}>
                        <label for="house">Maison individuelle</label>
                        <input type="radio" id="building" name="dwelling_type" {{ ($formData['dwelling_type'] ?? '') == 'building' ? 'checked' : '' }} style="margin-left: 15px;">
                        <label for="building">Immeuble</label>
                    </div>
                </div>
                <div class="form-group" style="width: 48%;">
                    <span class="form-label">Nombre de niveaux</span>
                    <div class="form-input xsmall">{{ $formData['floors'] ?? '' }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <span class="form-label">Vous êtes</span>
                    <div class="form-group" style="margin: 0;">
                        <input type="radio" id="owner" name="occupant_type" {{ ($formData['occupant_type'] ?? '') == 'owner' ? 'checked' : '' }}>
                        <label for="owner">Propriétaire</label>
                        <input type="radio" id="tenant" name="occupant_type" {{ ($formData['occupant_type'] ?? '') == 'tenant' ? 'checked' : '' }} style="margin-left: 15px;">
                        <label for="tenant">Locataire</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: MODE DE PAIEMENT -->
        <div class="section">
            <div class="section-header blue">4. MODE DE PAIEMENT</div>
            <div class="form-row">
                <div class="form-group">
                    <span class="form-label">Mode de paiement</span>
                    <div class="form-group" style="margin: 0;">
                        <input type="checkbox" id="cash" {{ isset($formData['payment_cash']) ? 'checked' : '' }}>
                        <label for="cash">Espèces</label>
                        <input type="checkbox" id="check" {{ isset($formData['payment_check']) ? 'checked' : '' }} style="margin-left: 15px;">
                        <label for="check">Chèque</label>
                        <input type="checkbox" id="transfer" {{ isset($formData['payment_transfer']) ? 'checked' : '' }} style="margin-left: 15px;">
                        <label for="transfer">Virement</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width: 30%;">
                    <span class="form-label">Date de souscription</span>
                    <div class="form-input small">{{ $formData['subscription_date'] ?? date('d/m/Y') }}</div>
                </div>
                <div class="form-group" style="width: 40%;">
                    <span class="form-label">Prime annuelle (FCFA)</span>
                    <div class="form-input medium highlight">{{ number_format($formData['annual_premium'] ?? 0, 0, ',', ' ') }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width: 100%;">
                    <span class="form-label">Je soussigné(e) autorise ECOBANK à débiter mon compte N°</span>
                    <div class="form-input xlarge" style="display: inline-block; width: 150px;">{{ $formData['account_number'] ?? '' }}</div>
                    <span class="form-label">de la prime d'assurance.</span>
                </div>
            </div>
        </div>

        <!-- Section 5: DÉCLARATIONS -->
        <div class="section">
            <div class="section-header blue">5. DÉCLARATIONS</div>
            <div class="form-row">
                <p>Je soussigné(e) déclare avoir reçu et pris connaissance du contenu des conditions générales et particulières de l'assurance ECO-RESIDENCE.</p>
                <p>J'accepte les conditions de garantie et souscris le présent contrat pour une durée d'un an à compter du <u>{{ $formData['start_date'] ?? date('d/m/Y') }}</u>.</p>
            </div>
        </div>

        <div class="note" style="color: #ff0000; font-weight: bold; margin: 10px 0;">
            <strong>Important :</strong> Le présent formulaire ne peut être valable que s'il est dûment complété, daté et signé.
            ECOBANK n'est pas responsable de la validité des informations fournies par le souscripteur.
        </div>

        <div class="signature-area">
            <div class="signature-box">
                <div>Fait à ........................................</div>
                <div>Le {{ date('d/m/Y') }}</div>
                <div class="signature-line">Signature et cachet du client</div>
            </div>
            <div class="signature-box">
                <div>Pour ECOBANK</div>
                <div>Le ........................................</div>
                <div class="signature-line">Signature et cachet de la banque</div>
            </div>
        </div>

        <div class="text-center mt-20" style="font-weight: bold;">
            <div>BON POUR VISA DE L'ASSUREUR</div>
            <div style="height: 60px; border: 1px solid #000; margin: 5px auto; width: 90%;"></div>
        </div>

        <div class="note text-center" style="margin-top: 10px;">
            <strong>N.B. :</strong> 02 exemplaires à retourner à la banque<br>
            01 exemplaire à conserver par l'Assuré
        </div>
    </div>
        <!-- Section 1: RENSEIGNEMENTS SUR L'ASSURE -->
        <div style="border: 1px solid #000; margin-bottom: 10px;">
            <div style="background-color: #0056b3; color: white; font-weight: bold; padding: 3px 8px;">1. RENSEIGNEMENTS SUR L'ASSURE / INSURED'S PARTICULARS</div>

            <div style="padding: 5px 10px; display: flex; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Nom / Surname</span>
                    <span style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; height: 16px;">{{ $formData['last_name'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Prénom(s) / First Name(s)</span>
                    <span style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; height: 16px;">{{ $formData['first_name'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Date de Naissance / Date of Birth</span>
                    <span style="border-bottom: 1px solid #000; min-width: 80px; display: inline-block; height: 16px; text-align: center;">{{ $formData['birth_date'] ?? '' }}</span>
                </div>
            </div>

            <div style="padding: 5px 10px; display: flex; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">N° CIN / ID Card N°</span>
                    <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; text-align: center;">{{ $formData['id_number'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Délivrée le / Issued on</span>
                    <span style="border-bottom: 1px solid #000; min-width: 70px; display: inline-block; height: 16px; text-align: center;">{{ $formData['id_issue_date'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">A / At</span>
                    <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; text-align: center;">{{ $formData['id_issue_place'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">N° Tél / Phone N°</span>
                    <span style="border-bottom: 1px solid #000; min-width: 80px; display: inline-block; height: 16px; text-align: center;">{{ $formData['phone'] ?? '' }}</span>
                </div>
            </div>

            <div style="padding: 5px 10px; display: flex; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px; width: 100%;">
                    <span style="margin-right: 5px;">Adresse / Address</span>
                    <span style="border-bottom: 1px solid #000; min-width: 400px; display: inline-block; height: 16px; flex-grow: 1;">{{ $formData['address'] ?? '' }}</span>
                </div>
            </div>

            <div style="padding: 5px 10px; display: flex; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Ville / City</span>
                    <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; text-align: center;">{{ $formData['city'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Pays / Country</span>
                    <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; text-align: center;">{{ $formData['country'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Email</span>
                    <span style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; height: 16px; text-align: center;">{{ $formData['email'] ?? '' }}</span>
                </div>
            </div>

            <div style="padding: 5px 10px; display: flex; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Profession / Occupation</span>
                    <span style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; height: 16px; text-align: center;">{{ $formData['occupation'] ?? '' }}</span>
                </div>
                <div style="display: flex; align-items: center; margin-right: 15px; margin-bottom: 5px;">
                    <span style="margin-right: 5px;">Secteur d'activité / Business Sector</span>
                    <span style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; height: 16px; text-align: center;">{{ $formData['business_sector'] ?? '' }}</span>
                </div>
            </div>
        </div>

        <!-- Section 2: GARANTIES ECO-RESIDENCE -->
        <div style="border: 1px solid #000; margin-bottom: 10px;">
            <div style="background-color: #0056b3; color: white; font-weight: bold; padding: 3px 8px;">2. GARANTIES ECO-RESIDENCE / ECO-RESIDENCE COVERAGES</div>

            <div style="padding: 10px;">
                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="fire" style="margin-right: 5px;">
                    <label for="fire">Incendie, Foudre, Explosion / Fire, Lightning, Explosion</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="natural_disaster" style="margin-right: 5px;">
                    <label for="natural_disaster">Catastrophes Naturelles / Natural Disasters</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="terrorism" style="margin-right: 5px;">
                    <label for="terrorism">Actes de Terrorisme / Acts of Terrorism</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="water_damage" style="margin-right: 5px;">
                    <label for="water_damage">Dégâts des Eaux / Water Damage</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="theft" style="margin-right: 5px;">
                    <label for="theft">Vol avec Effraction / Theft with Break-in</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="glass_breakage" style="margin-right: 5px;">
                    <label for="glass_breakage">Risques aux Vitres / Glass Breakage</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="electrical_damage" style="margin-right: 5px;">
                    <label for="electrical_damage">Dommages Électriques / Electrical Damage</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="natural_disaster_extended" style="margin-right: 5px;">
                    <label for="natural_disaster_extended">Catastrophes Naturelles Étendues / Extended Natural Disasters</label>
                </div>

                <div style="margin-bottom: 5px;">
                    <input type="checkbox" id="legal_protection" style="margin-right: 5px;">
                    <label for="legal_protection">Protection Juridique / Legal Protection</label>
                </div>
            </div>
        </div>

        <!-- Section 3: VALEURS / VALUES -->
        <div style="border: 1px solid #000; margin-bottom: 10px;">
            <div style="background-color: #0056b3; color: white; font-weight: bold; padding: 3px 8px;">3. VALEURS / VALUES</div>

            <div style="padding: 10px;">
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <span style="margin-right: 10px;">Valeur du Bâtiment / Building Value</span>
                    <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; text-align: right; padding-right: 5px;">{{ $formData['building_value'] ?? '' }}</span>
                    <span style="margin-left: 5px;">FCFA</span>

                    <span style="margin-left: 20px; margin-right: 10px;">Valeur du Contenu / Contents Value</span>
                    <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; text-align: right; padding-right: 5px;">{{ $formData['content_value'] ?? '' }}</span>
                    <span style="margin-left: 5px;">FCFA</span>
                </div>

                <div style="margin: 10px 0;">
                    <div style="margin-bottom: 5px;">Type de Logement / Type of Dwelling:</div>
                    <div style="margin-left: 20px;">
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="house" name="dwelling_type" value="house" style="margin-right: 5px;">
                            <label for="house">Maison / House</label>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="apartment" name="dwelling_type" value="apartment" style="margin-right: 5px;">
                            <label for="apartment">Appartement / Apartment</label>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="villa" name="dwelling_type" value="villa" style="margin-right: 5px;">
                            <label for="villa">Villa</label>
                        </div>
                    </div>
                </div>

                <div style="margin: 10px 0;">
                    <div style="margin-bottom: 5px;">Occupant / Occupant:</div>
                    <div style="margin-left: 20px;">
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="owner" name="occupant_type" value="owner" style="margin-right: 5px;">
                            <label for="owner">Propriétaire / Owner</label>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="tenant" name="occupant_type" value="tenant" style="margin-right: 5px;">
                            <label for="tenant">Locataire / Tenant</label>
                        </div>
                        <div style="margin-bottom: 3px; display: flex; align-items: center;">
                            <input type="radio" id="other_occupant" name="occupant_type" value="other" style="margin-right: 5px;">
                            <label for="other_occupant" style="margin-right: 5px;">Autre / Other</label>
                            <span style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; height: 16px; margin-left: 5px;"></span>
                        </div>
                    </div>
                </div>

                <div style="background-color: #f5f5f5; padding: 5px; margin: 10px 0; font-size: 8pt; font-style: italic;">
                    <div><strong>N.B.:</strong> En cas de sinistre, l'Assureur ne sera tenu que dans la limite des valeurs déclarées ci-dessus et dans la proportion de ces valeurs par rapport à la valeur réelle des biens assurés au moment du sinistre.</div>
                    <div style="margin-top: 3px;"><strong>N.B.:</strong> In the event of a claim, the Insurer's liability shall be limited to the values declared above and in proportion to the actual value of the insured property at the time of the loss.</div>
                </div>

                <div style="margin: 15px 0 5px 0; font-weight: bold;">A. Contre l'incendie et les risques assimilés / Against Fire and Related Risks</div>

                <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 8pt;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; padding: 3px; background-color: #e6e6e6; text-align: left;">Nature des biens / Nature of Property</th>
                            <th style="border: 1px solid #000; padding: 3px; background-color: #e6e6e6; text-align: center; width: 15%;">% de la valeur du contenu / % of Contents Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">Mobilier, literie, linge de maison, vêtements, vaisselle, appareils électroménagers, etc. / Furniture, bedding, household linen, clothing, crockery, electrical appliances, etc.</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">100%</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">Objets d'art, tableaux, tapis, fourrures, bijoux, or, argent, etc. / Works of art, paintings, carpets, furs, jewelry, gold, silver, etc.</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">20%</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">Collections, timbres, pièces de monnaie, etc. / Collections, stamps, coins, etc.</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">10%</td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin: 15px 0 5px 0; font-weight: bold;">B. Contre le vol avec effraction / Against Theft with Break-in</div>

                <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 8pt;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; padding: 3px; background-color: #e6e6e6; text-align: left;">Nature des biens / Nature of Property</th>
                            <th style="border: 1px solid #000; padding: 3px; background-color: #e6e6e6; text-align: center; width: 15%;">% de la valeur du contenu / % of Contents Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">Mobilier, literie, linge de maison, vêtements, vaisselle, appareils électroménagers, etc. / Furniture, bedding, household linen, clothing, crockery, electrical appliances, etc.</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">30%</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">Objets d'art, tableaux, tapis, fourrures, bijoux, or, argent, etc. / Works of art, paintings, carpets, furs, jewelry, gold, silver, etc.</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">10%</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px;">Collections, timbres, pièces de monnaie, etc. / Collections, stamps, coins, etc.</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">5%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 4: INFORMATIONS COMPLÉMENTAIRES / ADDITIONAL INFORMATION -->
        <div style="border: 1px solid #000; margin-bottom: 10px;">
            <div style="background-color: #0056b3; color: white; font-weight: bold; padding: 3px 8px;">4. INFORMATIONS COMPLÉMENTAIRES / ADDITIONAL INFORMATION</div>

            <div style="padding: 10px;">
                <div style="margin-bottom: 10px;">
                    <div style="margin-bottom: 5px;">Avez-vous déjà souscrit une assurance habitation ? / Have you previously taken out home insurance?</div>
                    <div style="margin-left: 20px;">
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="previous_insurance_yes" name="previous_insurance" value="yes" style="margin-right: 5px;">
                            <label for="previous_insurance_yes">Oui / Yes</label>
                            <span style="margin-left: 20px;">Si oui, précisez l'assureur / If yes, please specify:</span>
                            <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px; margin-left: 5px;"></span>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="previous_insurance_no" name="previous_insurance" value="no" style="margin-right: 5px;">
                            <label for="previous_insurance_no">Non / No</label>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <div style="margin-bottom: 5px;">Avez-vous déjà subi un sinistre au cours des 5 dernières années ? / Have you had any claims in the last 5 years?</div>
                    <div style="margin-left: 20px;">
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="previous_claim_yes" name="previous_claim" value="yes" style="margin-right: 5px;">
                            <label for="previous_claim_yes">Oui / Yes</label>
                            <span style="margin-left: 20px;">Si oui, précisez la nature du sinistre / If yes, please specify the nature of the claim:</span>
                        </div>
                        <div style="margin-left: 25px; margin-bottom: 5px;">
                            <span style="border-bottom: 1px solid #000; min-width: 400px; display: inline-block; height: 16px;"></span>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="radio" id="previous_claim_no" name="previous_claim" value="no" style="margin-right: 5px;">
                            <label for="previous_claim_no">Non / No</label>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <div style="margin-bottom: 5px;">Sécurité du logement / Home security:</div>
                    <div style="margin-left: 20px;">
                        <div style="margin-bottom: 3px;">
                            <input type="checkbox" id="security_alarm" style="margin-right: 5px;">
                            <label for="security_alarm">Système d'alarme / Alarm system</label>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="checkbox" id="security_bars" style="margin-right: 5px;">
                            <label for="security_bars">Barreaux aux fenêtres / Window bars</label>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="checkbox" id="security_door" style="margin-right: 5px;">
                            <label for="security_door">Porte blindée / Security door</label>
                        </div>
                        <div style="margin-bottom: 3px;">
                            <input type="checkbox" id="security_guard" style="margin-right: 5px;">
                            <label for="security_guard">Garde de sécurité / Security guard</label>
                        </div>
                        <div style="margin-bottom: 3px; display: flex; align-items: center;">
                            <input type="checkbox" id="security_other" style="margin-right: 5px;">
                            <label for="security_other" style="margin-right: 5px;">Autre / Other:</label>
                            <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px; margin-left: 5px;"></span>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <div style="margin-bottom: 5px;">Personnes à prévenir en cas d'urgence / Emergency contact person:</div>
                    <div style="display: flex; margin-bottom: 5px;">
                        <div style="margin-right: 15px;">
                            <div>Nom / Name:</div>
                            <div style="border-bottom: 1px solid #000; min-width: 200px; height: 18px;"></div>
                        </div>
                        <div style="margin-right: 15px;">
                            <div>Téléphone / Phone:</div>
                            <div style="border-bottom: 1px solid #000; min-width: 150px; height: 18px;"></div>
                        </div>
                        <div>
                            <div>Lien / Relationship:</div>
                            <div style="border-bottom: 1px solid #000; min-width: 150px; height: 18px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: MODE DE PAIEMENT / PAYMENT METHOD -->
        <div style="border: 1px solid #000; margin-bottom: 10px;">
            <div style="background-color: #0056b3; color: white; font-weight: bold; padding: 3px 8px;">5. MODE DE PAIEMENT / PAYMENT METHOD</div>

            <div style="padding: 10px;">
                <div style="margin-bottom: 10px;">
                    <div style="margin-bottom: 5px;">Je choisis de payer ma prime par / I choose to pay my premium by:</div>
                    <div style="margin-left: 20px;">
                        <div style="margin-bottom: 5px;">
                            <input type="radio" id="payment_full" name="payment_method" value="full" style="margin-right: 5px;">
                            <label for="payment_full">Paiement unique / Single payment</label>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <input type="radio" id="payment_installment" name="payment_method" value="installment" style="margin-right: 5px;">
                            <label for="payment_installment">Paiement échelonné / Installment payment</label>
                            <span style="margin-left: 10px;">(Préciser le nombre de versements / Specify number of installments:
                            <span style="border-bottom: 1px solid #000; min-width: 30px; display: inline-block; height: 16px; text-align: center; margin: 0 5px;"></span> x)</span>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <div style="margin-bottom: 5px;">Mode de paiement / Payment mode:</div>
                    <div style="margin-left: 20px; display: flex; flex-wrap: wrap;">
                        <div style="margin-right: 30px; margin-bottom: 5px;">
                            <input type="radio" id="payment_card" name="payment_type" value="card" style="margin-right: 5px;">
                            <label for="payment_card">Carte bancaire / Credit card</label>
                        </div>
                        <div style="margin-right: 30px; margin-bottom: 5px;">
                            <input type="radio" id="payment_check" name="payment_type" value="check" style="margin-right: 5px;">
                            <label for="payment_check">Chèque / Check</label>
                        </div>
                        <div style="margin-right: 30px; margin-bottom: 5px;">
                            <input type="radio" id="payment_transfer" name="payment_type" value="transfer" style="margin-right: 5px;">
                            <label for="payment_transfer">Virement bancaire / Bank transfer</label>
                        </div>
                        <div style="margin-right: 30px; margin-bottom: 5px;">
                            <input type="radio" id="payment_cash" name="payment_type" value="cash" style="margin-right: 5px;">
                            <label for="payment_cash">Espèces / Cash</label>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <div style="margin-bottom: 5px;">Prélèvement bancaire / Direct debit (si applicable / if applicable):</div>
                    <div style="margin-left: 20px;">
                        <div style="margin-bottom: 5px;">
                            <span style="margin-right: 10px;">N° de compte / Account number:</span>
                            <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px;"></span>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <span style="margin-right: 10px;">Nom de la banque / Bank name:</span>
                            <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px;"></span>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <span style="margin-right: 10px;">Code banque / Bank code:</span>
                            <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px;"></span>
                            <span style="margin-left: 20px; margin-right: 10px;">Code guichet / Branch code:</span>
                            <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px;"></span>
                        </div>
                        <div style="margin-bottom: 5px;">
                            <span style="margin-right: 10px;">Clé RIB / RIB key:</span>
                            <span style="border-bottom: 1px solid #000; min-width: 50px; display: inline-block; height: 16px;"></span>
                        </div>
                    </div>
                </div>

                <div style="background-color: #f5f5f5; padding: 5px; margin: 10px 0; font-size: 8pt; font-style: italic;">
                    <div><strong>N.B.:</strong> Le paiement de la prime est une condition essentielle à la prise d'effet de la garantie. En cas de défaut de paiement, la garantie ne pourra pas être accordée.</div>
                    <div style="margin-top: 3px;"><strong>N.B.:</strong> Payment of the premium is an essential condition for the cover to take effect. In case of non-payment, the cover cannot be granted.</div>
                </div>
            </div>
        </div>

        <!-- Section 6: DÉCLARATION ET ACCEPTATION / DECLARATION AND ACCEPTANCE -->
        <div style="border: 1px solid #000; margin-bottom: 10px;">
            <div style="background-color: #0056b3; color: white; font-weight: bold; padding: 3px 8px;">6. DÉCLARATION ET ACCEPTATION / DECLARATION AND ACCEPTANCE</div>

            <div style="padding: 10px; font-size: 9pt; line-height: 1.4;">
                <p style="text-align: justify; margin-bottom: 10px;">
                    Je soussigné(e) <span style="text-decoration: underline;">{{ $formData['full_name'] ?? '__________________________' }}</span>, certifie que les renseignements fournis dans le présent formulaire sont exacts et complets. J'accepte que ces informations servent de base au contrat d'assurance et reconnais que toute fausse déclaration ou omission volontaire de ma part pourrait entraîner la nullité de la garantie.
                </p>

                <p style="text-align: justify; margin-bottom: 10px;">
                    Je reconnais avoir reçu et pris connaissance des Conditions Générales d'Assurance qui me sont applicables. J'accepte d'être lié(e) par les termes et conditions du contrat d'assurance.
                </p>

                <p style="text-align: justify; margin-bottom: 10px;">
                    Je consens au traitement de mes données personnelles conformément à la politique de confidentialité de l'assureur et autorise la communication de ces informations aux prestataires de services et aux autorités compétentes dans le cadre de la gestion du contrat.
                </p>

                <div style="margin: 15px 0 10px 0; text-align: center;">
                    <div style="margin-bottom: 30px;">
                        <div style="margin-bottom: 5px;">Fait à / Done at <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; margin: 0 5px;"></span>, le / on</div>
                        <div style="display: inline-block; width: 80px; border-bottom: 1px solid #000; text-align: center;">{{ date('d/m/Y') }}</div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="border-bottom: 1px solid #000; width: 60%; height: 1px; margin: 0 auto 5px auto;"></div>
                        <div>Signature de l'Assuré / Insured's Signature</div>
                    </div>

                    <div style="margin-top: 30px; font-size: 8pt; text-align: left;">
                        <div><strong>Pour l'Assureur / For the Insurer:</strong></div>
                        <div style="margin-top: 15px;">
                            <div>Nom et qualité / Name and title: <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px; margin-left: 5px;"></span></div>
                            <div style="margin-top: 10px;">Signature / Signature: <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px; margin-left: 5px;"></span></div>
                            <div style="margin-top: 10px;">Date: <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; margin-left: 5px;"></span></div>
                        </div>
                    </div>
                </div>

                <div style="background-color: #f5f5f5; padding: 8px; margin-top: 15px; border: 1px solid #ddd; font-size: 8pt; text-align: justify;">
                    <div style="font-weight: bold; margin-bottom: 5px; text-align: center;">INFORMATIONS SUR LE DROIT DE RÉTRACTATION / RIGHT OF WITHDRAWAL INFORMATION</div>
                    <p style="margin-bottom: 5px;">
                        Vous disposez d'un délai de 10 jours à compter de la date de souscription du contrat pour vous rétracter, sans avoir à justifier de motifs ni à payer de pénalités, à l'exception des frais correspondant au service effectivement fourni jusqu'à la communication de votre décision de vous rétracter.
                    </p>
                    <p style="margin-bottom: 5px;">
                        Pour vous rétracter, vous pouvez utiliser le formulaire de rétractation ci-dessous et l'envoyer à l'adresse suivante : [Adresse de l'assureur].
                    </p>
                    <p style="margin-bottom: 5px; font-weight: bold; text-align: center; margin-top: 10px;">
                        MODÈLE DE FORMULAIRE DE RÉTRACTATION / WITHDRAWAL FORM
                    </p>
                    <p style="margin-bottom: 5px; font-style: italic;">
                        (à compléter et à renvoyer uniquement en cas de rétractation / to be completed and returned only if you wish to withdraw)
                    </p>
                    <div style="border: 1px solid #000; padding: 10px; margin: 10px 0; background-color: white;">
                        <p style="margin-bottom: 10px;">
                            À l'attention de / To the attention of: [Nom et adresse de l'assureur / Name and address of the insurer]
                        </p>
                        <p style="margin-bottom: 10px;">
                            Je vous notifie par la présente ma rétractation du contrat d'assurance n° [numéro de police] conclu le [date de conclusion].
                        </p>
                        <p style="margin-bottom: 5px;">
                            Nom du souscripteur / Policyholder's name: <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px; margin-left: 5px;"></span>
                        </p>
                        <p style="margin-bottom: 5px;">
                            Adresse / Address: <span style="border-bottom: 1px solid #000; min-width: 300px; display: inline-block; height: 16px; margin-left: 5px;"></span>
                        </p>
                        <p style="margin-bottom: 5px;">
                            Date: <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; margin-left: 5px;"></span>
                        </p>
                        <p style="margin-bottom: 5px;">
                            Signature / Signature: <span style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; height: 16px; margin-left: 5px;"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 7: BON POUR VISA DE L'ASSUREUR -->
        <div style="border: 1px solid #000; margin-bottom: 10px; padding: 10px; text-align: center;">
            <div style="font-weight: bold; margin-bottom: 15px;">BON POUR VISA DE L'ASSUREUR / FOR INSURER'S APPROVAL</div>

            <div style="display: flex; justify-content: space-around; margin-bottom: 20px;">
                <div style="width: 45%;">
                    <div style="border: 1px solid #000; height: 80px; margin-bottom: 5px; display: flex; align-items: center; justify-content: center;">
                        [Cachet de l'Assureur / Insurer's Stamp]
                    </div>
                    <div>Date: _________________</div>
                </div>
                <div style="width: 45%;">
                    <div style="border: 1px solid #000; height: 80px; margin-bottom: 5px; display: flex; align-items: center; justify-content: center;">
                        [Signature et cachet du représentant habilité / Authorized representative's signature and stamp]
                    </div>
                    <div>Nom et qualité / Name and title: _________________</div>
                </div>
            </div>

            <div style="text-align: left; margin-top: 20px; font-size: 9pt;">
                <div style="font-weight: bold; margin-bottom: 5px;">Références du contrat / Policy references:</div>
                <div style="margin-bottom: 5px;">N° de police / Policy number: <span style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; height: 16px; margin-left: 5px;"></span></div>
                <div style="margin-bottom: 5px;">Date d'effet / Inception date: <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; margin-left: 5px;"></span></div>
                <div style="margin-bottom: 5px;">Date d'échéance / Expiry date: <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; margin-left: 5px;"></span></div>
                <div style="margin-bottom: 5px;">Prime totale / Total premium: <span style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; height: 16px; margin-left: 5px;"></span> FCFA</div>
            </div>
        </div>

        <!-- Notes finales / Final notes -->
        <div style="margin: 15px 0; font-size: 8pt; text-align: center; font-style: italic;">
            <div style="margin-bottom: 5px;">
                <strong>N.B.:</strong> Ce document ne constitue pas une police d'assurance. Les garanties ne prendront effet qu'après acceptation du risque par l'Assureur et paiement de la prime.
            </div>
            <div style="margin-bottom: 5px;">
                <strong>N.B.:</strong> This document is not an insurance policy. Cover will only take effect after the risk has been accepted by the Insurer and the premium has been paid.
            </div>
            <div style="margin-top: 10px; font-weight: bold;">
                Pour toute information complémentaire, veuillez contacter votre conseiller / For further information, please contact your advisor
            </div>
        </div>

        <!-- Copy Information -->
        <div class="form-container" style="max-width: 100%; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; font-size: 10pt; line-height: 1.4; color: #333; background: white; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <!-- Boutons d'action -->
        <div class="action-buttons no-print" style="margin-bottom: 20px; padding: 10px; background-color: #f5f5f5; border-radius: 4px; text-align: center;">
            <button type="button" id="copy-insured-to-beneficiary" class="btn-action" title="Copier les informations de l'assuré vers le bénéficiaire">
                <i class="fas fa-copy"></i> Copier vers bénéficiaire
            </button>
            <button type="button" id="reset-form" class="btn-action" title="Réinitialiser le formulaire">
                <i class="fas fa-undo"></i> Réinitialiser
            </button>
            <button type="button" id="print-form" class="btn-action" title="Imprimer le formulaire">
                <i class="fas fa-print"></i> Imprimer
            </button>
            <button type="submit" class="btn-action primary" title="Soumettre le formulaire">
                <i class="fas fa-paper-plane"></i> Soumettre
            </button>
        </div>
        <div class="copy-info" style="margin-top: 20px; padding: 5px; border-top: 1px solid #ddd; font-size: 8pt; text-align: center;">
            <div>4 copies</div>
            <div>White copy - Assureur / Insurer</div>
            <div>Green Copy - Agence / Agency</div>
            <div>Yellow Copy - Banque / Bank</div>
            <div>Blue Copy - Assuré / Insured</div>
        </div>
    </div>

    <script>
        // Fonction pour afficher/masquer les détails de sinistre
        function toggleClaimDetails() {
            const claimYes = document.getElementById('claim_yes');
            const claimDetailsRow = document.getElementById('claim_details_row');
            if (claimYes && claimDetailsRow) {
                claimDetailsRow.style.display = claimYes.checked ? 'block' : 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

            // Gestion de l'affichage conditionnel pour les informations sur l'assurance précédente
            const previousInsuranceYes = document.getElementById('previous_insurance_yes');
            const previousInsuranceNo = document.getElementById('previous_insurance_no');
            const insuranceDetails = previousInsuranceYes ? previousInsuranceYes.parentNode.querySelector('span:last-child') : null;

            if (previousInsuranceYes && previousInsuranceNo && insuranceDetails) {
                // Fonction pour gérer l'affichage des détails de l'assurance précédente
                function toggleInsuranceDetails() {
                    if (previousInsuranceYes.checked) {
                        insuranceDetails.style.display = 'inline-block';
                    } else {
                        insuranceDetails.style.display = 'none';
                    }
                }

                // Écouteurs d'événements pour les boutons radio d'assurance précédente
                previousInsuranceYes.addEventListener('change', toggleInsuranceDetails);
                previousInsuranceNo.addEventListener('change', toggleInsuranceDetails);

                // Initialisation de l'état initial
                toggleInsuranceDetails();
            }

            // Gestion de l'affichage conditionnel pour les détails de sinistre précédent
            const previousClaimYes = document.getElementById('previous_claim_yes');
            const previousClaimNo = document.getElementById('previous_claim_no');
            const claimDetails = document.querySelector('input[name="previous_claim"][value="yes"]').parentNode.nextElementSibling;

            if (previousClaimYes && previousClaimNo && claimDetails) {
                // Fonction pour gérer l'affichage des détails de sinistre
                function toggleClaimDetails() {
                    if (previousClaimYes.checked) {
                        claimDetails.style.display = 'block';
                    } else {
                        claimDetails.style.display = 'none';
                    }
                }

                // Écouteurs d'événements pour les boutons radio de sinistre précédent
                previousClaimYes.addEventListener('change', toggleClaimDetails);
                previousClaimNo.addEventListener('change', toggleClaimDetails);

                // Initialisation de l'état initial
                toggleClaimDetails();
            }

            // Gestion de l'affichage conditionnel pour le nombre de versements
            const paymentFull = document.getElementById('payment_full');
            const paymentInstallment = document.getElementById('payment_installment');
            const installmentDetails = document.querySelector('input[name="payment_method"][value="installment"]').parentNode.querySelector('span');

            if (paymentFull && paymentInstallment && installmentDetails) {
                // Fonction pour gérer l'affichage des détails de paiement échelonné
                function toggleInstallmentDetails() {
                    if (paymentInstallment.checked) {
                        installmentDetails.style.display = 'inline';
                    } else {
                        installmentDetails.style.display = 'none';
                    }
                }

                // Écouteurs d'événements pour les boutons radio de mode de paiement
                paymentFull.addEventListener('change', toggleInstallmentDetails);
                paymentInstallment.addEventListener('change', toggleInstallmentDetails);

                // Initialisation de l'état initial
                toggleInstallmentDetails();
            }

            // Gestion de l'affichage conditionnel pour les détails de prélèvement automatique
            const paymentMethods = document.querySelectorAll('input[name="payment_type"]');
            const directDebitSection = document.querySelector('div:has(> div > label[for="payment_transfer"])').parentNode.nextElementSibling;

            if (paymentMethods.length > 0 && directDebitSection) {
                // Fonction pour gérer l'affichage des détails de prélèvement automatique
                function toggleDirectDebitDetails() {
                    const selectedMethod = document.querySelector('input[name="payment_type"]:checked');
                    if (selectedMethod && selectedMethod.value === 'transfer') {
                        directDebitSection.style.display = 'block';
                    } else {
                        directDebitSection.style.display = 'none';
                    }
                }

                // Écouteurs d'événements pour les boutons radio de type de paiement
                paymentMethods.forEach(method => {
                    method.addEventListener('change', toggleDirectDebitDetails);
                });

                // Initialisation de l'état initial
                toggleDirectDebitDetails();
            }

            // Validation du formulaire avant soumission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    let isValid = true;

                    // Vérification des champs obligatoires
                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.style.borderColor = 'red';
                        } else {
                            field.style.borderColor = '';
                        }
                    });

                    // Vérification des boutons radio obligatoires
                    const requiredRadioGroups = form.querySelectorAll('.required-radio');
                    requiredRadioGroups.forEach(group => {
                        const radioButtons = group.querySelectorAll('input[type="radio"]');
                        let isChecked = false;

                        radioButtons.forEach(radio => {
                            if (radio.checked) {
                                isChecked = true;
                            }
                        });

                        if (!isChecked) {
                            isValid = false;
                            group.style.border = '1px solid red';
                            group.style.padding = '5px';
                        } else {
                            group.style.border = '';
                            group.style.padding = '';
                        }
                    });

                    if (!isValid) {
                        event.preventDefault();
                        alert('Veuillez remplir tous les champs obligatoires marqués en rouge.');
                    }
                });
            }

            // Mise en forme automatique des numéros de téléphone
            const phoneInputs = document.querySelectorAll('input[type="tel"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        value = value.match(/(\d{0,2})(\d{0,2})(\d{0,2})(\d{0,2})/);
                        e.target.value = !value[2] ? value[1] : value[1] + ' ' + value[2] + (value[3] ? ' ' + value[3] : '') + (value[4] ? ' ' + value[4] : '');
                    }
                });
            });

            // Mise en forme automatique des montants
            const amountInputs = document.querySelectorAll('input.amount');
            amountInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value) {
                        value = parseInt(value, 10).toLocaleString('fr-FR');
                        e.target.value = value;
                    }
                });
            });
        });

        // Fonction pour copier les informations de l'assuré vers le bénéficiaire
        function copyInsuredToBeneficiary() {
            // Récupération des valeurs des champs de l'assuré
            const lastName = document.querySelector('input[name="last_name"]').value;
            const firstName = document.querySelector('input[name="first_name"]').value;
            const birthDate = document.querySelector('input[name="birth_date"]').value;
            const idNumber = document.querySelector('input[name="id_number"]').value;
            const address = document.querySelector('input[name="address"]').value;
            const city = document.querySelector('input[name="city"]').value;
            const country = document.querySelector('input[name="country"]').value;
            const phone = document.querySelector('input[name="phone"]').value;
            const email = document.querySelector('input[name="email"]').value;

            // Copie des valeurs vers les champs du bénéficiaire
            document.querySelector('input[name="beneficiary_last_name"]').value = lastName;
            document.querySelector('input[name="beneficiary_first_name"]').value = firstName;
            document.querySelector('input[name="beneficiary_birth_date"]').value = birthDate;
            document.querySelector('input[name="beneficiary_id_number"]').value = idNumber;
            document.querySelector('input[name="beneficiary_address"]').value = address;
            document.querySelector('input[name="beneficiary_city"]').value = city;
            document.querySelector('input[name="beneficiary_country"]').value = country;
            document.querySelector('input[name="beneficiary_phone"]').value = phone;
            document.querySelector('input[name="beneficiary_email"]').value = email;

            // Afficher une notification
            alert('Les informations de l\'assuré ont été copiées vers les champs du bénéficiaire.');
        }

        // Fonction pour réinitialiser le formulaire
        function resetForm() {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ? Toutes les données saisies seront perdues.')) {
                document.querySelector('form').reset();
                // Réinitialiser les champs masqués
                document.querySelectorAll('[style*="display: none"]').forEach(el => {
                    el.style.display = 'none';
                });
                // Réinitialiser les styles des champs obligatoires
                document.querySelectorAll('[required]').forEach(field => {
                    field.style.borderColor = '';
                });
                // Réinitialiser les groupes de boutons radio
                document.querySelectorAll('.required-radio').forEach(group => {
                    group.style.border = '';
                    group.style.padding = '';
                });
            }
        }

        // Fonction pour imprimer le formulaire
        function printForm() {
            window.print();
        }

        // Fonction pour valider le formulaire avant soumission
        function validateForm() {
            let isValid = true;
            const form = document.querySelector('form');

            // Vérification des champs obligatoires
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '';
                }
            });

            // Vérification des boutons radio obligatoires
            const requiredRadioGroups = form.querySelectorAll('.required-radio');
            requiredRadioGroups.forEach(group => {
                const radioButtons = group.querySelectorAll('input[type="radio"]');
                let isChecked = false;

                radioButtons.forEach(radio => {
                    if (radio.checked) {
                        isChecked = true;
                    }
                });

                if (!isChecked) {
                    isValid = false;
                    group.style.border = '1px solid red';
                    group.style.padding = '5px';
                } else {
                    group.style.border = '';
                    group.style.padding = '';
                }
            });

            if (!isValid) {
                alert('Veuillez remplir tous les champs obligatoires marqués en rouge.');
                return false;
            }

            // Vérification de la cohérence des dates
            const startDate = new Date(document.querySelector('input[name="start_date"]').value);
            const endDate = new Date(document.querySelector('input[name="end_date"]').value);

            if (startDate >= endDate) {
                alert('La date de fin doit être postérieure à la date de début.');
                return false;
            }

            // Vérification de la validité de l'email
            const email = document.querySelector('input[type="email"]').value;
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Veuillez saisir une adresse email valide.');
                return false;
            }

            // Si tout est valide, on peut soumettre le formulaire
            return confirm('Êtes-vous sûr de vouloir soumettre le formulaire ?');
        }

        // Initialisation des événements après le chargement du DOM
        // Fonction pour initialiser les gestionnaires d'événements
        function initializeEventHandlers() {
            // Gestion de l'affichage conditionnel pour les informations sur l'assurance précédente
            const previousInsuranceYes = document.getElementById('previous_insurance_yes');
            const previousInsuranceNo = document.getElementById('previous_insurance_no');
            const insuranceDetails = previousInsuranceYes ? previousInsuranceYes.parentNode.querySelector('span:last-child') : null;

            if (previousInsuranceYes && previousInsuranceNo && insuranceDetails) {
                // Fonction pour gérer l'affichage des détails de l'assurance précédente
                function toggleInsuranceDetails() {
                    if (previousInsuranceYes.checked) {
                        insuranceDetails.style.display = 'inline-block';
                    } else {
                        insuranceDetails.style.display = 'none';
                    }
                }

                // Supprimer d'abord les écouteurs existants pour éviter les doublons
                previousInsuranceYes.removeEventListener('change', toggleInsuranceDetails);
                previousInsuranceNo.removeEventListener('change', toggleInsuranceDetails);

                // Ajouter les écouteurs d'événements
                previousInsuranceYes.addEventListener('change', toggleInsuranceDetails);
                previousInsuranceNo.addEventListener('change', toggleInsuranceDetails);

                // Initialisation de l'état initial
                toggleInsuranceDetails();
            }

            // Ajout des écouteurs d'événements pour les boutons d'action
            const copyButton = document.getElementById('copy-insured-to-beneficiary');
            const resetButton = document.getElementById('reset-form');
            const printButton = document.getElementById('print-form');
            const submitButton = document.querySelector('button[type="submit"]');

            if (copyButton) {
                copyButton.addEventListener('click', copyInsuredToBeneficiary);
            }

            if (resetButton) {
                resetButton.addEventListener('click', resetForm);
            }

            if (printButton) {
                printButton.addEventListener('click', printForm);
            }

            if (submitButton) {
                submitButton.addEventListener('click', function(event) {
                    if (!validateForm()) {
                        event.preventDefault();
                    }
                });
            }

            // Initialisation des tooltips
            const tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                tooltip.addEventListener('mouseover', function() {
                    const tooltipText = this.getAttribute('title');
                    if (tooltipText) {
                        const tooltipElement = document.createElement('div');
                        tooltipElement.className = 'custom-tooltip';
                        tooltipElement.textContent = tooltipText;
                        document.body.appendChild(tooltipElement);

                        const rect = this.getBoundingClientRect();
                        tooltipElement.style.top = (rect.top - tooltipElement.offsetHeight - 5) + 'px';
                        tooltipElement.style.left = (rect.left + (this.offsetWidth - tooltipElement.offsetWidth) / 2) + 'px';

                        this._tooltipElement = tooltipElement;
                    }
                });

                tooltip.addEventListener('mouseout', function() {
                    if (this._tooltipElement) {
                        document.body.removeChild(this._tooltipElement);
                        this._tooltipElement = null;
                    }
                });
            });
        });

        // Fonction pour formater les numéros de téléphone
        function formatPhoneNumber(input) {
            // Supprimer tous les caractères non numériques
            let value = input.value.replace(/\D/g, '');

            // Limiter à 10 chiffres
            if (value.length > 10) {
                value = value.substring(0, 10);
            }

            // Appliquer le format XX XX XX XX XX
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 2 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }

            input.value = formattedValue;
        }

        // Fonction pour formater les montants
        function formatAmount(input) {
            // Supprimer tous les caractères non numériques
            let value = input.value.replace(/\D/g, '');

            // Convertir en nombre et formater avec des espaces comme séparateurs de milliers
            if (value) {
                value = parseInt(value, 10).toLocaleString('fr-FR');
                input.value = value;
            }
        }
    </script>

    <style>
        /* Styles pour les boutons d'action */
        .action-buttons, .btn-action {
            margin: 20px 0;
            text-align: center;
        }

        .action-buttons button {
            margin: 0 5px;
            padding: 8px 15px;
            border: 1px solid #0056b3;
            background-color: #f8f9fa;
            color: #0056b3;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-buttons button:hover {
            background-color: #0056b3;
            color: white;
        }

        .action-buttons button.primary {
            background-color: #0056b3;
            color: white;
        }

        .action-buttons button.primary:hover {
            background-color: #003d82;
        }

        /* Styles pour les tooltips */
        .custom-tooltip {
            position: fixed;
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 1000;
            max-width: 250px;
            text-align: center;
        }

        /* Styles pour les champs obligatoires */
        .required-field::after {
            content: ' *';
            color: red;
        }

        /* Styles pour les messages d'erreur */
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        input:invalid, select:invalid, textarea:invalid {
            border-color: #ff9999;
        }

        /* Styles pour les sections du formulaire */
        .form-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .form-section h3 {
            margin-top: 0;
            color: #0056b3;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        /* Styles pour les tableaux */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Styles pour les écrans d'impression */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 12pt;
                line-height: 1.3;
            }

            .form-section {
                page-break-inside: avoid;
            }

            .action-buttons, button, .custom-tooltip {
                display: none !important;
            }
        }
    </style>

<!-- Ajout de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    // Le code JavaScript précédent reste inchangé
</script>
</body>
</html>
