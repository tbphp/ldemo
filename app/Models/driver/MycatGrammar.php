<?php

namespace App\Models\driver;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Support\Fluent;

class MycatGrammar extends MySqlGrammar
{
    /**
     * Append the character set specifications to a command.
     *
     * @param string $sql
     * @param Connection $connection
     * @param Blueprint $blueprint
     * @return string
     */
    protected function compileCreateEncoding($sql, Connection $connection, Blueprint $blueprint): string
    {
        if (isset($blueprint->charset)) {
            $sql .= ' default character set ' . $blueprint->charset;
        } elseif (!is_null($charset = $connection->getConfig('charset'))) {
            $sql .= ' default character set ' . $charset;
        }

        if (isset($blueprint->collation)) {
            $sql .= " collate {$blueprint->collation}";
        } elseif (!is_null($collation = $connection->getConfig('collation'))) {
            $sql .= " collate {$collation}";
        }

        return $sql;
    }

    public function compilePrimary(Blueprint $blueprint, Fluent $command): string
    {
        $command->name(null);

        return sprintf('alter table %s add %s %s(%s)',
            $this->wrapTable($blueprint),
            'primary key',
            // $this->wrap($command->index),
            $command->algorithm ? ' using '.$command->algorithm : '',
            $this->columnize($command->columns)
        );

    }
}
