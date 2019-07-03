<?php
namespace SLUB\SlubZotero\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class BibliografieTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \SLUB\SlubZotero\Domain\Model\Bibliografie
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \SLUB\SlubZotero\Domain\Model\Bibliografie();
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
