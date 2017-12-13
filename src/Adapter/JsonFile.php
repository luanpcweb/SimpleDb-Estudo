<?php

namespace Luanpcweb\SimpleDb\Adapter;


class JsonFile
{
    /**
     * @var string
     */
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function read()
    {
        $contents = @file_get_contents($this->file);

        if ($contents === false){
            throw new \RuntimeException(
                sprintf('File "%s" could not be read', $this->file)
            );
        }

        $data = json_decode($contents, true);

        if (!is_array($data)){
            throw new \RuntimeException(
                sprintf('Content of file "%s" is not valid json', $this->file)
            );
        }
        return $data;
    }
}