<?php
namespace Slub\SlubZotero\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class BibliografieTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Slub\SlubZotero\Domain\Model\Bibliografie
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Slub\SlubZotero\Domain\Model\Bibliografie();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function dummyTestToNotLeaveThisFileEmpty()
    {
        self::markTestIncomplete();
    }
}
