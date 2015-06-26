<?php

namespace Rhubarb\Scaffolds\RepositoryLog;

use Rhubarb\Crown\Module;
use Rhubarb\Stem\Schema\SolutionSchema;

class RepositoryLogModule extends Module
{
    protected function initialise()
    {
        parent::initialise();

        SolutionSchema::registerSchema("RepositoryLog", Model\RepositoryLogSchema::class);
    }
}