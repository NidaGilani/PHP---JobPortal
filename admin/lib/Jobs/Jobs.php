<?php
class Jobs
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
            'id' => 'ID',
            'job_title' => 'Job Title',
            'job_type' => 'Job Type',
            'company_name' => 'Company Name',
            'author_id' => 'Author ID',
            'publish_date' => 'Published at',
            'updated_at' => 'Updated at'
        ];

        return $ordering;
    }
}
?>
