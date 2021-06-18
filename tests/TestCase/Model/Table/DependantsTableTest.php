<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DependantsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DependantsTable Test Case
 */
class DependantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DependantsTable
     */
    protected $Dependants;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Dependants',
        'app.Policies',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Dependants') ? [] : ['className' => DependantsTable::class];
        $this->Dependants = $this->getTableLocator()->get('Dependants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Dependants);

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
