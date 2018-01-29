<?php
namespace Luanpcweb\SimpleDb\Adapter;

use PHPUnit\Framework\TestCase;
use Luanpcweb\SimpleDb\Adapter\JsonFile;
use PHPUnit\Util\Json;

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
    public function implementsAdapterInterface()
    {
        $this->assertInstanceOf('Luanpcweb\SimpleDb\Adapter\AdapterInterface', $this->adapter);
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

    /**
     * @test
     */
    public function canSaveDataToJsonFile()
    {
        $data = array('foo' => 'bar');
        $this->adapter->write($data);

        $expected = '{"foo":"bar"}';
        $actual = file_get_contents("/tmp/posts.json");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage File "/posts.json" could not be written
     */
    public function throwsExceptionWhenFileCannotBeSaved()
    {
        $this->adapter = new JsonFile('/posts.json');
        $this->adapter->write(array());
    }

    /**
     * @test
    */
   public function readReturnsEmptyArrayWhenFileIsEmpty()
   {
        @unlink('/tmp/posts.json');
        exec('touch /tmp/posts.json');

        $this->adapter =  new JsonFile('/tmp/posts.json');
        $data = $this->adapter->read();

        $this->assertEquals(array(), $data);
   }

}
