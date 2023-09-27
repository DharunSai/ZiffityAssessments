<?php

namespace Assessment\CustomerCommand\Api;

interface ProfileInterface
{
      /**
     * Import customer data from an array of data and save it in database.
     *
     * @param string $source
     */
    public function import($source);

}
