<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\Reservation;
use Carbon\Carbon;
use Fedapay\Fedapay;
use Fedapay\Transaction;
use const FILTER_VALIDATE_EMAIL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaiementService
{
    /**
     * Initialise la configuration de FedaPay
     */
    public function __construct()
    {
        // Configuration de FedaPay
        Fedapay::setApiKey(Config::get('services.fedapay.secret_key'));
        Fedapay::setEnvironment(Config::get('services.fedapay.environment', 'sandbox'));
    }

    /**
     * Initialise un nouveau paiement
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function initierPaiement(array $data): array
    {
        try {
            // Valider les données de paiement
            $this->validerDonneesPaiement($data);

            // Créer la transaction FedaPay
            $transaction = Transaction::create([
                'description' => $data['description'],
                'amount' => $data['montant'],
                'currency' => [
                    'iso' => $data['devise'] ?? 'XOF'
                ],
                'callback_url' => $data['callback_url'] ?? null,
                'cancel_url' => $data['cancel_url'] ?? null,
                'customer' => [
                    'firstname' => $data['client_prenom'] ?? null,
                    'lastname' => $data['client_nom'] ?? null,
                    'email' => $data['client_email'] ?? null,
                    'phone_number' => $data['client_telephone'] ?? null,
                ],
                'metadata' => $data['metadata'] ?? [],
            ]);

            // Générer le token de paiement
            $token = $transaction->generateToken();

            // Retourner les informations de paiement
            return [
                'success' => true,
                'transaction_id' => $transaction->id,
                'reference' => $data['reference'],
                'montant' => $data['montant'],
                'devise' => $data['devise'] ?? 'XOF',
                'url_paiement' => $token->url,
                'statut' => 'pending',
                'date_creation' => now()->toDateTimeString(),
            ];

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'initialisation du paiement', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            throw new \Exception('Une erreur est survenue lors de l\'initialisation du paiement. Veuillez réessayer.');
        }
    }

    /**
     * Vérifie l'état d'une transaction
     *
     * @param string $transactionId
     * @return array
     * @throws \Exception
     */
    public function verifierStatutPaiement(string $transactionId): array
    {
        try {
            $transaction = Transaction::retrieve($transactionId);

            return [
                'transaction_id' => $transaction->id,
                'reference' => $transaction->reference,
                'montant' => $transaction->amount,
                'devise' => $transaction->currency->iso,
                'statut' => $transaction->status,
                'date_creation' => $transaction->created_at,
                'date_mise_a_jour' => $transaction->updated_at,
                'paiement_effectue' => $transaction->status === 'approved',
            ];

        } catch (\Exception $e) {
            Log::error('Erreur lors de la vérification du statut du paiement', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Impossible de vérifier le statut du paiement. Veuillez réessayer plus tard.');
        }
    }

    /**
     * Traite une notification de paiement (webhook)
     *
     * @param array $payload
     * @return array
     * @throws \Exception
     */
    public function traiterNotificationPaiement(array $payload): array
    {
        try {
            // Vérifier la signature du webhook (à implémenter selon la doc de FedaPay)
            // $this->verifierSignatureWebhook($payload);

            $transactionId = $payload['data']['id'] ?? null;
            $statut = $payload['data']['status'] ?? null;
            $metadata = $payload['data']['metadata'] ?? [];

            if (!$transactionId) {
                throw new \Exception('ID de transaction manquant dans la notification');
            }

            // Vérifier le statut de la transaction
            $transaction = Transaction::retrieve($transactionId);

            return [
                'success' => true,
                'transaction_id' => $transaction->id,
                'reference' => $transaction->reference,
                'montant' => $transaction->amount,
                'devise' => $transaction->currency->iso,
                'statut' => $transaction->status,
                'paiement_effectue' => $transaction->status === 'approved',
                'date_creation' => $transaction->created_at,
                'date_mise_a_jour' => $transaction->updated_at,
                'metadata' => $metadata,
            ];

        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement de la notification de paiement', [
                'payload' => $payload,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Erreur lors du traitement de la notification de paiement');
        }
    }

    /**
     * Effectue un remboursement
     *
     * @param string $transactionId
     * @param float $montant
     * @param string $raison
     * @return array
     * @throws \Exception
     */
    public function effectuerRemboursement(string $transactionId, float $montant, string $raison = ''): array
    {
        try {
            $transaction = Transaction::retrieve($transactionId);
            
            // Vérifier que la transaction est éligible au remboursement
            if ($transaction->status !== 'approved') {
                throw new \Exception('Cette transaction ne peut pas être remboursée.');
            }

            // Créer un remboursement
            $refund = $transaction->refund([
                'amount' => $montant,
                'description' => $raison ?: 'Remboursement partiel',
            ]);

            return [
                'success' => true,
                'remboursement_id' => $refund->id,
                'montant' => $refund->amount,
                'devise' => $refund->currency->iso,
                'statut' => $refund->status,
                'raison' => $raison,
                'date_creation' => now()->toDateTimeString(),
            ];

        } catch (\Exception $e) {
            Log::error('Erreur lors du remboursement', [
                'transaction_id' => $transactionId,
                'montant' => $montant,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Une erreur est survenue lors du remboursement. Veuillez contacter le support.');
        }
    }

    /**
     * Valide les données de paiement
     *
     * @param array $data
     * @throws \Exception
     */
    protected function validerDonneesPaiement(array $data): void
    {
        $required = ['montant', 'description', 'client_email'];
        $missing = [];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                $missing[] = $field;
            }
        }

        if (!empty($missing)) {
            throw new \Exception('Champs obligatoires manquants : ' . implode(', ', $missing));
        }

        if (!is_numeric($data['montant']) || $data['montant'] <= 0) {
            throw new \Exception('Le montant doit être un nombre positif');
        }

        if (!filter_var($data['client_email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Adresse email invalide');
        }
    }

    /**
     * Vérifie la signature d'un webhook (à implémenter selon la doc de FedaPay)
     *
     * @param array $payload
     * @return bool
     * @throws \Exception
     */
    protected function verifierSignatureWebhook(array $payload): bool
    {
        // Implémentez la vérification de signature selon la documentation de FedaPay
        // Par exemple :
        // $signature = request()->header('X-FedaPay-Signature');
        // $expected = hash_hmac('sha256', json_encode($payload), Config::get('services.fedapay.webhook_secret'));
        // if (!hash_equals($expected, $signature)) {
        //     throw new \Exception('Signature de webhook invalide');
        // }
        
        return true; // À remplacer par la vérification réelle
    }

    /**
     * Formate un montant pour FedaPay (en centimes)
     *
     * @param float $montant
     * @return int
     */
    public function formaterMontant(float $montant): int
    {
        return (int) round($montant * 100);
    }

    /**
     * Récupère l'historique des transactions
     *
     * @param array $filtres
     * @return array
     */
    public function getHistoriqueTransactions(array $filtres = []): array
    {
        try {
            $params = [];
            
            // Appliquer les filtres
            if (!empty($filtres['date_debut'])) {
                $params['start_date'] = Carbon::parse($filtres['date_debut'])->toIso8601String();
            }
            
            if (!empty($filtres['date_fin'])) {
                $params['end_date'] = Carbon::parse($filtres['date_fin'])->endOfDay()->toIso8601String();
            }
            
            if (!empty($filtres['statut'])) {
                $params['status'] = $filtres['statut'];
            }
            
            // Récupérer les transactions
            $transactions = Transaction::all($params);
            
            // Formater les résultats
            $resultats = [];
            foreach ($transactions as $transaction) {
                $resultats[] = [
                    'id' => $transaction->id,
                    'reference' => $transaction->reference,
                    'montant' => $transaction->amount,
                    'devise' => $transaction->currency->iso,
                    'statut' => $transaction->status,
                    'description' => $transaction->description,
                    'date_creation' => $transaction->created_at,
                    'date_mise_a_jour' => $transaction->updated_at,
                    'client' => [
                        'nom' => $transaction->customer->lastname ?? null,
                        'prenom' => $transaction->customer->firstname ?? null,
                        'email' => $transaction->customer->email ?? null,
                    ],
                ];
            }
            
            return $resultats;
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'historique des transactions', [
                'filtres' => $filtres,
                'error' => $e->getMessage(),
            ]);
            
            return [];
        }
    }
}
