<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Factory\Odm;

use DemoApiContext\Domain\Service\Actor\Factory\Odm\RepositoryFactory;
use DemoApiContext\Infrastructure\Persistence\Repository\Actor\Odm\{
    GetAllRepository, DeleteManyRepository, DeleteOneRepository, GetByIdsRepository, GetOneRepository, SaveRepository,
    SearchByRepository
};
use Doctrine\ODM\MongoDB\DocumentManager;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Factory\RepositoryFactoryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Repository\RepositoryInterface;

/**
 * Class RepositoryFactoryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Factory\Odm
 *
 * @coversDefaultClass RepositoryFactoryInterface
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class RepositoryFactoryTest extends TestCase
{
    /** @var RepositoryFactory $factory */
    protected $factory;

    /**
     * @var Phake_IMock $dm Mock instance of DocumentManager.
     * @see DocumentManager
     */
    protected $dm;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this::markTestIncomplete();
        $this->dm = Phake::mock(DocumentManager::class);
        $this->factory = new RepositoryFactory($this->dm);
    }

    /**
     * Initiates dataSet.
     *
     * @return array
     */
    public function dataSet(): array
    {
        return [
            [RepositoryFactoryInterface::GET_ONE_REPOSITORY, GetOneRepository::class],
            [RepositoryFactoryInterface::GET_ALL_REPOSITORY, GetAllRepository::class],
            [RepositoryFactoryInterface::GET_BY_IDS_REPOSITORY, GetByIdsRepository::class],
            [RepositoryFactoryInterface::DELETE_ONE_REPOSITORY, DeleteOneRepository::class],
            [RepositoryFactoryInterface::DELETE_MANY_REPOSITORY, DeleteManyRepository::class],
            [RepositoryFactoryInterface::SAVE_REPOSITORY, SaveRepository::class],
            [RepositoryFactoryInterface::SEARCH_BY_REPOSITORY, SearchByRepository::class]
        ];
    }

    /**
     * Tests BuildRepository method
     *
     * @covers ::buildRepository()
     *
     * @param $key
     * @param $class
     *
     * @throws Exception
     * @throws \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException
     * @dataProvider dataSet
     */
    public function testBuildRepository($key, $class): void
    {
        $repository = $this->factory->buildRepository($key);
        static::assertInstanceOf($class, $repository);
        static::assertInstanceOf(RepositoryInterface::class, $repository);
    }

    /**
     * Firing failing process
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException
     */
    public function testWrongKey(): void
    {
        $this->factory->buildRepository('WRONG_KEY');
    }
}
