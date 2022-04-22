<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RenewalsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RenewalsTable Test Case
 */
class RenewalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RenewalsTable
     */
    protected $Renewals;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Renewals',
        'app.Businesses',
        'app.Groups',
        'app.Users',
        'app.Transactions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Renewals') ? [] : ['className' => RenewalsTable::class];
        $this->Renewals = $this->getTableLocator()->get('Renewals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Renewals);

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
