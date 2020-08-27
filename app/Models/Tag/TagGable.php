<?php

namespace App\Models\Tag;

use Illuminate\Database\Eloquent\Model;

class TagGable extends Model
{
    const TABLE = 'sw_tag_gables';

    protected $table = self::TABLE;

    const TYPE_ARTICLE = 'article';

    public static $typeMap = [
        self::TYPE_ARTICLE => '文章',
    ];

    protected $fillable = [
        'tag_id',
        'sw_tag_gables_id',
        'sw_tag_gables_type',
    ];

    public function tag_gable()
    {
        return $this->morphTo($this->table);
    }

    public function tags()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
