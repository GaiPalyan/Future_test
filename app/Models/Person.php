<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'full_name',
        'birthday',
        'photo',
        'company_id',
        'created_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'person_id', 'id');
    }

    public function company(): BelongsTo
    {
        return  $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
