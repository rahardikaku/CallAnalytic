<?php

declare(strict_types=1);

namespace OCA\CallAnalytic\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\DB\Types;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

class Version010000Date20231106080600 extends SimpleMigrationStep {

    /**
     * @param IOutput $output
     * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
     * @param array $options
     */
    public function preSchemaChange(IOutput $output, Closure $schemaClosure, array $options) {
    }

    /**
     * @param IOutput $output
     * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
     * @param array $options
     * @return null|ISchemaWrapper
     */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('call_count')) {
            $table = $schema->createTable('call_count');
            $table->addColumn('id', Types::BIGINT, [
                'autoincrement' => true,
                'notnull' => true,
                'length' => 4,
            ]);
            $table->addColumn('actor_id', Types::STRING, [
                'notnull' => true,
                'length' => 64,
            ]);
			$table->addColumn('count_in', Types::BIGINT, [
                'notnull' => true,
                'length' => 4,
            ]);
			$table->addColumn('count_out', Types::BIGINT, [
                'notnull' => true,
                'length' => 4,
            ]);
			$table->addColumn('count_total', Types::BIGINT, [
                'notnull' => true,
                'length' => 4,
            ]);
			$table->addColumn('tanggal', Types::DATE, [
                'notnull' => true,
                'length' => 4,
            ]);
			$table->addColumn('is_total', Types::BOOLEAN, [
                'notnull' => false,
				'default' => false,
                'length' => 1,
            ]);
            
            $table->setPrimaryKey(['id']);
            $table->addIndex(['actor_id'], 'callanalytic_uid');
        }

        return $schema;
    }

    /**
     * @param IOutput $output
     * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
     * @param array $options
     */
    public function postSchemaChange(IOutput $output, Closure $schemaClosure, array $options) {
    }
}