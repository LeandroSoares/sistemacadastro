<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function personalData(): HasOne
    {
        return $this->hasOne(PersonalData::class);
    }

    public function religiousInfo(): HasOne
    {
        return $this->hasOne(ReligiousInfo::class);
    }

    public function priestlyFormation(): HasOne
    {
        return $this->hasOne(PriestlyFormation::class);
    }

    public function crowning(): HasOne
    {
        return $this->hasOne(Crowning::class);
    }

    public function headOrisha(): HasOne
    {
        return $this->hasOne(HeadOrisha::class);
    }

    public function forceCross(): HasOne
    {
        return $this->hasOne(ForceCross::class);
    }

    public function workGuide(): HasOne
    {
        return $this->hasOne(WorkGuide::class);
    }

    public function lastTemple(): HasOne
    {
        return $this->hasOne(LastTemple::class);
    }

    public function crossings(): HasMany
    {
        return $this->hasMany(Crossing::class);
    }

    public function religiousCourses(): HasMany
    {
        return $this->hasMany(ReligiousCourse::class);
    }

    public function initiatedMysteries(): HasMany
    {
        return $this->hasMany(InitiatedMystery::class);
    }

    public function initiatedOrishas(): HasMany
    {
        return $this->hasMany(InitiatedOrisha::class);
    }

    public function divineMagics(): HasMany
    {
        return $this->hasMany(DivineMagic::class);
    }

    public function entityConsecrations(): HasMany
    {
        return $this->hasMany(EntityConsecration::class);
    }

    public function amacis(): HasMany
    {
        return $this->hasMany(Amaci::class);
    }

    protected const SECTION_WEIGHTS = [
        'personalData' => 20,
        'religiousInfo' => 15,
        'priestlyFormation' => 10,
        'headOrisha' => 15,
        'workGuide' => 15,
        'forceCross' => 10,
        'initiatedOrishas' => 15
    ];

    public function calculateProfileProgress(): int
    {
        $totalProgress = 0;

        foreach (self::SECTION_WEIGHTS as $relation => $weight) {
            $totalProgress += $this->calculateSectionProgress($relation, $weight);
        }

        return round($totalProgress);
    }

    protected function calculateSectionProgress(string $relation, int $weight): float
    {
        $model = $this->$relation;
        
        if ($relation === 'initiatedOrishas') {
            return ($this->$relation()->count() > 0 ? 100 : 0) * $weight / 100;
        }
        
        if ($model && method_exists($model, 'getCompletionRate')) {
            return $model->getCompletionRate() * $weight / 100;
        }
        
        return 0;
    }
}
