<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CountriesAgentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CountriesAgentsTable Test Case
 */
class CountriesAgentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CountriesAgentsTable
     */
    protected $CountriesAgents;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CountriesAgents',
        'app.Countries',
        'app.Agents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CountriesAgents') ? [] : ['className' => CountriesAgentsTable::class];
        $this->CountriesAgents = $this->getTableLocator()->get('CountriesAgents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CountriesAgents);

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
