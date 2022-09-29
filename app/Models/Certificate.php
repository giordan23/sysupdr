<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    // protected $guarded;
    protected $fillable = [
        'title',
        'program',
        'faculty',
        'originality',
        'similitude',
        'date',
        'document_number',
        // 'code',
        'observation',
        'second_author_id'
    ];
    public function authors()
    {
        return $this->belongsTo(Author::class,'author_id');
    }
    public function advisers()
    {
        return $this->belongsTo(Adviser::class,'adviser_id');
    }
    public function authorSecond()
    {
        return $this->belongsTo(Author::class,'second_author_id');
    }
}
