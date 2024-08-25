<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
class MovieController extends Controller
{

    protected $movieService;
    /**
     * Constructor to inject MovieService Class
     * @param App\Services\MovieService $movieservice 
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the movies.
     */
    public function index(Request $request)
    {
      $query = Movie::query();

      // Filtering by genre
      if ($request->has('genre')) {
          $query->byGenre($request->input('genre'));
      }
  
      // Filtering by director
      if ($request->has('director')) {
          $query->byDirector($request->input('director'));
      }

    
      //defult to sort movie by release_year asc
      $sortorder=$request->query('sort','asc');
      $query->orderBy('release_year',$sortorder);
  
      // Pagination
      $perPage = $request->input('per_page', 10);// default to 10 items per page if not specified
      $movies = $query->with('ratings')->paginate($perPage);
  
      return response()->json($movies);
    
    }
    /**
     * Store a newly movie in database.
     * @param Request $request
     * @return Illuminate\Http\JsonResponse;
     */
    public function store(Request $request)
    {
        //
      
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_year' => 'required|integer|min:1888|max:' . date('Y'),
            'description' => 'required|string',
        ]);

        $movie = $this->movieService->createMovie($validatedData);
        return response()->json($movie, 201);
        
       
    }

    /**
     * Display the specified movie.
     * @param id of movie i want to show
     */
    public function show($id)
    {
        
        $movie = Movie::with('ratings.user')->findOrFail($id);
        return response()->json($movie);
    }

    /**
     * Update the specified movie in database.
     * @param Request $request
     * @param id of movie i want to update
     * @return jsonResponse
     */
    public function update(Request $request,$id)
    {
        
       
          $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'director' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|required|string|max:255',
            'release_year' => 'sometimes|required|integer|min:1888|max:' . date('Y'),
            'description' => 'sometimes|required|string',
        ]);

        $movie = Movie::findOrFail($id);
        $updatedMovie = $this->movieService->updateMovie($movie, $validatedData);
        return response()->json($updatedMovie, 200);
    }

    
     /** 
      *Remove the specified movie.
      *@param id of movie i want to delete
      *return null 
      */ 
    
        public function destroy($id)
        {
            $movie = Movie::findOrFail($id);
            $this->movieService->deleteMovie($movie);
            return response()->json(null, 204);
        }   
}
