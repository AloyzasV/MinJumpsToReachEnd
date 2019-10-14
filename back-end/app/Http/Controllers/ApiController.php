<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    public function findShortestPath(Request $request)
    {
       $array = array(2, 1, 1, 2, 3, 4, 5, 1, 2, 8);

       $steps[0] = 0;
       $path_key = 0;

       for ($i = 1; $i < count($array); $i++) {
            if ($steps[$i-1] !== PHP_INT_MAX) {
                $steps[$i] = PHP_INT_MAX;
                for ($j = 0; $j < $i; $j++) { 
                    if ($i <= $j + $array[$j]) { 
                        $steps[$i] = min($steps[$i], $steps[$j] + 1); 
                        break; 
                    } 
                }
                if ($steps[$i] > $steps[$i-1]) {
                    $path[$path_key++] = $array[$i-1];
                } 
            } else {
                return response()->json(['error' => 'End of array is unreachable']);
            }
        }
        return response()->json(['success' => 'You reached the end!', 'path' => $path, 'steps' => count($path)]);
    }
}
