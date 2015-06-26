<?php

namespace Rhubarb\Scaffolds\RepositoryLog\Model;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlMediumText;
use Rhubarb\Stem\Repositories\MySql\Schema\Index;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlModelSchema;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\DateTime;
use Rhubarb\Stem\Schema\Columns\Decimal;
use Rhubarb\Stem\Schema\Columns\String;

class RhubarbLogEntry extends Model
{
	public function createSchema()
	{
		$schema = new MySqlModelSchema("tblRhubarbLogEntry");

		$schema->addColumn(
            new AutoIncrement("RhubarbLogEntryID"),
            new String("LogSession", "30"),
            new DateTime("EntryDate"),
            new String("Category", 50),
            new MySqlMediumText("Message"),
            new MySqlMediumText("AdditionalData"),
            new String("IpAddress", 15),
            new Decimal("ExecutionTime", 12, 4),
            new Decimal("ExecutionGapTime", 12, 4)
		);

        $schema->labelColumnName = "Message";

        $schema->addIndex(new Index("EntryDate", Index::INDEX));
        $schema->addIndex(new Index("Category", Index::INDEX));

        return $schema;
	}
}