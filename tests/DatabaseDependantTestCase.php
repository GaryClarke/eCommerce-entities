<?php

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class DatabaseDependantTestCase extends TestCase
{
    /** @var EntityManager */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        require 'bootstrap-test.php';

        $this->entityManager = $entityManager;

        SchemaLoader::load($entityManager);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }


    public function assertDatabaseHas(string $tablename, array $criteria)
    {
        $sqlParameters = $keys = array_keys($criteria);

        $firstColumn = array_shift($sqlParameters);

        $sql = "SELECT 1 from {$tablename} WHERE {$firstColumn} = :{$firstColumn}";

        foreach ($sqlParameters as $column) {

            $sql .= " AND {$column} = :{$column}";
        }

        $conn = $this->entityManager->getConnection();
        $stmt = $conn->prepare($sql);

        foreach($keys as $key) {

            $stmt->bindValue($key, $criteria[$key]);
        }

        $keyValuesString = $this->asKeyValuesString($criteria);

        $failureMessage = "A record could not be found in the $tablename table with the following attributes: {$keyValuesString}";

        $result = $stmt->executeQuery();

        $this->assertTrue((bool) $result->fetchOne(), $failureMessage);
    }


    public function assertDatabaseHasEntity(string $entityName, array $criteria)
    {
        $result = $this->entityManager->getRepository($entityName)->findOneBy($criteria);

        $keyValuesString = $this->asKeyValuesString($criteria);

        $failureMessage = "A $entityName record could not be found with the following attributes: {$keyValuesString}";

        $this->assertTrue((bool) $result, $failureMessage);
    }


    public function assertDatabaseNotHas(string $entityName, array $criteria)
    {
        $result = $this->entityManager->getRepository($entityName)->findOneBy($criteria);

        $keyValuesString = $this->asKeyValuesString($criteria);

        $failureMessage = "A $entityName record WAS found with the following attributes: {$keyValuesString}";

        $this->assertFalse((bool) $result, $failureMessage);
    }


    public function asKeyValuesString(array $criteria, $separator = ' = '): string
    {
        $mappedAttributes = array_map(function($key, $value) use ($separator) {

            if ($value instanceof \DateTimeInterface) {

                $value = $value->format('Y-m-d');
            }

            return $key . $separator . $value;

        }, array_keys($criteria), $criteria);

        return implode(', ', $mappedAttributes);
    }
}






