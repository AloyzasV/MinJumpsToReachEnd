<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    public function findShortestPath(Request $request)
    {
        $array = array();
        foreach ($request->input('numbers_array') as $key => $array_element) {
           array_push($array, $array_element['element']);
        }

        if (count($array)  <= 1) {
            return response()->json(['message' => 'Add more elments to array', 'path' => null, 'steps' => null]);
        }

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
                return response()->json(['message' => 'End of array is unreachable', 'path' => null, 'steps' => null]);
            }
        }
        return response()->json(['message' => 'You reached the end!', 'path' => $path, 'steps' => count($path)]);
    }
}
