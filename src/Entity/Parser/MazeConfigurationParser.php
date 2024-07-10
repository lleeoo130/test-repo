<?php

namespace App\Entity\Parser;

use Symfony\Component\HttpFoundation\ParameterBag;

class MazeConfigurationParser
{
    public function parse(ParameterBag $parameterBag): array
    {
        $result = [];
        $keyRegex = 'configuration_';

        foreach ($parameterBag->all()['maze_configuration'] as $key => $value) {

            if (str_contains($key, $keyRegex)) {
                $result[str_replace($keyRegex, '', $key)] = $value;
            }
        }

        return $result;
    }
}