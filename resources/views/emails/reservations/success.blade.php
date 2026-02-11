<!DOCTYPE html>
<html lang="fr" style="margin:0;padding:0;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Confirmation de votre réservation</title>
  <style>
    body{
      font-family: Arial, Helvetica, sans-serif;
      background:#f5f6f8;
      margin:0; padding:0;
      color:#333;
    }
    .container{
      width:100%;
      max-width:600px;
      margin:0 auto;
      background:#fff;
      border-radius:10px;
      overflow:hidden;
      box-shadow:0 2px 10px rgba(0,0,0,.08);
      border:1px solid #ececec;
    }
    .header{
      background:#D1B11B; /* Gold Voodoo Hoost */
      color:#fff;
      text-align:center;
      padding:22px 18px;
    }
    .brand{
      font-size:20px;
      font-weight:700;
      letter-spacing:.2px;
      margin:0;
      line-height:1.2;
    }
    .subtitle{
      margin:6px 0 0 0;
      font-size:13px;
      opacity:.95;
    }
    .content{
      padding:28px 24px;
      line-height:1.65;
      font-size:15px;
    }
    .title{
      margin:0 0 8px 0;
      font-size:20px;
      color:#222;
      font-weight:800;
    }
    .muted{ color:#666; font-size:13px; margin:0; }
    .card{
      border:1px solid #eee;
      border-radius:10px;
      overflow:hidden;
      margin:18px 0;
      background:#fff;
    }
    .card-head{
      background:#fafafa;
      border-bottom:1px solid #eee;
      padding:12px 16px;
      font-weight:700;
      color:#333;
      font-size:14px;
    }
    .card-body{
      padding:14px 16px;
      font-size:13px;
      color:#555;
    }
    .gold-line{
      border-left:4px solid #D1B11B;
      background:#fafafa;
      padding:12px 14px;
      border-radius:6px;
      margin:14px 0 0 0;
    }
    .row{
      width:100%;
      border-collapse:collapse;
    }
    .row td{
      padding:6px 0;
      font-size:13px;
      color:#555;
    }
    .right{ text-align:right; }
    .strong{ font-weight:700; color:#333; }
    .total{
      border-top:1px solid #eee;
      padding-top:10px !important;
      font-weight:800;
      color:#222 !important;
    }
    .button{
      display:inline-block;
      background:#D1B11B;
      padding:13px 26px;
      color:#fff !important;
      font-size:14px;
      text-decoration:none;
      border-radius:8px;
      font-weight:800;
      margin:18px 0 6px 0;
    }
    .button:hover{ opacity:.92; }
    .footer{
      text-align:center;
      padding:18px 16px;
      font-size:12px;
      color:#777;
      background:#fafafa;
      border-top:1px solid #eee;
      line-height:1.5;
    }
    @media (max-width:600px){
      .content{ padding:22px 15px; }
      .button{ width:100%; text-align:center; box-sizing:border-box; }
    }
  </style>
</head>

<body>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f5f6f8;padding:20px 0;">
    <tr>
      <td align="center">

        <div class="container">
          <!-- Header -->
          <div class="header">
            <!-- Si tu veux le logo, garde l'image. Sinon garde la marque texte. -->
            <div style="margin:0 auto 8px auto;">
              <img src="{{ asset('assets/images/voodoo/logo.png') }}"
                   alt="Voodoo Hoost"
                   style="max-height:44px;display:block;margin:0 auto;">
            </div>
            <p class="brand" style="margin:0;">Réservation confirmée</p>
            <p class="subtitle" style="margin:6px 0 0 0;">Bienvenue dans l’expérience Voodoo Hoost ✨</p>
          </div>

          <!-- Content -->
          <div class="content">
            <h1 class="title">Votre réservation est confirmée 🎉</h1>
            <p class="muted">Bonjour {{ $reservation->user->prenom }},</p>
            <p class="muted" style="margin-top:6px;">
              Merci, votre réservation a bien été enregistrée. Retrouvez ci-dessous le récapitulatif de votre séjour.
            </p>

            <!-- Logement -->
            <div class="card">
              <div class="card-head">Logement réservé</div>
              <div class="card-body">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="row">
                  <tr>
                    @if(!empty($photo))
                      <td width="40%" style="padding-right:12px;vertical-align:top;">
                        <img src="{{ $photo }}"
                             alt="Photo du logement"
                             style="display:block;width:100%;max-height:170px;object-fit:cover;border-radius:8px;">
                      </td>
                      <td width="60%" style="vertical-align:top;">
                    @else
                      <td width="100%" style="vertical-align:top;">
                    @endif

                        <div style="font-size:15px;font-weight:800;color:#222;margin-bottom:6px;">
                          {{ $logement->titre }}
                        </div>

                        <div style="color:#666;font-size:13px;margin-bottom:4px;">
                          <span class="strong">Adresse :</span> {{ $logement->adresse }}
                        </div>

                        @if($logement->typelogement)
                          <div style="color:#666;font-size:13px;margin-bottom:4px;">
                            <span class="strong">Type :</span> {{ $logement->typelogement->libelle }}
                          </div>
                        @endif

                        <div style="color:#666;font-size:13px;">
                          <span class="strong">Capacité :</span> {{ $logement->nb_voyageur_max }} voyageurs max.
                        </div>

                        <div class="gold-line">
                          <div style="font-size:12px;color:#666;">
                            Conseil : conservez cet email comme preuve de réservation.
                          </div>
                        </div>

                      </td>
                  </tr>
                </table>
              </div>
            </div>

            <!-- Détails du séjour -->
            <div class="card">
              <div class="card-head">Détails de votre séjour</div>
              <div class="card-body">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="row">
                  <tr>
                    <td>Date d’arrivée</td>
                    <td class="right strong">{{ $reservation->date_debut }}</td>
                  </tr>
                  <tr>
                    <td>Date de départ</td>
                    <td class="right strong">{{ $reservation->date_fin }}</td>
                  </tr>
                  <tr>
                    <td>Nombre de nuits</td>
                    <td class="right">{{ $reservation->nb_nuits }}</td>
                  </tr>
                  <tr>
                    <td>Voyageurs</td>
                    <td class="right">{{ $reservation->nb_voyageurs }}</td>
                  </tr>
                  <tr>
                    <td>Montant du séjour</td>
                    <td class="right">
                      {{ number_format($reservation->montant, 0, ',', ' ') }}
                      {{-- {{ $reservation->devise }} --}}
                    </td>
                  </tr>

                  <tr>
                    <td class="total">Montant total payé</td>
                    <td class="right total">
                      {{ number_format($reservation->montant, 0, ',', ' ') }}
                      {{-- {{ $reservation->devise }} --}}
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <!-- CTA -->
            <div style="text-align:center;">
              <a href="{{ config('app.url') }}" class="button">Accéder à Voodoo Hoost</a>
              <div style="font-size:12px;color:#777;margin-top:6px;">
                Besoin d’aide ? Réponds à cet email ou contacte notre support.
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="footer">
            © 2025 Voodoo Hoost<br>
            <small>Connectez voyageurs & hôtes. Découvrez culture, rituels & hospitalité.</small><br><br>
            <small>
              Vous recevez cet email suite à une réservation effectuée sur Voodoo Hoost.
              Si vous pensez qu'il s'agit d'une erreur, merci de contacter notre support.
            </small>
          </div>
        </div>

      </td>
    </tr>
  </table>
</body>
</html>
