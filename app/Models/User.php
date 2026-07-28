<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\Sousmenu;
use App\Models\Notification;
use App\Models\Logement;
use App\Models\UserPreference;
use App\Models\Report;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
    ];



    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'langue' => 'array',
        'passions' => 'array',
    ];

    /**
     * Relation avec les réservations de l'utilisateur
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get all notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'destinataire_id');
    }

    /**
     * Get the user's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Vérifie si l'utilisateur a complété le questionnaire de préférences
     *
     * @return bool
     */
    public function hasCompletedQuestionnaire()
    {
        return $this->preferences && !empty($this->preferences->divinites_preferees);
    }

    /**
     * Get the user's preferences.
     */
    public function preferences()
    {
        return $this->hasOne(UserPreference::class);
    }

    public function notificationPreferences()
    {
        return $this->hasOne(NotificationPreference::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $user->notificationPreferences()->create([]);
        });
    }


    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Avis reçus (en tant qu’hôte / trad / photographe)
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'target_user_id');
    }


  
    public function averageRating(): ?float
    {
        return $this->reviewsReceived()->avg('rating');
    }

    /**
     * Nombre total d'avis reçus
     */
    public function reviewsCount(): int
    {
        return $this->reviewsReceived()->count();
    }



    // Méthode pour la photo de profil
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->photo) {
            return Storage::url($this->photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nom . ' ' . $this->prenom) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions($routeName)
    {
        if (!$this->role) {
            return false;
        }

        // Accès complet pour les rôles d'administration
        if (in_array(strtolower($this->role->name ?? ''), ['admin', 'superadmin', 'administrateur'])) {
            return true;
        }

        if (!$routeName) {
            return true;
        }

        $listAcces = Sousmenu::join('role_permissions', 'sousmenus.id', '=', 'role_permissions.sousmenu_id')
            ->where('role_permissions.role_id', $this->role->id)
            ->whereRaw('role_permissions.is_granted IS TRUE')
            ->pluck('sousmenus.url')
            ->filter()
            ->toArray();

        // 1. Accès direct si le nom de route exact est autorisé
        if (in_array($routeName, $listAcces)) {
            return true;
        }

        // 2. Vérification pour les sous-routes de ressources (ex: hoost.logements.index autorise hoost.logements.create, edit, show, etc.)
        $baseRoute = implode('.', array_slice(explode('.', $routeName), 0, -1));
        if ($baseRoute) {
            foreach ($listAcces as $grantedRoute) {
                if ($grantedRoute === $baseRoute || str_starts_with($grantedRoute, $baseRoute . '.')) {
                    return true;
                }
            }
        }

        return false;
    }

    public function logements()
    {
        return $this->hasMany(Logement::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
}
