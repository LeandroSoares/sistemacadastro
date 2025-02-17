<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DivineMagic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'magic_type_id',
        'date',
        'performed',
        'observations'
    ];

    protected $casts = [
        'performed' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function magicType(): BelongsTo
    {
        return $this->belongsTo(MagicType::class);
    }
}
