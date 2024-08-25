<?php

namespace App\Services;

use App\Models\Movie;

class MovieService
{   /**
    *function to create new movie 
    *@param data of movie that i want to insert in table(movies) 
    */
    public function createMovie($data)
    {
        return Movie::create($data);
    }
    
    /**
     * function to update existing movie
     * @param movie i want to update
     * @param newly data
     * @return movie after update
     */
    public function updateMovie(Movie $movie, $data)
    {
        $movie->update($data);
        return $movie;
    }
    

    /**
     * function to delete movie
     * @param movie i want to delete
     * @return null
     */
    public function deleteMovie(Movie $movie)
    {
        $movie->delete();
        return response()->json(null, 204);
    }
}