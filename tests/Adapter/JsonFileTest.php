<?php
namespace Luanpcweb\SimpleDb\Adapter;

use PHPUnit\Framework\TestCase;
use Luanpcweb\SimpleDb\Adapter\JsonFile;

class JsonFileTest extends TestCase
{
    /** @var JsonFile */
    protected $adapter;

    public function setUp()
    {
        @unlink('/tmp/posts.json');
        $this->adapter = new JsonFile('/tmp/posts.json');
    }

    /**
     * @test
     */
    public function canReadDataFromJsonFile()
    {
        $content = '{"for": "bar"}';
        file_put_contents("/tmp/posts.json", $content);

        $expected = array('for' => 'bar');
        $result = $this->adapter->read();

        $this->assertEquals($expected, $result);
    }
    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage File "/tmp/posts.json" could not be read
     */
    public function throwsAnExceptionWhenFileCannotBeRead()
    {
        @unlink("/tmp/posts.json");
        $this->adapter->read();
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Content of file "/tmp/posts.json" is not valid json
     */
    public function throwsAndExceptionWhenDataCannotBeConvertedToArray()
    {
        file_put_contents("/tmp/posts.json", "invalid json");
        $this->adapter->read();
    }
}