<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personal_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'zip_code',
        'email',
        'cpf',
        'rg',
        'age',
        'home_phone',
        'mobile_phone',
        'work_phone',
        'emergency_contact'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age' => 'integer'
    ];

    /**
     * Get the user that owns the personal data.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
