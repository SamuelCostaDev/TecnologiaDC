<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sobrenome',
        'fone',
        'documento', // Pode ser CPF ou CNPJ
        'rg',
        'endereco',
        'complemento',
        'cidade',
        'estado',
        'cep',
    ];

    // Outras definições de relacionamentos, se houver

}
