<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PoliciesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PoliciesTable Test Case
 */
class PoliciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PoliciesTable
     */
    protected $Policies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Policies',
        'app.Companies',
        'app.Options',
        'app.Customers',
        'app.Users',
        'app.Payments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Policies') ? [] : ['className' => PoliciesTable::class];
        $this->Policies = $this->getTableLocator()->get('Policies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Policies);

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
