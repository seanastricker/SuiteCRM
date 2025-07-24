<?php
/**
 * Account Priority Hook Unit Tests
 * 
 * This test class verifies the functionality of the AccountPriorityHook
 * class, ensuring that priority levels are correctly assigned based on
 * annual revenue values.
 * 
 * @package SuiteCRM
 * @subpackage Tests
 */

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AccountPriorityHookTest extends SuitePHPUnitFrameworkTestCase
{
    /**
     * @var AccountPriorityHook
     */
    private $hook;
    
    /**
     * @var Account
     */
    private $account;
    
    /**
     * Set up test environment
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Load required classes
        require_once 'custom/modules/Accounts/AccountPriorityHook.php';
        
        // Initialize hook and mock account
        $this->hook = new AccountPriorityHook();
        $this->account = $this->createMockAccount();
    }
    
    /**
     * Create a mock Account object for testing
     * 
     * @return Account
     */
    private function createMockAccount()
    {
        $account = BeanFactory::newBean('Accounts');
        $account->module_name = 'Accounts';
        $account->name = 'Test Account';
        $account->annual_revenue = '';
        $account->priority_level_c = '';
        
        return $account;
    }
    
    /**
     * Test high priority assignment (>= $1M)
     */
    public function testHighPriorityAssignment()
    {
        $this->account->annual_revenue = '1500000';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('high', $this->account->priority_level_c);
    }
    
    /**
     * Test medium priority assignment ($100K - $999K)
     */
    public function testMediumPriorityAssignment()
    {
        $this->account->annual_revenue = '500000';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('medium', $this->account->priority_level_c);
    }
    
    /**
     * Test low priority assignment ($1 - $99K)
     */
    public function testLowPriorityAssignment()
    {
        $this->account->annual_revenue = '50000';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('low', $this->account->priority_level_c);
    }
    
    /**
     * Test unassigned priority for zero or empty revenue
     */
    public function testUnassignedPriorityForZeroRevenue()
    {
        $this->account->annual_revenue = '0';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('unassigned', $this->account->priority_level_c);
    }
    
    /**
     * Test unassigned priority for empty revenue
     */
    public function testUnassignedPriorityForEmptyRevenue()
    {
        $this->account->annual_revenue = '';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('unassigned', $this->account->priority_level_c);
    }
    
    /**
     * Test revenue parsing with currency symbols
     */
    public function testRevenueParsingWithCurrencySymbols()
    {
        $this->account->annual_revenue = '$1,500,000';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('high', $this->account->priority_level_c);
    }
    
    /**
     * Test revenue parsing with K suffix
     */
    public function testRevenueParsingWithKSuffix()
    {
        $this->account->annual_revenue = '500K';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('medium', $this->account->priority_level_c);
    }
    
    /**
     * Test revenue parsing with M suffix
     */
    public function testRevenueParsingWithMSuffix()
    {
        $this->account->annual_revenue = '1.5M';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('high', $this->account->priority_level_c);
    }
    
    /**
     * Test that only Account beans are processed
     */
    public function testOnlyAccountBeansAreProcessed()
    {
        $this->account->module_name = 'Contacts';
        $this->account->annual_revenue = '1000000';
        
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        // Priority should not be set for non-Account beans
        $this->assertEquals('', $this->account->priority_level_c);
    }
    
    /**
     * Test edge case: exactly $1M should be high priority
     */
    public function testExactlyOneMillion()
    {
        $this->account->annual_revenue = '1000000';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('high', $this->account->priority_level_c);
    }
    
    /**
     * Test edge case: exactly $100K should be medium priority
     */
    public function testExactlyOneHundredThousand()
    {
        $this->account->annual_revenue = '100000';
        $this->hook->assignPriorityLevel($this->account, 'before_save', []);
        
        $this->assertEquals('medium', $this->account->priority_level_c);
    }
} 