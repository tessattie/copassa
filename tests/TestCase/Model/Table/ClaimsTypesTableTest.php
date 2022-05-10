<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClaimsTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClaimsTypesTable Test Case
 */
class ClaimsTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClaimsTypesTable
     */
    protected $ClaimsTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ClaimsTypes',
        'app.Claims',
        'app.Types',
        'app.Users',
        'app.Tenants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ClaimsTypes') ? [] : ['className' => ClaimsTypesTable::class];
        $this->ClaimsTypes = $this->getTableLocator()->get('ClaimsTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ClaimsTypes);

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
