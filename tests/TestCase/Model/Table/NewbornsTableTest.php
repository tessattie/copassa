<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NewbornsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NewbornsTable Test Case
 */
class NewbornsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NewbornsTable
     */
    protected $Newborns;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Newborns',
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
        $config = $this->getTableLocator()->exists('Newborns') ? [] : ['className' => NewbornsTable::class];
        $this->Newborns = $this->getTableLocator()->get('Newborns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Newborns);

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
