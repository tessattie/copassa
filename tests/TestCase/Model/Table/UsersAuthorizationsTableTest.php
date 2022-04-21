<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersAuthorizationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersAuthorizationsTable Test Case
 */
class UsersAuthorizationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersAuthorizationsTable
     */
    protected $UsersAuthorizations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UsersAuthorizations',
        'app.Users',
        'app.Authorizations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UsersAuthorizations') ? [] : ['className' => UsersAuthorizationsTable::class];
        $this->UsersAuthorizations = $this->getTableLocator()->get('UsersAuthorizations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UsersAuthorizations);

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
