<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuthorizationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuthorizationsTable Test Case
 */
class AuthorizationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuthorizationsTable
     */
    protected $Authorizations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Authorizations',
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
        $config = $this->getTableLocator()->exists('Authorizations') ? [] : ['className' => AuthorizationsTable::class];
        $this->Authorizations = $this->getTableLocator()->get('Authorizations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Authorizations);

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
}
