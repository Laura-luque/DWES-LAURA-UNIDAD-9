<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Comment extends Eloquent
{
    protected $table = 'comment';

    protected $fillable = [
        'id', 'blog_id', 'user', 'comment', 'approved', 'created', 'updated'
    ];

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }


}