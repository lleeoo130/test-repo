<?php

namespace App\Entity\Parser;

use Symfony\Component\HttpFoundation\ParameterBag;

class MazeConfigurationParser
{
    public function parse(ParameterBag $parameterBag): array
    {
        $result = [];
        foreach ($parameterBag as $key => $value) {
            $keyRegex = 'maze_configuration_';

            if (str_contains($key, $keyRegex)) {
                $result[str_replace($keyRegex, '', $key)] = $value;
            }
        }

        return $result;
    }
}