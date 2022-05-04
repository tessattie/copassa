<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrenewalsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrenewalsTable Test Case
 */
class PrenewalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrenewalsTable
     */
    protected $Prenewals;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Prenewals',
        'app.Policies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Prenewals') ? [] : ['className' => PrenewalsTable::class];
        $this->Prenewals = $this->getTableLocator()->get('Prenewals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Prenewals);

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
