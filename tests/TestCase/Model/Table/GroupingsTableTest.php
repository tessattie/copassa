<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupingsTable Test Case
 */
class GroupingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupingsTable
     */
    protected $Groupings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Groupings',
        'app.Businesses',
        'app.Companies',
        'app.Employees',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Groupings') ? [] : ['className' => GroupingsTable::class];
        $this->Groupings = $this->getTableLocator()->get('Groupings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Groupings);

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
