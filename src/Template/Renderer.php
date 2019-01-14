<?php 

declare(strict_types = 1);

namespace VirtuaGym\Template;

interface Renderer
{
    public function render($template, $data = []) : string;
}
