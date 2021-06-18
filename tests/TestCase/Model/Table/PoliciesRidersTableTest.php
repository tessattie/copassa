<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PoliciesRidersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PoliciesRidersTable Test Case
 */
class PoliciesRidersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PoliciesRidersTable
     */
    protected $PoliciesRiders;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PoliciesRiders',
        'app.Policies',
        'app.Riders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PoliciesRiders') ? [] : ['className' => PoliciesRidersTable::class];
        $this->PoliciesRiders = $this->getTableLocator()->get('PoliciesRiders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PoliciesRiders);

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
