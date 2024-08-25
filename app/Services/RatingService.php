<?php

namespace App\Services;

use App\Models\Rating;

class RatingService
{   /**
    *function to create new rating 
    *@param data of rating that i want to insert in table(rating) 
    */
    public function createRating($data)
    {
        return Rating::create($data);
    }
    
    /**
     * function to update existing movie
     * @param rating i want to update
     * @param newly data
     * @return rating after update
     */
    public function updateRating(Rating $rating, $data)
    {
        $rating->update($data);
        return $rating;
    }
    
    /**
     * function to delete rating
     * @param rating i want to delete
     * @return null
     */
    public function deleteRating(Rating $rating)
    {
        $rating->delete();
    }
}

?>