<?php

declare(strict_types = 1);

namespace App\Models;

use Generator;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function alli(): Generator
    {
        $stmt = $this->db->query(
            'SELECT id, title, content
             FROM tickets'
        );

        return $this->fetchLazy($stmt);
    }
}
