<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FoldersFilesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FoldersFilesTable Test Case
 */
class FoldersFilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FoldersFilesTable
     */
    protected $FoldersFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.FoldersFiles',
        'app.Folders',
        'app.Files',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FoldersFiles') ? [] : ['className' => FoldersFilesTable::class];
        $this->FoldersFiles = $this->getTableLocator()->get('FoldersFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FoldersFiles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
