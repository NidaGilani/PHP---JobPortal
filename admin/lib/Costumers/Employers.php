<?php
class Employers
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'reg_no' => 'Reg_no',
            'company_name' => 'Company Name',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];

        return $ordering;
    }
}
?>
