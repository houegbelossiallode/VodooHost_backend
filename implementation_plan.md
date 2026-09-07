# Plan d'Implémentation : Gestion des Disponibilités et Découpage Automatique des Plages (Vodoo Host)

Ce document décrit le fonctionnement et la stratégie technique pour gérer le découpage automatique des plages de dates (`logement_disponibilites`), la mise à jour des statuts lors des réservations, et l'affichage/édition via la vue Calendrier Web (Hôte & Voyageur).

---

## 📐 1. Scénario Concret : Découpage d'une Plage de Disponibilité

### 🔹 Situation Initiale
Le logement #34 possède une seule plage de disponibilité dans `logement_disponibilites` :
- **ID 1** : `date_debut = 2026-09-01`, `date_fin = 2026-09-30`, `statut = 'disponible'`

---

### 🔹 Action : Réservation du 10 au 15 Septembre
Un voyageur effectue une réservation payée du **10/09/2026 au 15/09/2026**.

---

### 🔹 Résultat après Découpage (Splitting Algorithm)
La plage initiale (ID 1) est découpée en **3 segments distincts** :

| Segment | Date Début | Date Fin | Statut | Action enregistrée en Base |
| :--- | :--- | :--- | :--- | :--- |
| **Plage 1** | `2026-09-01` | `2026-09-09` | `disponible` | Mettre à jour l'ancienne ligne (01/09 -> 09/09) |
| **Plage 2** | `2026-09-10` | `2026-09-15` | `reserver` | Insérer nouvelle ligne (10/09 -> 15/09, statut `reserver`) |
| **Plage 3** | `2026-09-16` | `2026-09-30` | `disponible` | Insérer nouvelle ligne (16/09 -> 30/09, statut `disponible`) |

> [!NOTE]
> Si la réservation commence exactement le 1er septembre (début de la plage), il n'y a que 2 segments (`reserver` du 01 au 15, `disponible` du 16 au 30).
> Si la réservation couvre toute la période du 1er au 30 septembre, la ligne unique passe directement à `reserver`.

---

## 🛠️ 2. Stratégie d'Implémentation Technique

Nous recommandons une approche double :
1. **Trigger Supabase / Fonction PL/pgSQL (Recommandé)** : Exécution atomique automatique lors de la confirmation d'une réservation.
2. **Service Dart (ReservationRepository)** : Méthode de secours ou complémentaire pour gérer les mises à jour et le rafraîchissement synchrone du state.

---

### Component 1: Base de Données & Fonction Supabase (`split_logement_disponibilite`)

#### [NEW] [01_trigger_split_disponibilites.sql](file:///c:/src/vodoohost/supabase/migrations/01_trigger_split_disponibilites.sql)
- Création de la fonction PostgreSQL `split_disponibilite_on_reservation()` qui prend `(p_logement_id, p_date_debut, p_date_fin, p_statut)`.
- Algorithme de découpage :
  1. Trouver toutes les plages de `logement_disponibilites` chevauchant `[p_date_debut, p_date_fin]`.
  2. Redimensionner ou supprimer la plage chevauchée.
  3. Réinsérer les sous-plages de restes `[dispo.date_debut, p_date_debut - 1]` et `[p_date_fin + 1, dispo.date_fin]`.
  4. Insérer la plage réservée `[p_date_debut, p_date_fin]` avec le statut `'reserver'`.

---

### Component 2: Repository & Logique Métier Flutter

#### [MODIFY] [reservation_repository.dart](file:///c:/src/vodoohost/lib/features/booking/data/repositories/reservation_repository.dart)
- Ajouter `updateDisponibilitesAfterReservation({required int logementId, required DateTime dateDebut, required DateTime dateFin})`.
- Garantir qu'après la création réussie d'une réservation (`createReservation`), le statut de la plage de dates est formellement enregistré comme `'reserver'` dans `logement_disponibilites`.

---

### Component 3: Vue Calendrier Web & Mobile pour l'Hôte

#### [NEW] [host_calendar_page.dart](file:///c:/src/vodoohost/lib/features/hosting/presentation/pages/host_calendar_page.dart)
- **Interface Hôte** : Grille mensuelle/annuelle permettant à l'hôte :
  - D'ouvrir/fermer des dates (passer de `disponible` à `indisponible` et inversement).
  - De voir en rouge les réservations enregistrées (`reserver`).
  - De fixer des tarifs spécifiques par date/période.

---

## 🧪 3. Plan de Vérification

### Tests Automatisés & Manuels
- **Cas 1 : Réservation au milieu d'une plage disponible** :
  - Disponibilité : 01 au 30 Sept.
  - Réservation : 10 au 15 Sept.
  - **Attendu** : 3 plages créées (01-09: dispo, 10-15: réservé, 16-30: dispo).
- **Cas 2 : Réservation en début de plage** :
  - Réservation : 01 au 05 Sept.
  - **Attendu** : 2 plages créées (01-05: réservé, 06-30: dispo).
- **Cas 3 : Réservation en fin de plage** :
  - Réservation : 25 au 30 Sept.
  - **Attendu** : 2 plages créées (01-24: dispo, 25-30: réservé).
- **Cas 4 : Consultation Calendrier Hôte** :
  - Vérifier que les plages réservées s'affichent correctement en rouge et bloquent toute modification par l'hôte.
