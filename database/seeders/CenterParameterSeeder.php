<?php

namespace Database\Seeders;

use App\Models\CenterParameter;
use App\Models\CenterParameterValues;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('center_parameters')->insert([
            ['center_id' => 1, 'key' => 'vat', 'name' => 'VAT Enabled?', 'value' => 1, 'type' => 'boolean', 'group' => 'vat', 'required' => 1, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'vat_percentage', 'name' => 'VAT %', 'value' => 1, 'type' => 'number', 'group' => 'vat', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'vat_reg_number', 'name' => 'VAT Reg No', 'value' => null, 'type' => 'text', 'group' => 'vat', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'trn_number', 'name' => 'TRN No', 'value' => null, 'type' => 'text', 'group' => 'vat', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'trade_license', 'name' => 'Trade License', 'value' => null, 'type' => 'text', 'group' => 'vat', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'show_bank_details', 'name' => 'Show Bank Info on Invoice', 'value' => 1, 'type' => 'boolean', 'group' => 'bank', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'bank_name', 'name' => 'Bank Name', 'value' => null, 'type' => 'text', 'group' => 'bank', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'account_name', 'name' => 'Account Name', 'value' => null, 'type' => 'text', 'group' => 'bank', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'account_number', 'name' => 'Account Number', 'value' => null, 'type' => 'text', 'group' => 'bank', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'ibn_number', 'name' => 'IBN Number', 'value' => null, 'type' => 'text', 'group' => 'bank', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'bank_branch', 'name' => 'Bank Branch', 'value' => null, 'type' => 'text', 'group' => 'bank', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'swift_code', 'name' => 'Swift Code', 'value' => null, 'type' => 'text', 'group' => 'bank', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'website', 'name' => 'Website', 'value' => null, 'type' => 'text', 'group' => 'links', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'facebook', 'name' => 'Facebook', 'value' => null, 'type' => 'text', 'group' => 'links', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'instagram', 'name' => 'Instagram', 'value' => null, 'type' => 'text', 'group' => 'links', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'linkedin', 'name' => 'Linkedin', 'value' => null, 'type' => 'text', 'group' => 'links', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'youtube', 'name' => 'YouTube', 'value' => null, 'type' => 'text', 'group' => 'links', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'twitter', 'name' => 'X', 'value' => null, 'type' => 'text', 'group' => 'links', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'currency', 'name' => 'Currency', 'value' => null, 'type' => 'select', 'group' => 'invoicing', 'required' => 1, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'invoice_seq_format', 'name' => 'Refence Format', 'value' => null, 'type' => 'text', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'invoice_seq_contains_year', 'name' => 'Sequence Contains the year?', 'value' => 1, 'type' => 'boolean', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'invoice_seq_starts', 'name' => 'Invoice Sequence Starts', 'value' => '001', 'type' => 'number', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'proforma_seq_starts', 'name' => 'Proforma Sequence Starts', 'value' => '001', 'type' => 'number', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'quotation_seq_starts', 'name' => 'Quotation Sequence Starts', 'value' => '001', 'type' => 'number', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'invoice_seq_skip_deleted', 'name' => 'Skip Deleted', 'value' => '0', 'type' => 'boolean', 'group' => 'invoicing', 'required' => 0, 'description' => 'System skips deleted references or reuse them', 'subscription' => 1],
            ['center_id' => 1, 'key' => 'invoice_payment_remind', 'name' => 'Payment Reminders', 'value' => '0', 'type' => 'boolean', 'group' => 'invoicing', 'required' => 0, 'description' => 'System will notify deal creator/collaborator If invoice is not paid after X number of days', 'subscription' => 2],
            ['center_id' => 1, 'key' => 'invoice_payment_remind_after', 'name' => 'Payment Reminders After', 'value' => '10', 'type' => 'number', 'group' => 'invoicing', 'required' => 0, 'description' => 'Number of Days', 'subscription' => 2],
            ['center_id' => 1, 'key' => 'show_invoice_note', 'name' => 'Show Invoice Note', 'value' => 1, 'type' => 'boolean', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'invoice_note_text', 'name' => 'Invoice Note', 'value' => 'Created using Squarely Business OS.', 'type' => 'text', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'show_quotation_note', 'name' => 'Show Quotation Note', 'value' => 1, 'type' => 'boolean', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'quotation_note_text', 'name' => 'Quotation Note', 'value' => 'Created using Squarely Business OS.', 'type' => 'text', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'show_proforma_note', 'name' => 'Show Proforma Note', 'value' => 1, 'type' => 'boolean', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'proforma_note_text', 'name' => 'Proforma Note', 'value' => 'Created using Squarely Business OS.', 'type' => 'text', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'departments', 'name' => 'Departments', 'value' => null, 'type' => 'multiselect', 'group' => 'hr', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'leave_policy', 'name' => 'Leave Policy', 'value' => '1', 'type' => 'select', 'group' => 'hr', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'leave_count_basis', 'name' => 'Leave Count Basis', 'value' => '1', 'type' => 'select', 'group' => 'hr', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'count_holidays', 'name' => 'Count Holidays', 'value' => 1, 'type' => 'boolean', 'group' => 'hr', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'request_approval', 'name' => 'Request Approval', 'value' => '1', 'type' => 'select', 'group' => 'hr', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'allow_reimbursable', 'name' => 'Allow Reimbursable', 'value' => 1, 'type' => 'boolean', 'group' => 'hr', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'reimbursable_account', 'name' => 'Reimbursable Accounts', 'value' => null, 'type' => 'select', 'group' => 'hr', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'org_require_phone', 'name' => 'Require Phone', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'org_require_email', 'name' => 'Require Email', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'org_require_one', 'name' => 'Require Phone or email', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'org_inactive_after', 'name' => 'Inactive After', 'value' => '4', 'type' => 'number', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'ind_require_phone', 'name' => 'Require Phone', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'ind_require_email', 'name' => 'Require email', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'ind_require_one', 'name' => 'Require Phone or email', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_industries', 'name' => 'Industries', 'value' => null, 'type' => 'multiselect', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_channels', 'name' => 'Channels', 'value' => null, 'type' => 'multiselect', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_calls', 'name' => 'Calls', 'value' => null, 'type' => 'multiselect', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_call_purposes', 'name' => 'Call Purpose', 'value' => null, 'type' => 'multiselect', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_meeting_purposes', 'name' => 'Meeting Purpose', 'value' => null, 'type' => 'multiselect', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_meeting_sections', 'name' => 'Meeting Sections', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_note_types', 'name' => 'Note Types', 'value' => null, 'type' => 'multiselect', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'crm_contact_records', 'name' => 'Show Contact Record', 'value' => 0, 'type' => 'boolean', 'group' => 'crm', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'lead_lost', 'name' => 'Lead Lost', 'value' => '2', 'type' => 'number', 'group' => 'sales', 'required' => 0, 'description' => 'Weeks', 'subscription' => 0],
            ['center_id' => 1, 'key' => 'quotation_lost', 'name' => 'Quotation Lost', 'value' => '2', 'type' => 'number', 'group' => 'sales', 'required' => 0, 'description' => 'Weeks', 'subscription' => 0],
            ['center_id' => 1, 'key' => 'occasion_types', 'name' => 'Occasion Types', 'value' => null, 'type' => 'multiselect', 'group' => 'sales', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'deal_approval', 'name' => 'Deal Approval', 'value' => 0, 'type' => 'boolean', 'group' => 'sales', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'locations', 'name' => 'Locations', 'value' => '2', 'type' => 'multiselect', 'group' => 'sales', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'open_deals_notification', 'name' => 'Open Deals Notification', 'value' => '3', 'type' => 'number', 'group' => 'sales', 'required' => 0, 'description' => 'Notify If Deals are not Closed after X months', 'subscription' => 0],
            ['center_id' => 1, 'key' => 'add_items_to_catalogue', 'name' => 'Add Items to Catalogue', 'value' => 0, 'type' => 'boolean', 'group' => 'sales', 'required' => 0, 'description' => 'Auto Add Item to Catalogue', 'subscription' => 0],
            ['center_id' => 1, 'key' => 'job_types', 'name' => 'Job Types', 'value' => null, 'type' => 'multiselect', 'group' => 'sales', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'job_stages', 'name' => 'Job Stages', 'value' => null, 'type' => 'multiselect', 'group' => 'sales', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'doc_types', 'name' => 'Document Types', 'value' => null, 'type' => 'multiselect', 'group' => 'document', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'doc_categories', 'name' => 'Document Categories', 'value' => null, 'type' => 'multiselect', 'group' => 'document', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'currencies', 'name' => 'Currencies', 'value' => null, 'type' => 'multiselect', 'group' => 'invoicing', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'expenses_accounts', 'name' => 'Expenses', 'value' => null, 'type' => 'multiselect', 'group' => 'accounts', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'cash_accounts', 'name' => 'Cash', 'value' => null, 'type' => 'multiselect', 'group' => 'accounts', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'banks_accounts', 'name' => 'Banks', 'value' => null, 'type' => 'multiselect', 'group' => 'accounts', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'payment_gateways_accounts', 'name' => 'Payment Gateways', 'value' => null, 'type' => 'multiselect', 'group' => 'accounts', 'required' => 0, 'description' => null, 'subscription' => 0],
            ['center_id' => 1, 'key' => 'assets_accounts', 'name' => 'Assets', 'value' => null, 'type' => 'multiselect', 'group' => 'accounts', 'required' => 0, 'description' => null, 'subscription' => 0],
        ]);

        $multiSelect = CenterParameter::where('type', 'multiselect')->select('id', 'key')->get()->keyBy('key')->toArray();
        $array = [
            'crm_industries' => ['Commercial', 'Residential', 'Mix Use', 'Project Supervision', 'Stands', 'Master Plan', 'Events & Stands'],
            'crm_channels' => ['Social Media', 'Referral', 'Direct Sales', 'Website', 'Email', 'Phone', 'Email Compaign', 'Other'],
            'crm_calls' => [],
            'crm_call_purposes' => ['Sales', 'Follow up', 'Operations', 'Production', 'Project Brief'],
            'crm_meeting_purposes' => ['Sales', 'project Brief', 'Site Visit', 'Contractor RFI', 'Suppliers', 'MEP', 'Structural', 'Internal'],
            'crm_note_types' => ['General', 'Ideas'],
            'occasion_types' => ['Commercial', 'Residential', 'Mix Use', 'Project Supervision', 'Stands', 'Master Plan', 'Evnets & Stands'],
            'locations' => ['Lebanon', 'UAE', 'KSA', 'UK'],
            'job_types' => ['Interior', 'Architecture', 'Architecture & Interior', 'Master Plan', 'Stands & Events', 'Master Plan & Architecture', 'Other'],
            'job_stages' => ['PRPSL', 'In Review', 'Project | In design', 'RFI', 'Construction Supervision'],
            'doc_types' => ['Contract', 'Passport', 'Visa', 'ID Card', 'Other'],
            'doc_categories' => ['Legal', 'Finance', 'HR', 'Sales', 'Jobs'],
            'currencies' => ['USD', 'AED', 'EUR', 'LBP'],
            'expenses_accounts' => ['General Expense'],
            'cash_accounts' => ['Cash '],
            'banks_accounts' => ['Bank'],
            'payment_gateways_accounts' => ['Payment Gateway'],
            'assets_accounts' => ['Assets'],
            'departments' => ['Management', 'Sales', 'Marketing', 'Finance', 'Design', 'Operations'],

        ];
        foreach ($array as $key => $value) {
            if (! isset($multiSelect[$key])) {
                continue; // skip if no multiselect parameter exists
            }

            $parameterId = $multiSelect[$key]['id'];

            $insertData = [];
            foreach ($value as $keyval => $val) {
                $insertData[] = [
                    'center_parameter_id' => $parameterId,
                    'value' => $val,
                    'order' => $keyval + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert all values at once
            if (! empty($insertData)) {
                CenterParameterValues::insert($insertData);
            }
        }
    }
}
