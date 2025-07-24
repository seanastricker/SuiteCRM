<?php
/**
 * Account Priority Assignment Logic Hook
 * 
 * This class implements automatic priority level assignment for accounts
 * based on their annual revenue. Priority levels are assigned as follows:
 * - High Priority: Annual revenue >= $1,000,000
 * - Medium Priority: Annual revenue >= $100,000 and < $1,000,000  
 * - Low Priority: Annual revenue > $0 and < $100,000
 * - Unassigned: No revenue or invalid revenue data
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class AccountPriorityHook
{
    /**
     * Assign priority level to account based on annual revenue
     * 
     * This method runs before the account is saved and automatically
     * assigns a priority level based on the annual revenue value.
     * 
     * @param SugarBean $bean The account bean being saved
     * @param string $event The hook event (before_save)
     * @param array $arguments Additional hook arguments
     * @return void
     */
    public function assignPriorityLevel($bean, $event, $arguments)
    {
        global $sugar_config;
        
        // Only process Account beans
        if ($bean->module_name !== 'Accounts') {
            return;
        }
        
        // Get the annual revenue value
        $annual_revenue = $this->parseRevenueValue($bean->annual_revenue);
        
        // Assign priority based on revenue thresholds
        if ($annual_revenue >= 1000000) {
            $bean->priority_level_c = 'high';
        } elseif ($annual_revenue >= 100000) {
            $bean->priority_level_c = 'medium';
        } elseif ($annual_revenue > 0) {
            $bean->priority_level_c = 'low';
        } else {
            $bean->priority_level_c = 'unassigned';
        }
        
        // Log the assignment for debugging
        $GLOBALS['log']->info(
            "AccountPriorityHook: Assigned priority '{$bean->priority_level_c}' " .
            "to account '{$bean->name}' with revenue: $" . number_format($annual_revenue)
        );
    }
    
    /**
     * Parse annual revenue value from various formats
     * 
     * Handles common revenue formats like:
     * - "1000000"
     * - "$1,000,000"
     * - "1.5M"
     * - "500K"
     * 
     * @param string $revenue_string The revenue value as entered
     * @return float The parsed numeric revenue value
     */
    private function parseRevenueValue($revenue_string)
    {
        if (empty($revenue_string)) {
            return 0;
        }
        
        // Remove currency symbols, commas, and spaces
        $cleaned = preg_replace('/[\$,\s]/', '', trim($revenue_string));
        
        // Handle K (thousands) and M (millions) suffixes
        if (preg_match('/^(\d+(?:\.\d+)?)([KM])$/i', $cleaned, $matches)) {
            $number = floatval($matches[1]);
            $suffix = strtoupper($matches[2]);
            
            if ($suffix === 'K') {
                return $number * 1000;
            } elseif ($suffix === 'M') {
                return $number * 1000000;
            }
        }
        
        // Handle basic numeric values
        if (is_numeric($cleaned)) {
            return floatval($cleaned);
        }
        
        // If we can't parse it, return 0
        return 0;
    }
} 