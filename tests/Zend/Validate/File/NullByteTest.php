<?php
/**
 * Paths containing NUL bytes must be reported as validation failures. PHP 8.6 throws a
 * ValueError from the file functions (is_readable(), file_exists(), ...) for such paths.
 */

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

#[Group('Zend_Validate')]
class Zend_Validate_File_NullByteTest extends PHPUnit\Framework\TestCase
{
    /**
     * @return array<string, array{0: Zend_Validate_Interface}>
     */
    public static function readableValidators(): array
    {
        return array(
            'Crc32'            => array(new Zend_Validate_File_Crc32('3f8d07e2')),
            'ExcludeExtension' => array(new Zend_Validate_File_ExcludeExtension('gif')),
            'ExcludeMimeType'  => array(new Zend_Validate_File_ExcludeMimeType('image/gif')),
            'Extension'        => array(new Zend_Validate_File_Extension('gif')),
            'FilesSize'        => array(new Zend_Validate_File_FilesSize(1000)),
            'Hash'             => array(new Zend_Validate_File_Hash('3f8d07e2')),
            'ImageSize'        => array(new Zend_Validate_File_ImageSize(array('minwidth' => 1))),
            'IsCompressed'     => array(new Zend_Validate_File_IsCompressed('application/zip')),
            'IsImage'          => array(new Zend_Validate_File_IsImage('image/gif')),
            'Md5'              => array(new Zend_Validate_File_Md5('3f8d07e2')),
            'MimeType'         => array(new Zend_Validate_File_MimeType('image/gif')),
            'Sha1'             => array(new Zend_Validate_File_Sha1('3f8d07e2')),
            'Size'             => array(new Zend_Validate_File_Size(1000)),
            'WordCount'        => array(new Zend_Validate_File_WordCount(1)),
        );
    }

    #[DataProvider('readableValidators')]
    public function testFileNameWithNulByteIsInvalid(Zend_Validate_Interface $validator): void
    {
        $this->assertFalse($validator->isValid("image\0.gif"));
    }

    public function testExistsWithNulByteIsInvalid(): void
    {
        $validator = new Zend_Validate_File_Exists(__DIR__);
        $this->assertFalse($validator->isValid("image\0.gif"));
    }

    public function testNotExistsWithNulByteIsValid(): void
    {
        $validator = new Zend_Validate_File_NotExists(__DIR__);
        $this->assertTrue($validator->isValid("image\0.gif"));
    }

    public function testMagicFileWithNulByteIsRejected(): void
    {
        if (!class_exists('finfo', false)) {
            $this->markTestSkipped('finfo extension is not available');
        }
        $validator = new Zend_Validate_File_MimeType('image/gif');
        $this->expectException(Zend_Validate_Exception::class);
        $validator->setMagicFile("magic\0file");
    }
}
