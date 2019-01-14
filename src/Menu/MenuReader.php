<?php 

declare(strict_types = 1);

namespace VirtuaGym\Menu;

interface MenuReader
{
    public function readMenu() : array;
}
