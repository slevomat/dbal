<?php

namespace Doctrine\DBAL\Tests\Functional\Driver\SQLSrv;

use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Driver\SQLSrv\Driver;
use Doctrine\DBAL\Tests\FunctionalTestCase;

/**
 * @requires extension sqlsrv
 */
class StatementTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        if ($this->connection->getDriver() instanceof Driver) {
            return;
        }

        self::markTestSkipped('sqlsrv only test');
    }

    public function testFailureToPrepareResultsInException(): void
    {
        // use the driver connection directly to avoid having exception wrapped
        $stmt = $this->connection->getWrappedConnection()->prepare('');

        // it's impossible to prepare the statement without bound variables for SQL Server,
        // so the preparation happens before the first execution when variables are already in place
        $this->expectException(Exception::class);
        $stmt->execute();
    }
}
