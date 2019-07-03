<?php
namespace SLUB\SlubZotero\Tests\Unit\Controller;

/**
 * Test case.
 */
class BibliografieControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \SLUB\SlubZotero\Controller\BibliografieController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\SLUB\SlubZotero\Controller\BibliografieController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenBibliografieToView()
    {
        $bibliografie = new \SLUB\SlubZotero\Domain\Model\Bibliografie();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('bibliografie', $bibliografie);

        $this->subject->showAction($bibliografie);
    }
}
