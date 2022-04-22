<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PendingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PendingsTable Test Case
 */
class PendingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PendingsTable
     */
    protected $Pendings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Pendings',
        'app.Companies',
        'app.Options',
        'app.Countries',
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
        $config = $this->getTableLocator()->exists('Pendings') ? [] : ['className' => PendingsTable::class];
        $this->Pendings = $this->getTableLocator()->get('Pendings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Pendings);

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
