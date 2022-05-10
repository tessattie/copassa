<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClaimsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClaimsTable Test Case
 */
class ClaimsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClaimsTable
     */
    protected $Claims;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Claims',
        'app.Policies',
        'app.Users',
        'app.Tenants',
        'app.Types',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Claims') ? [] : ['className' => ClaimsTable::class];
        $this->Claims = $this->getTableLocator()->get('Claims', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Claims);

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
