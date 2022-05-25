<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReplyModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reply';
    use HasFactory;

    public function replies()
    {
        return $this->hasMany(ReplyReply::class, 'reply_id', 'id' );
    }

    protected $fillable = [
        "discussion_id",
        "status",
        'name',
        "content"
    ];
}