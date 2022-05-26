<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discussion';
    use HasFactory;

    protected $fillable = [
        'title',
        "category_id",
        "status",
        "slug",
        "content",
        "name"
    ];


    public function category()
    {
        return $this->hasOne(CategoryModel::class, 'id', 'category_id');
    }
}