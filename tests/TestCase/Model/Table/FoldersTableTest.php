<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FoldersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FoldersTable Test Case
 */
class FoldersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FoldersTable
     */
    protected $Folders;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Folders',
        'app.Users',
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
        $config = $this->getTableLocator()->exists('Folders') ? [] : ['className' => FoldersTable::class];
        $this->Folders = $this->getTableLocator()->get('Folders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Folders);

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
