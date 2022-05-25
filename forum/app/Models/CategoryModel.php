<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';
    use HasFactory;

    public function main_category()
    {
        return $this->hasOne(CategoryModel::class, 'id', 'parent_id');
    }


}