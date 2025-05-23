<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Contact extends Model
{
    use HasFactory;

    protected $fillable =[
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getGenderLabelAttribute()
    {
        return match ($this->gender) {
            1 => '男性',
            2 => '女性',
            3 => 'その他',
            default => '不明',
        };
    }

}
