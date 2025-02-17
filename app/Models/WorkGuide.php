<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkGuide extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_guides';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'caboclo',
        'cabocla',
        'ogum',
        'xango',
        'baiano',
        'baiana',
        'preto_velho',
        'preta_velha',
        'boiadeiro',
        'boiadeira',
        'cigano',
        'cigana',
        'marinheiro',
        'ere',
        'exu',
        'pombagira',
        'exu_mirim'
    ];

    /**
     * Get the user that owns the work guide.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
