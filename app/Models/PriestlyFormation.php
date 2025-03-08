<?php

namespace App\Models;
use App\Traits\CalculatesCompletion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriestlyFormation extends Model
{
    use HasFactory, CalculatesCompletion;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'priestly_formations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'theology_start',
        'theology_end',
        'priesthood_start',
        'priesthood_end'
    ];


    /**
     * Get the user that owns the priestly formation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCompletionRate(): int
    {
        return $this->calculateCompletion([
            'theology_start' => 35,
            'theology_end' => 15,
            'priesthood_start' => 35,
            'priesthood_end' => 15
        ]);
    }
}
