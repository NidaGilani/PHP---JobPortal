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
            
            'deadline'      => 'Deadline',
            'publish_date'  => 'Published at',
            'job_cat'  => 'category',
            'loc'  => 'Location',
            
        ];
        
        return $ordering;
    }
    
}
?>
    