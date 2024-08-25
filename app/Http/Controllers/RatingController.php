<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Services\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;
    
    /**
     * Constructor to inject RatingService Class
     * @param App\Services\RatingService $ratingService 
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    /**
     * Display a listing rating.
     */
    public function index()
    {
        //
        return Rating::all();
    }

    /**
     * Store a newly rating in database.
     * @param Request $request
     * @return Illuminate\Http\JsonResponse;
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $rating = $this->ratingService->createRating($validatedData);
        return response()->json($rating, 201);
    }

     /**
     * Display the specified rating.
     * @param id of rating i want to show
     */
    public function show($id)
    {
        //
        return Rating::findOrFail($id);
    }

    /**
     * Update the specified rating in database.
     * @param Request $request
     * @param id of rating i want to update
     * @return jsonResponse
     */
    public function update(Request $request,$id)
    {
        //
        $validatedData = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'movie_id' => 'sometimes|required|exists:movies,id',
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $rating = Rating::findOrFail($id);
        $updatedRating = $this->ratingService->updateRating($rating, $validatedData);
        return response()->json($updatedRating, 200);
    }

    /**
     * Remove the specified rating from database
     * @param id of rating i want to delete 
     * @return null
     */
    public function destroy($id)
    {
        //
        $rating = Rating::findOrFail($id);
        $this->ratingService->deleteRating($rating);
        return response()->json(null, 204);
    }
}
