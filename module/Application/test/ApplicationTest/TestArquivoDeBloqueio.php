<?php
use PHPUnit\Framework\TestCase;

class TestArquivoDeBloqueio extends TestCase
{
    public function testFailure()
    {
        $caminho = __DIR__;
        $caminho = str_replace('/module/Application/test/ApplicationTest','',$caminho);
        $this->assertFileNotExists($caminho . '/docs/tutorial.odp#');
    }
}
?>