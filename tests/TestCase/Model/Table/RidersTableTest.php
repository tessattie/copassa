<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RidersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RidersTable Test Case
 */
class RidersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RidersTable
     */
    protected $Riders;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Riders',
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
        $config = $this->getTableLocator()->exists('Riders') ? [] : ['className' => RidersTable::class];
        $this->Riders = $this->getTableLocator()->get('Riders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Riders);

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
