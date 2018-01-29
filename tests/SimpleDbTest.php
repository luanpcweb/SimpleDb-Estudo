<?php
namespace Luanpcweb\SimpleDb;

use Luanpcweb\SimpleDb\Adapter\AdapterInterface;
use Luanpcweb\SimpleDb\SimpleDb;
use PHPUnit\Framework\TestCase;


class SimpleDbTest extends TestCase
{
    /** @var SimpleDb */
    protected $db;

    /** @var AdapterInterface */
    protected $adapter;

    public function setUp()
    {
        $this->adapter = $this->createMock('Luanpcweb\SimpleDb\Adapter\AdapterInterface');
        $this->db = new SimpleDb($this->adapter);
    }

    /**
     * @test
    */
    public function findAllReturnsEmptyWhenNoRecordsExist()
    {

        $this->adapter
            ->expects($this->once())
            ->method('read')
            ->will($this->returnValue([]));

        $data = $this->db->findAll();
        $this->assertEquals([], $data);
    }

    /**
     * @test
    */
   public function findAllReturnsCollectionFromTheAdapter()
   {
        $adapterData = [
            'data' => [
                ['foo' => 'bar']
            ],
        ];

        $this->adapter->expects($this->once())
            ->method('read')
            ->willReturn($adapterData);

        $expected = [
            ['foo' => 'bar']
        ];
        $data = $this->db->findAll();
        $this->assertEquals($expected, $data);
   }
}
