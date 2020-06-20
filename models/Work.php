<?php
namespace Models;

use Core\Model;

class Work extends Model {

    static private $instance;
    
    protected $table = 'works';

    protected $fillable = [
        'work_name',
        'start_date',
        'end_date',
        'status',
    ];

    const STATUS = [
        1 => 'Planning',
        2 => 'Doing',
        3 => 'Complete',
    ];
    
    protected $primaryKey = 'id';

    static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
