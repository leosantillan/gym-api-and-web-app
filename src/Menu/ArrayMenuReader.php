<?php 

declare(strict_types = 1);

namespace VirtuaGym\Menu;

class ArrayMenuReader implements MenuReader
{
    public function readMenu() : array
    {
        return [
            ['href' => '/',                 'text' => 'Homepage'],
            ['href' => '/app/plans',        'text' => 'Plans'],
            ['href' => '/app/days',         'text' => 'Days'],
            ['href' => '/app/exercises',    'text' => 'Exercises'],
            ['href' => '/app/users',        'text' => 'Users'],
        ];
    }
}
