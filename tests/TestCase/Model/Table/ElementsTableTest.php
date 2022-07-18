<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ElementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ElementsTable Test Case
 */
class ElementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ElementsTable
     */
    protected $Elements;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Elements',
        'app.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Elements') ? [] : ['className' => ElementsTable::class];
        $this->Elements = $this->getTableLocator()->get('Elements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Elements);

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
