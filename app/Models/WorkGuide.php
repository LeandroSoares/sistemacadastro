<?php

namespace App\Models;

use App\Traits\CalculatesCompletion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkGuide extends Model
{
    use HasFactory, CalculatesCompletion;

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

    public function getCompletionRate(): int
    {
        return $this->calculateCompletion([
            'caboclo' => 6,
            'cabocla' => 6,
            'ogum' => 6,
            'xango' => 6,
            'baiano' => 6,
            'baiana' => 6,
            'preto_velho' => 6,
            'preta_velha' => 6,
            'boiadeiro' => 6,
            'boiadeira' => 6,
            'cigano' => 6,
            'cigana' => 6,
            'marinheiro' => 6,
            'ere' => 6,
            'exu' => 6,
            'pombagira' => 5,
            'exu_mirim' => 5
        ]);
    }
}
