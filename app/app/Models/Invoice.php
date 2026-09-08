<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $table = 'invoices';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'numero',
        'concepto',
        'importe',
        'pdf_path',
        'created_at',
    ];

    protected $casts = [
        'importe' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
